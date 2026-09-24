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

	case 'setfee' :
	doSetFee();
	break;

}

function doInsert(){
	global $mydb;

	$ENROLLMENT_ID  = $_POST['ENROLLMENT_ID'];
	$FEE_TYPE_ID    = $_POST['FEE_TYPE_ID'];
	$AMOUNT_PAID    = $_POST['AMOUNT_PAID'];
	$PAYMENT_DATE   = $_POST['PAYMENT_DATE'];
	$PAYMENT_METHOD = $_POST['PAYMENT_METHOD'];
	$REMARKS        = $_POST['REMARKS'];

	$query = "INSERT INTO `tblcashier` (`ENROLLMENT_ID`, `FEE_TYPE_ID`, `AMOUNT_PAID`, `PAYMENT_DATE`, `PAYMENT_METHOD`, `REMARKS`)
		VALUES ('".$ENROLLMENT_ID."', '".$FEE_TYPE_ID."', '".$AMOUNT_PAID."', '".$PAYMENT_DATE."', '".$PAYMENT_METHOD."', '".$REMARKS."')";
	$mydb->setQuery($query);

	message("Payment has been recorded successfully!", "success");
	redirect('index.php');
}

function doEdit(){
	global $mydb;

	$UID = $_POST['UID'];

	$ENROLLMENT_ID  = $_POST['ENROLLMENT_ID1'];
	$FEE_TYPE_ID    = $_POST['FEE_TYPE_ID1'];
	$AMOUNT_PAID    = $_POST['AMOUNT_PAID1'];
	$PAYMENT_DATE   = $_POST['PAYMENT_DATE1'];
	$PAYMENT_METHOD = $_POST['PAYMENT_METHOD1'];
	$REMARKS        = $_POST['REMARKS1'];

	$query = "UPDATE `tblcashier` SET
		`ENROLLMENT_ID` = '".$ENROLLMENT_ID."',
		`FEE_TYPE_ID` = '".$FEE_TYPE_ID."',
		`AMOUNT_PAID` = '".$AMOUNT_PAID."',
		`PAYMENT_DATE` = '".$PAYMENT_DATE."',
		`PAYMENT_METHOD` = '".$PAYMENT_METHOD."',
		`REMARKS` = '".$REMARKS."'
		WHERE `PAYMENT_ID` = '".$UID."'";
	$mydb->setQuery($query);

	message("Payment has been Updated successfully!", "success");
	redirect('index.php');
}

function doDelete(){
	global $mydb;

	$id = $_GET['id'];

	$query = "DELETE FROM `tblcashier` WHERE `PAYMENT_ID` = '".$id."'";
	$mydb->setQuery($query);

	message("Payment record already Deleted!","info");
	redirect('index.php');
}

function doSetFee(){
	global $mydb;

	$ENROLLMENT_ID = $_POST['ENROLLMENT_ID_FEE'];
	$TOTAL_FEE     = $_POST['TOTAL_FEE'];

	$check = "SELECT ASSESSMENT_ID FROM `tblfeeassessment` WHERE ENROLLMENT_ID = '".$ENROLLMENT_ID."' LIMIT 1";
	$mydb->setQuery($check);
	$mydb->loadResultList();
	$exists = $mydb->num_rows();

	if ($exists >= 1) {
		$query = "UPDATE `tblfeeassessment` SET
			`TOTAL_FEE` = '".$TOTAL_FEE."',
			`DATE_ASSESSED` = CURDATE()
			WHERE `ENROLLMENT_ID` = '".$ENROLLMENT_ID."'";
	} else {
		$query = "INSERT INTO `tblfeeassessment` (`ENROLLMENT_ID`, `TOTAL_FEE`, `DATE_ASSESSED`)
			VALUES ('".$ENROLLMENT_ID."', '".$TOTAL_FEE."', CURDATE())";
	}
	$mydb->setQuery($query);

	message("Total fee has been saved successfully!", "success");
	redirect('index.php');
}

?>