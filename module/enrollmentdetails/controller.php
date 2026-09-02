<?php
require_once ("../../include/initialize.php");
global $mydb;

if (!isset($_SESSION['ACCOUNT_ID'])){

}

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;

	case 'edit' :
	doEdit();
	break;

	case 'delete' :
	doDelete();
	break;

}

function doInsert(){
	global $mydb;

	$ENROLLMENT_ID = $_POST['ENROLLMENT_ID'];
	$SUBJECT_ID    = $_POST['SUBJECT_ID'];

	$check = "SELECT DEATIL_ID FROM `tblenrollment_details` WHERE ENROLLMENT_ID = '".$ENROLLMENT_ID."' AND SUBJECT_ID = '".$SUBJECT_ID."' LIMIT 1";
	$mydb->setQuery($check);
	$mydb->loadResultList();
	$exists = $mydb->num_rows();

	if ($exists >= 1) {
		message("This subject is already added to that enrollment!", "error");
		redirect('index.php');
	} else {
		$query = "INSERT INTO `tblenrollment_details` (`ENROLLMENT_ID`, `SUBJECT_ID`)
			VALUES ('".$ENROLLMENT_ID."', '".$SUBJECT_ID."')";
		$mydb->setQuery($query);

		message("New Enrollment Subject has been added successfully!", "success");
		redirect('index.php');
	}
}

function doEdit(){
	global $mydb;

	$UID = $_POST['UID'];

	$ENROLLMENT_ID = $_POST['ENROLLMENT_ID1'];
	$SUBJECT_ID    = $_POST['SUBJECT_ID1'];

	$query = "UPDATE `tblenrollment_details` SET
		`ENROLLMENT_ID` = '".$ENROLLMENT_ID."',
		`SUBJECT_ID` = '".$SUBJECT_ID."'
		WHERE `DEATIL_ID` = '".$UID."'";
	$mydb->setQuery($query);

	message("Details has been Updated successfully!", "success");
	redirect('index.php');
}

function doDelete(){
	global $mydb;

	$id = $_GET['id'];

	$query = "DELETE FROM `tblenrollment_details` WHERE `DEATIL_ID` = '".$id."'";
	$mydb->setQuery($query);

	message("Enrollment Subject already Deleted!","info");
	redirect('index.php');
}

?>
