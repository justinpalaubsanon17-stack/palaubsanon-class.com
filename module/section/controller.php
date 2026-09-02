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

	$SECTION_NAME = $_POST['SECTION_NAME'];
	$YEAR_LEVEL   = $_POST['YEAR_LEVEL'];
	$course_id    = $_POST['COURSE_ID'];

	$check = "SELECT SECTION_ID FROM `tblsections` WHERE SECTION_NAME = '".$SECTION_NAME."' AND COURSE_ID = '".$course_id."' LIMIT 1";
	$mydb->setQuery($check);
	$mydb->loadResultList();
	$exists = $mydb->num_rows();

	if ($exists >= 1) {
		message("Section already exist for this course!", "error");
		redirect('index.php');
	} else {
		$query = "INSERT INTO `tblsections` (`SECTION_NAME`, `YEAR_LEVEL`, `COURSE_ID`)
			VALUES ('".$SECTION_NAME."', '".$YEAR_LEVEL."', '".$course_id."')";
		$mydb->setQuery($query);

		message("New Section [". $SECTION_NAME ."] has been created successfully!", "success");
		redirect('index.php');
	}
}

function doEdit(){
	global $mydb;

	$UID = $_POST['UID'];

	$SECTION_NAME = $_POST['SECTION_NAME1'];
	$YEAR_LEVEL   = $_POST['YEAR_LEVEL1'];
	$course_id    = $_POST['COURSE_ID1'];

	$query = "UPDATE `tblsections` SET
		`SECTION_NAME` = '".$SECTION_NAME."',
		`YEAR_LEVEL` = '".$YEAR_LEVEL."',
		`COURSE_ID` = '".$course_id."'
		WHERE `SECTION_ID` = '".$UID."'";
	$mydb->setQuery($query);

	message("Details has been Updated successfully!", "success");
	redirect('index.php');
}

function doDelete(){
	global $mydb;

	$id = $_GET['id'];

	$query = "DELETE FROM `tblsections` WHERE `SECTION_ID` = '".$id."'";
	$mydb->setQuery($query);

	message("Section already Deleted!","info");
	redirect('index.php');
}

?>
