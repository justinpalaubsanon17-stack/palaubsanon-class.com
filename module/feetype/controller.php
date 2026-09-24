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

	$fee_type_name = $_POST['fee_type_name'];
	$description   = $_POST['description'];

	$check = "SELECT fee_type_id FROM `tblfeetypes` WHERE fee_type_name = '".$fee_type_name."' LIMIT 1";
	$mydb->setQuery($check);
	$mydb->loadResultList();
	$exists = $mydb->num_rows();

	if ($exists >= 1) {
		message("That fee type already exists!", "error");
		redirect('index.php');
	} else {
		$query = "INSERT INTO `tblfeetypes` (`fee_type_name`, `description`)
			VALUES ('".$fee_type_name."', '".$description."')";
		$mydb->setQuery($query);

		message("New Fee Type [". $fee_type_name ."] has been created successfully!", "success");
		redirect('index.php');
	}
}

function doEdit(){
	global $mydb;

	$UID = $_POST['UID'];

	$fee_type_name = $_POST['fee_type_name1'];
	$description   = $_POST['description1'];

	$query = "UPDATE `tblfeetypes` SET
		`fee_type_name` = '".$fee_type_name."',
		`description` = '".$description."'
		WHERE `fee_type_id` = '".$UID."'";
	$mydb->setQuery($query);

	message("Fee Type has been Updated successfully!", "success");
	redirect('index.php');
}

function doDelete(){
	global $mydb;

	$id = $_GET['id'];

	// Don't delete a fee type that's already used on a recorded payment -
	// that would leave old payments pointing at a fee type that no longer exists.
	$check = "SELECT payment_id FROM `tblcashier` WHERE fee_type_id = '".$id."' LIMIT 1";
	$mydb->setQuery($check);
	$mydb->loadResultList();
	$inUse = $mydb->num_rows();

	if ($inUse >= 1) {
		message("This fee type is already used on one or more payments and can't be deleted.", "error");
		redirect('index.php');
	} else {
		$query = "DELETE FROM `tblfeetypes` WHERE `fee_type_id` = '".$id."'";
		$mydb->setQuery($query);

		message("Fee Type already Deleted!","info");
		redirect('index.php');
	}
}

?>
