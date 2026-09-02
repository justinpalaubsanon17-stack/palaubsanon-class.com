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

	$SUBJECT_CODE = $_POST['SUBJECT_CODE'];
	$SUBJECT_NAME = $_POST['SUBJECT_NAME'];
	$UNITS        = $_POST['UNITS'];
	$SEMESTER     = $_POST['SEMESTER'];
	$YEAR_LEVEL   = $_POST['YEAR_LEVEL'];
	$course_id    = $_POST['COURSE_ID'];

	$check = "SELECT SUBJECT_ID FROM `tblsubjects` WHERE SUBJECT_CODE = '".$SUBJECT_CODE."' LIMIT 1";
	$mydb->setQuery($check);
	$mydb->loadResultList();
	$exists = $mydb->num_rows();

	if ($exists >= 1) {
		message("Subject Code already exist!", "error");
		redirect('index.php');
	} else {
		$query = "INSERT INTO `tblsubjects` (`SUBJECT_CODE`, `SUBJECT_NAME`, `UNITS`, `SEMESTER`, `YEAR_LEVEL`, `COURSE_ID`)
			VALUES ('".$SUBJECT_CODE."', '".$SUBJECT_NAME."', '".$UNITS."', '".$SEMESTER."', '".$YEAR_LEVEL."', '".$course_id."')";
		$mydb->setQuery($query);

		message("New Subject [". $SUBJECT_CODE ."] has been created successfully!", "success");
		redirect('index.php');
	}
}

function doEdit(){
	global $mydb;

	$UID = $_POST['UID'];

	$SUBJECT_CODE = $_POST['SUBJECT_CODE1'];
	$SUBJECT_NAME = $_POST['SUBJECT_NAME1'];
	$UNITS        = $_POST['UNITS1'];
	$SEMESTER     = $_POST['SEMESTER1'];
	$YEAR_LEVEL   = $_POST['YEAR_LEVEL1'];
	$course_id    = $_POST['COURSE_ID1'];

	$query = "UPDATE `tblsubjects` SET
		`SUBJECT_CODE` = '".$SUBJECT_CODE."',
		`SUBJECT_NAME` = '".$SUBJECT_NAME."',
		`UNITS` = '".$UNITS."',
		`SEMESTER` = '".$SEMESTER."',
		`YEAR_LEVEL` = '".$YEAR_LEVEL."',
		`COURSE_ID` = '".$course_id."'
		WHERE `SUBJECT_ID` = '".$UID."'";
	$mydb->setQuery($query);

	message("Details has been Updated successfully!", "success");
	redirect('index.php');
}

function doDelete(){
	global $mydb;

	$id = $_GET['id'];

	$query = "DELETE FROM `tblsubjects` WHERE `SUBJECT_ID` = '".$id."'";
	$mydb->setQuery($query);

	message("Subject already Deleted!","info");
	redirect('index.php');
}

?>
