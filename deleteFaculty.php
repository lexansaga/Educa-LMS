<?php
	require 'config/db.php';
	
	$id = $_GET['id'];
	$facultyid = $_GET['facultyid'];
	$sql = "DELETE FROM faculty WHERE id='$id'";	
	$result = mysqli_query($connection, $sql);
	$sql1 = "DELETE FROM faculty_loads WHERE faculty_id='$facultyid'";	
	$result = mysqli_query($connection, $sql1);
	if ($result == TRUE) 
		{
			$_SESSION['delete-success'] = "1 row successfully deleted!";
			header('location: faculty-module.php');
			exit();
		}
?>