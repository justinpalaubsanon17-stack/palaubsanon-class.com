<?php
require_once("../../include/initialize.php");
global $mydb;

if (isset($_POST['UID'])) {
	$output = array();
	$query =	"SELECT * FROM `tblfeetypes`
		WHERE fee_type_id = '".$_POST["UID"]."'
		LIMIT 1";
	$mydb->setQuery($query);
	$result = $mydb->loadResultList();

	foreach($result as $row)
	{
		$output["fee_type_id"]   = $row->fee_type_id;
		$output["fee_type_name"] = $row->fee_type_name;
		$output["description"]   = $row->description;
	}
	echo json_encode($output);
}else{
	$output = array();
	$query = "SELECT `fee_type_id`, `fee_type_name`, `description`, `created_at` FROM `tblfeetypes`";

	if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '')
	{
	$query .= " WHERE `fee_type_name` LIKE '%".$_POST["search"]["value"]."%'
		OR `description` LIKE '%".$_POST["search"]["value"]."%' ";
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY `fee_type_id` ASC ';
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
		$sub_array[] = $result->fee_type_name;
		$sub_array[] = $result->description;
		$sub_array[] = $result->created_at;

		$sub_array[] = '

		<button type="button" name="update" UID="'.$result->fee_type_id.'" class="btn btn-warning btn-xs editEntry"><span class="fa fa-edit fw-fa"></span></button>

		<a href="index.php?view=view&id='.$result->fee_type_id.'"><button type="button" class="btn btn-info btn-xs" title="View"><span class="fa fa-eye"></span></button></a>

		<a href="controller.php?action=delete&id='.$result->fee_type_id .'" onclick="return confirm(\'Delete this fee type?\');"><button type="button" class="btn btn-danger btn-xs SaveReg"><span class="fa fa-trash fw-fa"></span> Del</button></a>

		';
		$data[] = $sub_array;
	$i = $i + 1;
	}
	function get_total_all_records()
	{
		global $mydb;
		$statement = "SELECT `fee_type_id` FROM `tblfeetypes`";
		$mydb->setQuery($statement);
		return $mydb->num_rows();
	}

	$output = array('data' 			   => $data,
					"recordsTotal"	   => $filtered_rows,
					"recordsFiltered"	=>	get_total_all_records() );
	echo json_encode($output);
}
?>
