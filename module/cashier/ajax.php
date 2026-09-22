<?php
require_once("../../include/initialize.php");
global $mydb;

// Guarantee that ONLY valid JSON is ever sent to the browser, even if a
// stray notice/warning happens somewhere upstream (this is what was
// causing DataTables' "Invalid JSON response" error).
ob_start();
header('Content-Type: application/json');

if (isset($_POST['UID'])) {
	$output = array();
	$query = "SELECT * FROM `tblcashier`
		WHERE PAY_ID = '".(int)$_POST["UID"]."'
		LIMIT 1";
	$mydb->setQuery($query);
	$result = $mydb->loadResultList();

	if (is_array($result)) {
		foreach ($result as $row) {
			$output["PAY_ID"]      = $row->PAY_ID;
			$output["student_id"]  = $row->student_id;
			$output["sy_id"]       = $row->sy_id;
			$output["amount_due"]  = $row->amount_due;
			$output["amount_paid"] = $row->amount_paid;
			$output["balance"]     = $row->balance;
			$output["payment_date"]= $row->payment_date;
		}
	}

	ob_end_clean();
	echo json_encode($output);
} else {
	$output = array();

	$query = "SELECT c.`PAY_ID`, c.`student_id`, c.`amount_due`, c.`amount_paid`, c.`balance`,
					 c.`payment_date`,
					 CONCAT(s.`LNAME`, ', ', s.`FNAME`, ' ', s.`MNAME`) AS student_name,
					 sy.`school_year`, sy.`semester`
			  FROM `tblcashier` c
			  LEFT JOIN `tblstudent` s ON s.`S_ID` = c.`student_id`
			  LEFT JOIN `tblschoolyear` sy ON sy.`sy_id` = c.`sy_id`";

	if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') {
		$searchValue = addslashes($_POST["search"]["value"]);
		$query .= " WHERE s.`LNAME` LIKE '%".$searchValue."%' ";
	}

	// Whitelist of columns that are actually safe/meaningful to sort by,
	// keyed by the 0-based DataTables column index (matches the <thead>
	// order in list.php). This replaces blindly concatenating whatever
	// $_POST['order'][0]['column'] contains, which could be an out-of-range
	// or non-existent SQL column position and break the query entirely.
	$orderableColumns = array(
		1 => 's.`LNAME`',        // Student
		2 => 'sy.`school_year`', // School Year
		3 => 'c.`amount_due`',
		4 => 'c.`amount_paid`',
		5 => 'c.`balance`',
		6 => 'c.`payment_date`',
	);

	$orderColumn = 'c.`PAY_ID`';
	$orderDir    = 'DESC';

	if (isset($_POST["order"][0]["column"])) {
		$colIndex = (int)$_POST["order"][0]["column"];
		if (isset($orderableColumns[$colIndex])) {
			$orderColumn = $orderableColumns[$colIndex];
		}
		if (isset($_POST["order"][0]["dir"]) && strtolower($_POST["order"][0]["dir"]) === 'asc') {
			$orderDir = 'ASC';
		} else {
			$orderDir = 'DESC';
		}
	}

	$query .= " ORDER BY ".$orderColumn." ".$orderDir." ";

	$length = isset($_POST["length"]) ? (int)$_POST["length"] : 10;
	$start  = isset($_POST["start"]) ? (int)$_POST["start"] : 0;

	if ($length != -1) {
		$query .= " LIMIT " . $start . ", " . $length . "";
	}

	$mydb->setQuery($query);
	$cur = $mydb->loadResultList();
	$data = array();
	$filtered_rows = $mydb->num_rows();
	$i = $start + 1;

	if (is_array($cur)) {
		foreach ($cur as $result) {
			$sub_array = array();

			$sub_array[] = $i;
			$sub_array[] = $result->student_name;
			$sub_array[] = $result->school_year.' - '.$result->semester;
			$sub_array[] = number_format($result->amount_due, 2);
			$sub_array[] = number_format($result->amount_paid, 2);
			$sub_array[] = number_format($result->balance, 2);
			$sub_array[] = $result->payment_date;

			$sub_array[] = '

			<button type="button" name="update" UID="'.$result->PAY_ID.'" class="btn btn-warning btn-xs editEntry"><span class="fa fa-edit fw-fa"></span></button>

			<a href="index.php?view=view&id='.$result->student_id.'"><button type="button" class="btn btn-info btn-xs" title="View Student Payment History"><span class="fa fa-eye"></span></button></a>

			<a href="receipt.php?id='.$result->PAY_ID.'" target="_blank"><button type="button" class="btn btn-secondary btn-xs" title="Print Receipt"><span class="fa fa-print"></span></button></a>

			<a href="controller.php?action=delete&id='.$result->PAY_ID.'"><button type="button" class="btn btn-danger btn-xs" onclick="return confirm(\'Delete this payment record?\');"><span class="fa fa-trash fw-fa"></span> Del</button></a>

			';
			$data[] = $sub_array;
			$i = $i + 1;
		}
	}

	function get_total_all_records()
	{
		global $mydb;
		$statement = "SELECT `PAY_ID` FROM `tblcashier`";
		$mydb->setQuery($statement);
		$mydb->loadResultList();
		return $mydb->num_rows();
	}

	$output = array(
		'data'            => $data,
		"recordsTotal"    => get_total_all_records(),
		"recordsFiltered" => $filtered_rows,
	);

	ob_end_clean();
	echo json_encode($output);
}