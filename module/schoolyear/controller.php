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

	$SCHOOL_YEAR = $_POST['SCHOOL_YEAR'];
	$SEMESTER    = $_POST['SEMESTER'];
	$STATUS      = $_POST['STATUS'];

	$check = "SELECT SY_ID FROM `tblschoolyear` WHERE SCHOOL_YEAR = '".$SCHOOL_YEAR."' AND SEMESTER = '".$SEMESTER."' LIMIT 1";
	$mydb->setQuery($check);
	$mydb->loadResultList();
	$exists = $mydb->num_rows();

	if ($exists >= 1) {
		message("School Year & Semester already exist!", "error");
		redirect('index.php');
	} else {
		$query = "INSERT INTO `tblschoolyear` (`SCHOOL_YEAR`, `SEMESTER`, `STATUS`)
			VALUES ('".$SCHOOL_YEAR."', '".$SEMESTER."', '".$STATUS."')";
		$mydb->setQuery($query);

		message("New School Year [". $SCHOOL_YEAR ."] has been created successfully!", "success");
		redirect('index.php');
	}
}

function doEdit(){
	global $mydb;

	$UID = $_POST['UID'];

	$SCHOOL_YEAR = $_POST['SCHOOL_YEAR1'];
	$SEMESTER    = $_POST['SEMESTER1'];
	$STATUS      = $_POST['STATUS1'];

	$query = "UPDATE `tblschoolyear` SET
		`SCHOOL_YEAR` = '".$SCHOOL_YEAR."',
		`SEMESTER` = '".$SEMESTER."',
		`STATUS` = '".$STATUS."'
		WHERE `SY_ID` = '".$UID."'";
	$mydb->setQuery($query);

	message("Details has been Updated successfully!", "success");
	redirect('index.php');
}

function doDelete(){
	global $mydb;

	$id = $_GET['id'];

	$query = "DELETE FROM `tblschoolyear` WHERE `SY_ID` = '".$id."'";
	$mydb->setQuery($query);

	message("School Year already Deleted!","info");
	redirect('index.php');
}

?>
