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

	$STUDENT_ID      = $_POST['STUDENT_ID'];
	$SY_ID           = $_POST['SY_ID'];
	$ENROLLMENT_DATE = $_POST['ENROLLMENT_DATE'];

	$check = "SELECT ENROLLMENT_ID FROM `tblenrollment` WHERE STUDENT_ID = '".$STUDENT_ID."' AND SY_ID = '".$SY_ID."' LIMIT 1";
	$mydb->setQuery($check);
	$mydb->loadResultList();
	$exists = $mydb->num_rows();

	if ($exists >= 1) {
		message("This student is already enrolled for that school year!", "error");
		redirect('index.php');
	} else {
		$query = "INSERT INTO `tblenrollment` (`STUDENT_ID`, `SY_ID`, `ENROLLMENT_DATE`)
			VALUES ('".$STUDENT_ID."', '".$SY_ID."', '".$ENROLLMENT_DATE."')";
		$mydb->setQuery($query);

		message("New Enrollment has been created successfully!", "success");
		redirect('index.php');
	}
}

function doEdit(){
	global $mydb;

	$UID = $_POST['UID'];

	$STUDENT_ID      = $_POST['STUDENT_ID1'];
	$SY_ID           = $_POST['SY_ID1'];
	$ENROLLMENT_DATE = $_POST['ENROLLMENT_DATE1'];

	$query = "UPDATE `tblenrollment` SET
		`STUDENT_ID` = '".$STUDENT_ID."',
		`SY_ID` = '".$SY_ID."',
		`ENROLLMENT_DATE` = '".$ENROLLMENT_DATE."'
		WHERE `ENROLLMENT_ID` = '".$UID."'";
	$mydb->setQuery($query);

	message("Details has been Updated successfully!", "success");
	redirect('index.php');
}

function doDelete(){
	global $mydb;

	$id = $_GET['id'];

	$query = "DELETE FROM `tblenrollment` WHERE `ENROLLMENT_ID` = '".$id."'";
	$mydb->setQuery($query);

	message("Enrollment already Deleted!","info");
	redirect('index.php');
}

?>
