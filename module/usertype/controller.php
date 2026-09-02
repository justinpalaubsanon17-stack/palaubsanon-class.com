<?php

//TAGANILE SOLUTIONS - TAGANILE 2025

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


		$Usertype = new Usertype();
		$USERTYPE	= $_POST['usertype'];
		$STATUS = $_POST['STATUS'];

		$res = $Usertype->find_all_usertype($USERTYPE);


			if ($res >=1) {
				message("Username already exist!", "error");
				redirect('index.php');
			}else{

				$Usertype->USERTYPE = $USERTYPE;
				$Usertype->STATUS = $STATUS;

				 $istrue = $Usertype->create();
				 if ($istrue == true){

				 	message("New User [". $USERTYPE ."] has been created successfully!", "success");
				 	redirect('index.php');

				 }else{
				 	message("No user type has been created successfully!", "error");
				 	redirect('index.php');
				 }
			}

	}




	function doEdit(){
		if (isset($_POST['edit'])) {
			$Usertype = new Usertype();
			$TYPEID	= $_POST['TYPEID'];
			$USERTYPE	= $_POST['USERTYPE'];
			$STATUS = $_POST['STATUS'];


			$Usertype->USERTYPE = $USERTYPE;
			$Usertype->STATUS = $STATUS;

			 $istrue = $Usertype->update($TYPEID);
			 if ($istrue == true){

			 	message("User Type [". $USERTYPE ."] has been Updated successfully!", "success");
			 	redirect('index.php');

			 }else{
			 	message("No user type has been updated successfully!", "error");
			 	redirect('index.php');
			 }

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

				$user = New User();
	 		 	$user->delete($id);

			message("User already Deleted!","info");
			redirect('index.php');
		// }
		// }


	}

	function doupdateimage(){

			$errofile = $_FILES['photo']['error'];
			$type = $_FILES['photo']['type'];
			$temp = $_FILES['photo']['tmp_name'];
			$myfile =$_FILES['photo']['name'];
		 	$location="photos/".$myfile;


		if ( $errofile > 0) {
				message("No Image Selected!", "error");
				redirect("index.php?view=view&id=". $_GET['id']);
		}else{

				@$file=$_FILES['photo']['tmp_name'];
				@$image= addslashes(file_get_contents($_FILES['photo']['tmp_name']));
				@$image_name= addslashes($_FILES['photo']['name']);
				@$image_size= getimagesize($_FILES['photo']['tmp_name']);

			if ($image_size==FALSE ) {
				message("Uploaded file is not an image!", "error");
				redirect("index.php?view=view&id=". $_GET['id']);
			}else{
					//uploading the file
					move_uploaded_file($temp,"photos/" . $myfile);



						$user = New User();
						$user->USERIMAGE 			= $location;
						$user->update($_SESSION['USERID']);
						redirect("index.php");


			}
		}

	}

?>
