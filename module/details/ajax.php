<?php 
require_once("../../include/initialize.php");
global $mydb;

if (isset($_POST['UID'])) {
	$output = array();
	$query =	"SELECT * FROM `alumni_details` 
		WHERE AlumniID = '".$_POST["UID"]."' 
		LIMIT 1";
	$mydb->setQuery($query);
	$result = $mydb->loadResultList();

	foreach($result as $row)
	{ 
		$output["UID"]             = $row->AlumniID;
		$output["InstitutionName"] = $row->InstitutionName;
		$output["Degree"]          = $row->Degree;
		$output["FieldOfStudy"]    = $row->FieldOfStudy;
		$output["StartDate"]       = $row->StartDate;
		$output["EndDate"]         = $row->EndDate;
		$output["logo"]            = $row->logo;
		$output["description"]     = $row->description;
	}
	echo json_encode($output);
}else{
	$output = array();
	$query = "SELECT `AlumniID`, `InstitutionName`, `Degree`, `FieldOfStudy`, `StartDate`, `EndDate` FROM `alumni_details`";

	if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '')
	{
	$query .= " where `InstitutionName` LIKE '%".$_POST["search"]["value"]."%' 
		OR `Degree` LIKE '%".$_POST["search"]["value"]."%' 
		OR `FieldOfStudy` LIKE '%".$_POST["search"]["value"]."%' ";
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY `AlumniID` DESC ';
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
		// `InstitutionName`, `Degree`, `FieldOfStudy`, `StartDate`, `EndDate`
		$sub_array = array();

		$sub_array[] = $i;

		$sub_array[] = $result->InstitutionName;
		$sub_array[] = $result->Degree;
		$sub_array[] = $result->FieldOfStudy;
		$sub_array[] = $result->StartDate;
		$sub_array[] = $result->EndDate;

		$sub_array[] = '

		<button type="button" name="update" UID="'.$result->AlumniID.'" class="btn btn-warning btn-xs editEntry"><span class="fa fa-edit fw-fa"></span></button> 
		
		<a href="index.php?view=view&id='.$result->AlumniID.'"><button type="button" class="btn btn-info btn-xs" title="View"><span class="fa fa-eye"></span></button></a>

		<a href="controller.php?action=delete&id='.$result->AlumniID .'"><button type="button" class="btn btn-danger btn-xs SaveReg" ><span class="fa fa-trash fw-fa"></span> Del</button></a>


		';
		$data[] = $sub_array;
		$i = $i + 1;		
	}
	function get_total_all_records()
	{
		global $mydb;
		$statement = "SELECT `AlumniID` FROM `alumni_details`";
		$mydb->setQuery($statement);
		return $mydb->num_rows();
	}

	$output = array('data' 			   => $data, 
					"recordsTotal"	   => $filtered_rows,
					"recordsFiltered"	=>	get_total_all_records() );
	echo json_encode($output);
}
?>
