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

	$InstitutionName = $_POST['InstitutionName'];
	$Degree          = $_POST['Degree'];
	$FieldOfStudy    = $_POST['FieldOfStudy'];
	$StartDate       = $_POST['StartDate'];
	$EndDate         = $_POST['EndDate'];
	$logo            = $_POST['logo'];
	$description     = $_POST['description'];

	$query = "INSERT INTO `alumni_details` (`InstitutionName`, `Degree`, `FieldOfStudy`, `StartDate`, `EndDate`, `logo`, `description`)
		VALUES ('".$InstitutionName."', '".$Degree."', '".$FieldOfStudy."', '".$StartDate."', '".$EndDate."', '".$logo."', '".$description."')";
	$mydb->setQuery($query);

	message("New Detail has been added successfully!", "success");
	redirect('index.php');
}

function doEdit(){
	global $mydb;

	$UID = $_POST['UID'];

	$InstitutionName = $_POST['InstitutionName1'];
	$Degree          = $_POST['Degree1'];
	$FieldOfStudy    = $_POST['FieldOfStudy1'];
	$StartDate       = $_POST['StartDate1'];
	$EndDate         = $_POST['EndDate1'];
	$logo            = $_POST['logo1'];
	$description     = $_POST['description1'];

	$query = "UPDATE `alumni_details` SET
		`InstitutionName` = '".$InstitutionName."',
		`Degree` = '".$Degree."',
		`FieldOfStudy` = '".$FieldOfStudy."',
		`StartDate` = '".$StartDate."',
		`EndDate` = '".$EndDate."',
		`logo` = '".$logo."',
		`description` = '".$description."'
		WHERE `AlumniID` = '".$UID."'";
	$mydb->setQuery($query);

	message("Details has been Updated successfully!", "success");
	redirect('index.php');
}

function doDelete(){
	global $mydb;

	$id = $_GET['id'];

	$query = "DELETE FROM `alumni_details` WHERE `AlumniID` = '".$id."'";
	$mydb->setQuery($query);

	message("Detail already Deleted!","info");
	redirect('index.php');
}

?>
