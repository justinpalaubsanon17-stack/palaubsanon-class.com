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
	$course = new Course();

	$course_code = $_POST['course_code'];
	$course_name = $_POST['course_name'];

	$res = $course->find_all_course($course_code);

	if ($res >= 1) {
		message("Course code already exists!", "error");
		redirect('index.php');
	} else {
		$course->course_code = $course_code;
		$course->course_name = $course_name;

		$istrue = $course->create();

		if ($istrue == true) {
			message("New Course [" . $course_code . "] has been created successfully!", "success");
			redirect('index.php');
		} else {
			message("No course has been created successfully!", "error");
			redirect('index.php');
		}
	}
}

function doEdit(){
	$course = new Course();

	$UID = $_POST['UID'];
	$course_code = $_POST['course_code'];
	$course_name = $_POST['course_name'];

	$course->course_code = $course_code;
	$course->course_name = $course_name;

	$istrue = $course->update($UID);

	if ($istrue == true) {
		message("Course has been Updated successfully!", "success");
		redirect('index.php');
	} else {
		message("No course has been updated successfully!", "error");
		redirect('index.php');
	}
}

function doDelete(){
	$id = $_GET['id'];
	$course = new Course();
	$course->delete($id);

	message("Course has been Deleted!", "info");
	redirect('index.php');
}
?>
