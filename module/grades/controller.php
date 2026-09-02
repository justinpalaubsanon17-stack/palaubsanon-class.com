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
	$MIDTERM       = $_POST['MIDTERM'];
	$FINAL         = $_POST['FINAL'];
	$AVERAGE       = round(((float)$MIDTERM + (float)$FINAL) / 2, 2);
	$REMARKS       = $_POST['REMARKS'];

	$check = "SELECT GRADE_ID FROM `tblgrades` WHERE ENROLLMENT_ID = '".$ENROLLMENT_ID."' AND SUBJECT_ID = '".$SUBJECT_ID."' LIMIT 1";
	$mydb->setQuery($check);
	$mydb->loadResultList();
	$exists = $mydb->num_rows();

	if ($exists >= 1) {
		message("A grade for this subject already exists for that enrollment!", "error");
		redirect('index.php');
	} else {
		$query = "INSERT INTO `tblgrades` (`ENROLLMENT_ID`, `SUBJECT_ID`, `MIDTERM`, `FINAL`, `AVERAGE`, `REMARKS`)
			VALUES ('".$ENROLLMENT_ID."', '".$SUBJECT_ID."', '".$MIDTERM."', '".$FINAL."', '".$AVERAGE."', '".$REMARKS."')";
		$mydb->setQuery($query);

		message("New Grade has been added successfully!", "success");
		redirect('index.php');
	}
}

function doEdit(){
	global $mydb;

	$UID = $_POST['UID'];

	$ENROLLMENT_ID = $_POST['ENROLLMENT_ID1'];
	$SUBJECT_ID    = $_POST['SUBJECT_ID1'];
	$MIDTERM       = $_POST['MIDTERM1'];
	$FINAL         = $_POST['FINAL1'];
	$AVERAGE       = round(((float)$MIDTERM + (float)$FINAL) / 2, 2);
	$REMARKS       = $_POST['REMARKS1'];

	$query = "UPDATE `tblgrades` SET
		`ENROLLMENT_ID` = '".$ENROLLMENT_ID."',
		`SUBJECT_ID` = '".$SUBJECT_ID."',
		`MIDTERM` = '".$MIDTERM."',
		`FINAL` = '".$FINAL."',
		`AVERAGE` = '".$AVERAGE."',
		`REMARKS` = '".$REMARKS."'
		WHERE `GRADE_ID` = '".$UID."'";
	$mydb->setQuery($query);

	message("Details has been Updated successfully!", "success");
	redirect('index.php');
}

function doDelete(){
	global $mydb;

	$id = $_GET['id'];

	$query = "DELETE FROM `tblgrades` WHERE `GRADE_ID` = '".$id."'";
	$mydb->setQuery($query);

	message("Grade already Deleted!","info");
	redirect('index.php');
}

?>
