<?php 
require_once("../../include/initialize.php");
global $mydb;

if (isset($_POST['UID'])) {
	$output = array();
	$query =	"SELECT * FROM `tblgrades` 
		WHERE GRADE_ID = '".$_POST["UID"]."' 
		LIMIT 1";
	$mydb->setQuery($query);
	$result = $mydb->loadResultList();

	foreach($result as $row)
	{ 
		$output["UID"]           = $row->GRADE_ID;
		$output["ENROLLMENT_ID"] = $row->ENROLLMENT_ID;
		$output["SUBJECT_ID"]    = $row->SUBJECT_ID;
		$output["MIDTERM"]       = $row->MIDTERM;
		$output["FINAL"]         = $row->FINAL;
		$output["AVERAGE"]       = $row->AVERAGE;
		$output["REMARKS"]       = $row->REMARKS;
	}
	echo json_encode($output);
}else{
	$output = array();
	$query = "SELECT g.`GRADE_ID`, g.`ENROLLMENT_ID`, g.`SUBJECT_ID`, g.`MIDTERM`, g.`FINAL`, g.`AVERAGE`, g.`REMARKS`,
		s.`FNAME`, s.`LNAME`, sy.`SCHOOL_YEAR`, sy.`SEMESTER`,
		sub.`SUBJECT_CODE`, sub.`SUBJECT_NAME`
		FROM `tblgrades` g
		LEFT JOIN `tblenrollment` e ON e.`ENROLLMENT_ID` = g.`ENROLLMENT_ID`
		LEFT JOIN `tblstudent` s ON s.`S_ID` = e.`STUDENT_ID`
		LEFT JOIN `tblschoolyear` sy ON sy.`SY_ID` = e.`SY_ID`
		LEFT JOIN `tblsubjects` sub ON sub.`SUBJECT_ID` = g.`SUBJECT_ID`";

	if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '')
	{
	$query .= " WHERE s.`FNAME` LIKE '%".$_POST["search"]["value"]."%' 
		OR s.`LNAME` LIKE '%".$_POST["search"]["value"]."%' 
		OR sub.`SUBJECT_NAME` LIKE '%".$_POST["search"]["value"]."%' 
		OR sub.`SUBJECT_CODE` LIKE '%".$_POST["search"]["value"]."%' ";
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY g.`GRADE_ID` DESC ';
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

		$sub_array[] = trim($result->LNAME.', '.$result->FNAME);
		$sub_array[] = $result->SCHOOL_YEAR.' - '.$result->SEMESTER;
		$sub_array[] = $result->SUBJECT_CODE.' - '.$result->SUBJECT_NAME;
		$sub_array[] = $result->MIDTERM;
		$sub_array[] = $result->FINAL;
		$sub_array[] = $result->AVERAGE;
		$sub_array[] = $result->REMARKS;

		$sub_array[] = '

		<button type="button" name="update" UID="'.$result->GRADE_ID.'" class="btn btn-warning btn-xs editEntry"><span class="fa fa-edit fw-fa"></span></button> 
		
		<a href="index.php?view=view&id='.$result->GRADE_ID.'"><button type="button" class="btn btn-info btn-xs" title="View"><span class="fa fa-eye"></span></button></a>

		<a href="controller.php?action=delete&id='.$result->GRADE_ID .'"><button type="button" class="btn btn-danger btn-xs SaveReg" ><span class="fa fa-trash fw-fa"></span> Del</button></a>

		';
		$data[] = $sub_array;
	$i = $i + 1;		
	}
	function get_total_all_records()
	{
		global $mydb;
		$statement = "SELECT `GRADE_ID` FROM `tblgrades`";
		$mydb->setQuery($statement);
		return $mydb->num_rows();
	}

	$output = array('data' 			   => $data, 
					"recordsTotal"	   => $filtered_rows,
					"recordsFiltered"	=>	get_total_all_records() );
	echo json_encode($output);
}
?>
