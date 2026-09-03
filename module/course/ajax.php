<?php
require_once("../../include/initialize.php");
global $mydb;

if (isset($_POST['UID'])) {
	$output = array();
	$query = "SELECT * FROM `tblcourses`
		WHERE course_id = '".$_POST["UID"]."'
		LIMIT 1";
	$mydb->setQuery($query);
	$result = $mydb->loadResultList();

	foreach($result as $row) {
		$output["course_id"] = $row->course_id;
		$output["course_code"] = $row->course_code;
		$output["course_name"] = $row->course_name;
	}
	echo json_encode($output);
} else {
	$output = array();
	$query = "SELECT `course_id`, `course_code`, `course_name`, `created_at` FROM `tblcourses`";

	if(isset($_POST["search"]["value"])) {
		$query .= " WHERE `course_code` LIKE '%".$_POST["search"]["value"]."%' OR `course_name` LIKE '%".$_POST["search"]["value"]."%' ";
	}

	if(isset($_POST["order"])) {
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	} else {
		$query .= 'ORDER BY `course_id` DESC ';
	}

	if($_POST["length"] != -1) {
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
		$sub_array[] = $result->course_code;
		$sub_array[] = $result->course_name;
		$sub_array[] = $result->created_at;

		$sub_array[] = '
			<button type="button" name="update" UID="'.$result->course_id.'" class="btn btn-warning btn-xs editEntry"><span class="fa fa-edit fw-fa"></span></button>
			<button type="button" name="view" UID="'.$result->course_id.'" class="btn btn-info btn-xs viewcourse"><span class="fa fa-eye"></span></button>
			<button type="button" name="print" UID="'.$result->course_id.'" class="btn btn-secondary btn-xs printcourse"><span class="fa fa-print"></span></button>
			<a href="controller.php?action=delete&id='.$result->course_id .'"><button type="button" class="btn btn-danger btn-xs SaveReg"><span class="fa fa-trash fw-fa"></span> Del</button></a>
		';

		$data[] = $sub_array;
		$i = $i + 1;
	}

	function get_total_all_records() {
		global $mydb;
		$statement = "SELECT `course_id`, `course_code`, `course_name`, `created_at` FROM `tblcourses`";
		$mydb->setQuery($statement);
		return $mydb->num_rows();
	}

	$output = array('data' 			   => $data,
					"recordsTotal"	   => $filtered_rows,
					"recordsFiltered"	=> get_total_all_records() );
	echo json_encode($output);
}
?>