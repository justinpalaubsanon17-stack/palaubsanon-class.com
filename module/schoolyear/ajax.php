<?php 
require_once("../../include/initialize.php");
global $mydb;

if (isset($_POST['UID'])) {
	$output = array();
	$query =	"SELECT * FROM `tblschoolyear` 
		WHERE SY_ID = '".$_POST["UID"]."' 
		LIMIT 1";
	$mydb->setQuery($query);
	$result = $mydb->loadResultList();

	foreach($result as $row)
	{ 
		$output["UID"]          = $row->sy_id;
		$output["SCHOOL_YEAR"]  = $row->school_year;
		$output["SEMESTER"]     = $row->semester;
		$output["STATUS"]       = $row->status;
	}
	echo json_encode($output);
}else{
	$output = array();
	$query = "SELECT `SY_ID`, `SCHOOL_YEAR`, `SEMESTER`, `STATUS`
		FROM `tblschoolyear`";

	if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '')
	{
	$query .= " WHERE `SCHOOL_YEAR` LIKE '%".$_POST["search"]["value"]."%' 
		OR `SEMESTER` LIKE '%".$_POST["search"]["value"]."%' 
		OR `STATUS` LIKE '%".$_POST["search"]["value"]."%' ";
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY `SY_ID` DESC ';
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

		$sub_array[] = $result->SCHOOL_YEAR;
		$sub_array[] = $result->SEMESTER;

		$status_badge = ($result->STATUS == 'Open')
			? '<span class="badge badge-success">Open</span>'
			: '<span class="badge badge-secondary">Closed</span>';
		$sub_array[] = $status_badge;

		$sub_array[] = '

		<button type="button" name="update" UID="'.$result->SY_ID.'" class="btn btn-warning btn-xs editEntry"><span class="fa fa-edit fw-fa"></span></button> 
		
		<a href="index.php?view=view&id='.$result->SY_ID.'"><button type="button" class="btn btn-info btn-xs" title="View"><span class="fa fa-eye"></span></button></a>

		<a href="controller.php?action=delete&id='.$result->SY_ID .'"><button type="button" class="btn btn-danger btn-xs SaveReg" ><span class="fa fa-trash fw-fa"></span> Del</button></a>

		';
		$data[] = $sub_array;
	$i = $i + 1;		
	}
	function get_total_all_records()
	{
		global $mydb;
		$statement = "SELECT `SY_ID` FROM `tblschoolyear`";
		$mydb->setQuery($statement);
		return $mydb->num_rows();
	}

	$output = array('data' 			   => $data, 
					"recordsTotal"	   => $filtered_rows,
					"recordsFiltered"	=>	get_total_all_records() );
	echo json_encode($output);
}
?>