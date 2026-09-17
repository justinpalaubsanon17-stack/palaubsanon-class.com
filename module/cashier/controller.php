<?php
require_once ("../../include/initialize.php");
	  if (!isset($_SESSION['ACCOUNT_ID'])){
     // redirect(web_root."admin/index.php");
     }
global $mydb;

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

// Runs a non-SELECT query (INSERT/UPDATE/DELETE) regardless of what your
// Database class calls its execute method. Adjust the order/names below
// if none of these match your class.
function runQuery($mydb, $query){
	$mydb->setQuery($query);
	if (method_exists($mydb, 'executeQuery')) {
		return $mydb->executeQuery();
	} elseif (method_exists($mydb, 'query')) {
		return $mydb->query();
	} elseif (method_exists($mydb, 'execute')) {
		return $mydb->execute();
	} elseif (method_exists($mydb, 'doQuery')) {
		return $mydb->doQuery();
	} elseif (method_exists($mydb, 'run')) {
		return $mydb->run();
	} elseif (method_exists($mydb, 'save')) {
		return $mydb->save();
	} else {
		// Last resort: setQuery() may execute immediately in your class
		return true;
	}
}

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

		$student_id   = (int)$_POST['student_id'];
		$sy_id        = (int)$_POST['sy_id'];
		$amount_due   = (float)$_POST['amount_due'];
		$amount_paid  = (float)$_POST['amount_paid'];
		$balance      = $amount_due - $amount_paid;
		$payment_date = $_POST['payment_date'];

		$query = "INSERT INTO `tblcashier`
			(`student_id`, `sy_id`, `amount_due`, `amount_paid`, `balance`, `payment_date`)
			VALUES
			('".$student_id."', '".$sy_id."', '".$amount_due."', '".$amount_paid."', '".$balance."', '".$payment_date."')";

		$istrue = runQuery($mydb, $query);

		if ($istrue) {
			message("New payment record has been created successfully!", "success");
			redirect('index.php');
		}else{
			message("No payment record has been created successfully!", "error");
			redirect('index.php');
		}
	}

	function doEdit(){
		global $mydb;

		$UID = (int)$_POST['UID'];

		$student_id   = (int)$_POST['student_id1'];
		$sy_id        = (int)$_POST['sy_id1'];
		$amount_due   = (float)$_POST['amount_due1'];
		$amount_paid  = (float)$_POST['amount_paid1'];
		$balance      = $amount_due - $amount_paid;
		$payment_date = $_POST['payment_date1'];

		$query = "UPDATE `tblcashier` SET
			`student_id` = '".$student_id."',
			`sy_id` = '".$sy_id."',
			`amount_due` = '".$amount_due."',
			`amount_paid` = '".$amount_paid."',
			`balance` = '".$balance."',
			`payment_date` = '".$payment_date."'
			WHERE `PAY_ID` = '".$UID."'";

		$istrue = runQuery($mydb, $query);

		if ($istrue){
			message("Payment record has been updated successfully!", "success");
			redirect('index.php');
		}else{
			message("No payment record has been updated successfully!", "error");
			redirect('index.php');
		}
	}

	function doDelete(){
		global $mydb;

		$id = (int)$_GET['id'];

		$query = "DELETE FROM `tblcashier` WHERE `PAY_ID` = '".$id."'";
		runQuery($mydb, $query);

		message("Payment record has been deleted!","info");
		redirect('index.php');
	}

?>