<?php 
require_once("../../include/initialize.php");
global $mydb;

if (isset($_POST['UID'])) {
	$output = array();
	$query =	"SELECT * FROM `tblstudent` 
		WHERE S_ID = '".$_POST["UID"]."' 
		LIMIT 1";
	$mydb->setQuery($query);
	$result = $mydb->loadResultList();

	foreach($result as $row)
	{ 
		$output["UID"] = $row->S_ID;
		$output["IDNO"] = $row->IDNO;
		$output["FNAME"] = $row->FNAME;
		$output["MNAME"] = $row->MNAME;
		$output["LNAME"] = $row->LNAME;
		$output["SEX"] = $row->SEX;
		$output["BDAY"] = $row->BDAY;
		// $output["TYPE"] = $row->TYPE;
		// $output["STATUSACTIVE"] = $row->STATUSACTIVE;
				
	}
	echo json_encode($output);
}else{
	$output = array();
	$query = "SELECT `S_ID`, `LNAME`, `FNAME`, `MNAME`, `SEX`, `BDAY` FROM `tblstudent`";

	if(isset($_POST["search"]["value"]))
	{
	$query .= " where `LNAME` LIKE '%".$_POST["search"]["value"]."%' ";
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY `S_ID` DESC ';
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
				// `IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY`, `BPLACE`
	$sub_array = array();
		
		$sub_array[] =$i;
	
		$sub_array[] = $result->LNAME;
		$sub_array[] = $result->FNAME;
		$sub_array[] = $result->MNAME;
		$sub_array[] = $result->SEX;
		$sub_array[] = $result->BDAY;
		
		$sub_array[] = '

		<button type="button" name="update" UID="'.$result->S_ID.'" class="btn btn-warning btn-xs editEntry"><span class="fa fa-edit fw-fa"></span></button> 
		
		<a href="index.php?view=view&id='.$result->S_ID.'"><button type="button" class="btn btn-info btn-xs" title="View"><span class="fa fa-eye"></span></button></a>

		<a href="controller.php?action=delete&id='.$result->S_ID .'"><button type="button" class="btn btn-danger btn-xs SaveReg" ><span class="fa fa-trash fw-fa"></span> Del</button></a>


		';
		$data[] = $sub_array;
	$i = $i + 1;		
	}
	function get_total_all_records()
	{
		global $mydb;
		$statement = "SELECT `S_ID`, `LNAME`, `FNAME`, `MNAME`, `SEX`, `BDAY` FROM `tblstudent`";
		$mydb->setQuery($statement);
		return $mydb->num_rows();
	}

	$output = array('data' 			   => $data, 
					"recordsTotal"	   => $filtered_rows,
					"recordsFiltered"	=>	get_total_all_records() );
	echo json_encode($output);
}
?>