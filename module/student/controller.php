<?php
require_once ("../../include/initialize.php");
	  if (!isset($_SESSION['ACCOUNT_ID'])){
     // redirect(web_root."admin/index.php");
     }

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

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
  //``IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY`
 
		
	 
		$student = new Student();

		$IDNO   = $_POST['IDNO'];
		$FNAME	= $_POST['FNAME'];
		$LNAME 	= $_POST['LNAME'];
		$MNAME 		= $_POST['MNAME'];
		$SEX 		= $_POST['SEX'];
		$BDAY  = $_POST['BDAY'];
		$BPLACE = $_POST['BPLACE'];

		$res = $student->find_all_student($IDNO);
		
		
			if ($res >=1) {
				message("Student IDNO already exist!", "error");
				redirect('index.php');
			}else{
				
				$student->IDNO = $IDNO;
				$student->FNAME = $FNAME;
				$student->LNAME = $LNAME;
				$student->MNAME 	= $MNAME;
				$student->SEX 	= $SEX;
				$student->BDAY 	= $BDAY;
				$student->BPLACE = $BPLACE;

				 
				 $istrue = $student->create(); 
				 
				 		if ($istrue == true) {
					 		message("New Student [". $IDNO ."] has been created successfully!", "success");
					 		redirect('index.php');
					 	}else{
					 		message("No user has been created successfully!", "error");
					 		redirect('index.php');
					 	}
			}	 

	}
	function doEdit(){

			$student = new Student();

			$UID   = $_POST['UID'];

			//`IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY``

			$IDNO   = $_POST['IDNO1'];
			$FNAME	= $_POST['FNAME1'];
			$MNAME	= $_POST['MNAME1'];
			$LNAME	= $_POST['LNAME1'];
			$SEX	= $_POST['SEX1'];
			$BDAY	= $_POST['BDAY1'];
			$BPLACE = $_POST['BPLACE1'];
					
					
				$student->IDNO = $IDNO;
				$student->FNAME = $FNAME;
				$student->MNAME = $MNAME;
				$student->LNAME = $LNAME;
				$student->SEX 	= $SEX;
				$student->BDAY 	= $BDAY;
				$student->BPLACE = $BPLACE;
				 
				 $istrue = $student->update($UID); 
				 if ($istrue == true){
				 	
				 	message("Details has been Updated successfully!", "success");
				 	redirect('index.php');
				 	
				 }else{
				 	message("No user account has been updated successfully!", "error");
				 	redirect('index.php');
				 }
		
	
	}


	


	function doDelete(){
		
		// if (isset($_POST['selector'])==''){
		// message("Select the records first before you delete!","info");
		// redirect('index.php');
		// }else{

		// $id = $_POST['selector'];
		// $key = count($id);

		// for($i=0;$i<$key;$i++){

		// 	$user = New User();
		// 	$user->delete($id[$i]);

		
				$id = 	$_GET['id'];

				$student = New Student();
	 		 	$student->delete($id);
			 
			message("Student already Deleted!","info");
			redirect('index.php');
		// }
		// }
		// }

		
	}

	
?>