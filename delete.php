<?php
	require 'config/db.php';
	
	$id = $_GET['id'];
	$studid = $_GET['studid'];
	$sql = "DELETE FROM `students` WHERE id=$id";	


	
	$result = mysqli_query($connection, $sql);

	$sql1 = "DELETE FROM `course_enrolled` WHERE idnum='$studid'";	

	$result = mysqli_query($connection, $sql1);

	$sql2 = "DELETE FROM `studentrecords` WHERE idnum='$studid'";	

	$result = mysqli_query($connection, $sql2);
	
	if ($result == TRUE) 
		{
			$_SESSION['delete-success'] = "1 row successfully deleted!";
			header('location: student-module.php');
			exit();
		}
?>