<?php
/*
	support/journal_edit.php
	
	access: support_write

	Allows the addition or adjustment of journal entries.
*/

if (user_permissions_get('support_write'))
{
	$id = $_GET["id"];
	
	// nav bar options.
	$_SESSION["nav"]["active"]	= 1;
	
	$_SESSION["nav"]["title"][]	= "Support Ticket Details";
	$_SESSION["nav"]["query"][]	= "page=support/view.php&id=$id";

	$_SESSION["nav"]["title"][]	= "Support Ticket Journal";
	$_SESSION["nav"]["query"][]	= "page=support/journal.php&id=$id";
	$_SESSION["nav"]["current"]	= "page=support/journal.php&id=$id";
	
	$_SESSION["nav"]["title"][]	= "Delete Support Ticket";
	$_SESSION["nav"]["query"][]	= "page=support/delete.php&id=$id";


	function page_render()
	{
		$id		= security_script_input('/^[0-9]*$/', $_GET["id"]);
		$journalid	= security_script_input('/^[0-9]*$/', $_GET["journalid"]);
		$action		= security_script_input('/^[a-z]*$/', $_GET["action"]);
		$type		= security_script_input('/^[a-z]*$/', $_GET["type"]);

		
		/*
			Journal Forms
		*/

		$journal_form = New journal_input;
			
		// basic details of this entry
		$journal_form->prepare_set_journalname("support_tickets");
		$journal_form->prepare_set_journalid($journalid);
		$journal_form->prepare_set_customid($id);

		// set the processing form
		$journal_form->prepare_set_form_process_page("support/journal-edit-process.php");

		
		if ($action == "delete")
		{
			print "<h3>SUPPORT JOURNAL - DELETE ENTRY</h3><br>";
			print "<p>This page allows you to delete an entry from the support journal.</p>";

			// render delete form
			$journal_form->render_delete_form();		

		}
		else
		{
			if ($type == "file")
			{
				// file uploader
				if ($journalid)
				{
					print "<h3>SUPPORT JOURNAL - UPLOAD FILE</h3><br>";
					print "<p>This page allows you to attach a file to the support journal.</p>";
				}
				else
				{
					print "<h3>SUPPORT JOURNAL - UPLOAD FILE</h3><br>";
					print "<p>This page allows you to attach a file to the support journal.</p>";
				}

				// edit or add file
				$journal_form->render_file_form();
			}
			else
			{
				// default to text
				if ($journalid)
				{
					print "<h3>SUPPORT JOURNAL - EDIT ENTRY</h3><br>";
					print "<p>This page allows you to edit an existing entry in the support journal.</p>";
				}
				else
				{
					print "<h3>SUPPORT JOURNAL - ADD ENTRY</h3><br>";
					print "<p>This page allows you to add an entry to the support journal.</p>";
				}

				// edit or add
				$journal_form->render_text_form();		
			}
			
		}
		


	} // end page_render

} // end of if logged in
else
{
	error_render_noperms();
}

?>