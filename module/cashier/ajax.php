<?php
require_once("../../include/initialize.php");
global $mydb;

if (isset($_POST['UID'])) {
	$output = array();
	$query = "SELECT * FROM `tblcashier`
		WHERE PAY_ID = '".(int)$_POST["UID"]."'
		LIMIT 1";
	$mydb->setQuery($query);
	$result = $mydb->loadResultList();

	foreach($result as $row)
	{
		$output["PAY_ID"]      = $row->PAY_ID;
		$output["student_id"]  = $row->student_id;
		$output["sy_id"]       = $row->sy_id;
		$output["amount_due"]  = $row->amount_due;
		$output["amount_paid"] = $row->amount_paid;
		$output["balance"]     = $row->balance;
		$output["payment_date"]= $row->payment_date;
	}
	echo json_encode($output);
}else{
	$output = array();
	$query = "SELECT c.`PAY_ID`, c.`student_id`, c.`amount_due`, c.`amount_paid`, c.`balance`,
					 c.`payment_date`,
					 CONCAT(s.`LNAME`, ', ', s.`FNAME`, ' ', s.`MNAME`) AS student_name,
					 sy.`school_year`, sy.`semester`
			  FROM `tblcashier` c
			  LEFT JOIN `tblstudent` s ON s.`S_ID` = c.`student_id`
			  LEFT JOIN `tblschoolyear` sy ON sy.`sy_id` = c.`sy_id`";

	if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '')
	{
	$query .= " WHERE s.`LNAME` LIKE '%".$_POST["search"]["value"]."%' ";
	}
	if(isset($_POST["order"]))
	{
		$query .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= ' ORDER BY c.`PAY_ID` DESC ';
	}
	if($_POST["length"] != -1)
	{
		$query .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'] . "";
	}
	$mydb->setQuery($query);
	$cur = $mydb->loadResultList();
	$data = array();
	$filtered_rows = $mydb->num_rows();
	$i = 1;
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

		<a href="controller.php?action=delete&id='.$result->PAY_ID.'"><button type="button" class="btn btn-danger btn-xs" onclick="return confirm(\'Delete this payment record?\');"><span class="fa fa-trash fw-fa"></span> Del</button></a>

		';
		$data[] = $sub_array;
		$i = $i + 1;
	}
	function get_total_all_records()
	{
		global $mydb;
		$statement = "SELECT `PAY_ID` FROM `tblcashier`";
		$mydb->setQuery($statement);
		return $mydb->num_rows();
	}

	$output = array('data' 			=> $data,
					"recordsTotal"	   => $filtered_rows,
					"recordsFiltered"	=>	get_total_all_records() );
	echo json_encode($output);
}
?>