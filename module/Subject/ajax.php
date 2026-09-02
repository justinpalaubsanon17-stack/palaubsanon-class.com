<?php 
require_once("../../include/initialize.php");
global $mydb;

if (isset($_POST['UID'])) {
	$output = array();
	$query =	"SELECT * FROM `tblsubjects` 
		WHERE SUBJECT_ID = '".$_POST["UID"]."' 
		LIMIT 1";
	$mydb->setQuery($query);
	$result = $mydb->loadResultList();

	foreach($result as $row)
	{ 
		$output["UID"]           = $row->SUBJECT_ID;
		$output["SUBJECT_CODE"]  = $row->SUBJECT_CODE;
		$output["SUBJECT_NAME"]  = $row->SUBJECT_NAME;
		$output["UNITS"]         = $row->UNITS;
		$output["SEMESTER"]      = $row->SEMESTER;
		$output["YEAR_LEVEL"]    = $row->YEAR_LEVEL;
		$output["COURSE_ID"]     = $row->COURSE_ID;
	}
	echo json_encode($output);
}else{
	$output = array();
	$query = "SELECT s.`SUBJECT_ID`, s.`SUBJECT_CODE`, s.`SUBJECT_NAME`, s.`UNITS`, s.`SEMESTER`, s.`YEAR_LEVEL`, s.`COURSE_ID`, c.`course_name`
		FROM `tblsubjects` s
		LEFT JOIN `tblcourses` c ON c.`course_id` = s.`COURSE_ID`";

	if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '')
	{
	$query .= " WHERE s.`SUBJECT_NAME` LIKE '%".$_POST["search"]["value"]."%' 
		OR s.`SUBJECT_CODE` LIKE '%".$_POST["search"]["value"]."%' ";
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY s.`SUBJECT_ID` DESC ';
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

		$sub_array[] = $result->SUBJECT_CODE;
		$sub_array[] = $result->SUBJECT_NAME;
		$sub_array[] = $result->UNITS;
		$sub_array[] = $result->SEMESTER;
		$sub_array[] = $result->YEAR_LEVEL;
		$sub_array[] = $result->course_name;

		$sub_array[] = '

		<button type="button" name="update" UID="'.$result->SUBJECT_ID.'" class="btn btn-warning btn-xs editEntry"><span class="fa fa-edit fw-fa"></span></button> 
		
		<a href="index.php?view=view&id='.$result->SUBJECT_ID.'"><button type="button" class="btn btn-info btn-xs" title="View"><span class="fa fa-eye"></span></button></a>

		<a href="controller.php?action=delete&id='.$result->SUBJECT_ID .'"><button type="button" class="btn btn-danger btn-xs SaveReg" ><span class="fa fa-trash fw-fa"></span> Del</button></a>

		';
		$data[] = $sub_array;
	$i = $i + 1;		
	}
	function get_total_all_records()
	{
		global $mydb;
		$statement = "SELECT `SUBJECT_ID` FROM `tblsubjects`";
		$mydb->setQuery($statement);
		return $mydb->num_rows();
	}

	$output = array('data' 			   => $data, 
					"recordsTotal"	   => $filtered_rows,
					"recordsFiltered"	=>	get_total_all_records() );
	echo json_encode($output);
}
?>
