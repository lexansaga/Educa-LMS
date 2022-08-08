<?php
	require 'config/db.php';
	
	$id = $_GET['id'];
	
	$sql = "DELETE FROM sections WHERE id=$id";	
	echo $sql;
    return ;
	$result = mysqli_query($connection, $sql);
	
	if ($result == TRUE) 
		{
			$_SESSION['delete-success'] = "1 row successfully deleted!";
			header('location: view-program.php');
			exit();
		}
?>