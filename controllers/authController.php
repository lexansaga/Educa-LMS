<?php

use Symfony\Component\Serializer\Encoder\JsonDecode;

	session_start();
	
	require 'config/db.php';
	require_once 'emailController.php';
	$errors = array();
	$username = "";
	$email = "";
	
	error_reporting(E_ERROR | E_PARSE);
	
	//************************* LOGIN *************************
	if (isset($_POST['login'])) {
		$username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
		$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
		
		
		// VALIDATION
		if (empty($username) && empty($password)) {
			$errors['login'] = "Unknown user or password";
		}
		if (empty($username) || empty($password)) {
			$errors['login'] = "Unknown user or password";
		}
		//IF NO ERRORS
		if (count($errors) == 0) {
			$sql = "SELECT * FROM users WHERE email=? OR username=? Limit 1";
			$stmt = $connection->prepare($sql);
			$stmt->bind_param('ss', $username, $username);
			$stmt->execute();
			$result = $stmt->get_result();
			$user = $result->fetch_assoc();
			
			if ($user['verified'] == 0) {
				$errors['login'] = "Unknown user or password";
			}
			else {
				if (password_verify($password, $user['password'])) {
				$_SESSION['id'] = $user['id'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['email'] = $user['email'];
				// SET FLASH MESSAGE
				$_SESSION['message'] = "You are now logged in!";
				$_SESSION['alert-class'] = "alert-sucess";
				header('location: admin-dashboard.php');
				exit();
				}
				else if ($password == $user['password']) {
					$_SESSION['id'] = $user['id'];
					$_SESSION['username'] = $user['username'];
					$_SESSION['email'] = $user['email'];
					// SET FLASH MESSAGE
					$_SESSION['message'] = "You are now logged in!";
					$_SESSION['alert-class'] = "alert-sucess";
					header('location: admin-dashboard.php');
					exit();
				}
				else {
					$errors['login'] = "Unknown user or password";
				}
			}
		}
	}
	/**************************** ADD NEW FEES ***************************/
	if(isset($_POST['add-new-fees'])){
		$idnum = htmlspecialchars($_POST['idnum']);
		$term = htmlspecialchars($_POST['term']);
		$expensename = htmlspecialchars($_POST['expensename']);
		$expenseprice = htmlspecialchars($_POST['expenseprice']);
		$result = mysqli_query ($connection, "SELECT * FROM students WHERE idnum = '$idnum' ");
		$sql = "SELECT * FROM students WHERE idnum = '$idnum'";
		$updateBalS = mysqli_query($connection, $sql);
		while ($r1 = mysqli_fetch_array($updateBalS)) {
			$currentBal = $r1['balance'];
		}
		$balance = intval($currentBal) + intval($expenseprice);
		$sql1 = "UPDATE students SET balance = $balance WHERE idnum = '$idnum'";
		$updateBal = mysqli_query($connection, $sql1);
		while ($r = mysqli_fetch_array($result)) {
			if(isset($r['extrafees'])){
				$oldJson = json_decode($r['extrafees']);
				if(isset($oldJson->$term)){
					array_push($oldJson->$term,array('expensename'=>$expensename,'ispaid'=>false,'expenseprice'=>$expenseprice));
				}else{
					$oldJson->$term = array(array('expensename'=>$expensename,'expenseprice'=>$expenseprice,'ispaid'=>false));
				}
				$modJson = json_encode($oldJson);
			}else{
				$freshArr = array();
				$freshArr[$term] = array(array('expensename'=>$expensename,'expenseprice'=>$expenseprice,'ispaid'=>false));
				$modJson = json_encode($freshArr);
			}
			
			mysqli_query($connection,"UPDATE students SET extrafees = '$modJson' WHERE id = {$r['id']} ");
			header("location: payment-module.php?id=".$r['id']);
			exit();
		}
		
		
	}
	/**************************** ENROLL BUTTON ***************************/
	if (isset($_POST['enroll-success'])) {
		
		$id =  htmlspecialchars($_POST['id']);
		$idnum =  htmlspecialchars($_POST['idnum']);
		$entlev = $_POST['entlev'];
		$fname = htmlspecialchars($_POST['fname']);
		$mname = htmlspecialchars($_POST['mname']);
		$lname = htmlspecialchars($_POST['lname']);
		$gender = $_POST['gender'];
		$cnum = htmlspecialchars($_POST['cnum']);
		$program = htmlspecialchars($_POST['program']);
		$email = htmlspecialchars($_POST['email']);
		$prevschool = htmlspecialchars($_POST['prevschool']);
		$username = $lname ."". $fname[0] ."". $mname[0] . "@educa.edu.ph";
		$hea = $_POST['hea'];
		
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailErr = "Invalid email format";
		return;
		}
		// FOR UPLOADING IMAGE
		$img = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
		if (!empty($_FILES['image']['name'])) {
			if (!in_array($img, ["jpg", "png", "jpeg"])){
				$errors['file'] = "File type is Invalid";
				return;
			}
		} else { $errors['1'] = "All field is required"; 
			return;
		}


		if(empty($_POST['pass'])||empty($_POST['passConf'])){
			$errors['1'] = "All field is required";
			return;
		}

		if(!empty($_POST['pass'])&&!empty($_POST['passConf'])&&$_POST['pass']!=$_POST['passConf']){
			$errors['1'] = "Password do not match";
			return;
		}
		$image = time() . '_' . $_FILES['image']['name'];
		
		// FOR UPLOADING PDF FILES
		$upload_file = pathinfo($_FILES['g_moral']['name'], PATHINFO_EXTENSION);
		$upload_file1 = pathinfo($_FILES['NSO']['name'], PATHINFO_EXTENSION);
		
		if (!empty($_FILES['g_moral']['name'])) {
			if (!in_array($upload_file, ["pdf"])){
				$errors['file'] = "File type is Invalid";
			}
		} else { 
			$errors['1'] = "All field is required"; 
			return;
		}
		
		if (!empty($_FILES['NSO']['name'])) {
			if (!in_array($upload_file1, ["pdf"])){
				$errors['file1'] = "File type is Invalid";
				return;
			}
		} else { 
			$errors['1'] = "All field is required";
			return;
		 }
		
		$g_moral = time() . '_' . $_FILES['g_moral']['name'];
		$NSO = time() . '_' . $_FILES['NSO']['name'];
		
		// IMAGE FILE DIR IN LOCAL
		$target = "data/images/".basename($image);
		
		// VALIDATION IF EMPTY
		
		if (empty($fname)) {
			$errors['1'] = "All field is required";
			return;
		}
		if (empty($mname)) {
			$errors['1'] = "All field is required";
			return;
		}
		if (empty($lname)) {
			$errors['1'] = "All field is required";
			return;
		}
		if (empty($program)) {
			$errors['1'] = "All field is required";
			return;
		}
		if (empty($gender)) {
			$errors['1'] = "All field is required";
			return;
		}
		if (empty($cnum)) {
			$errors['1'] = "All field is required";
			return;
		}
		if (empty($email)) {
			$errors['1'] = "All field is required";
			return;
			
		} else {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = "Email address is invalid";
			return;
			}
			
		}
	
	
		
		//CHECK EMAIL IF EXISTING IN DATABASE
		if(isset($email)){
			$emailQuery = "SELECT * From students WHERE email=? Limit 1";
			$stmt = $connection->prepare($emailQuery);
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$result=$stmt->get_result();
			$userCount = $result->num_rows;
			$stmt->close();
		}
		
		if ($userCount > 0) {
			$errors['email'] = "Email Error!";
			return;
		}
		//********************* IF NO ERRORS ***************************
		if (count($errors) == 0) {
			date_default_timezone_set('Asia/Manila');
			$reg_date = date("F j\, Y \| g:i A", time());
			$mypass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
			$sql = "INSERT INTO students (idnum, fname, mname, lname, entlev, program,username,
				gender, cnum, email, prevschool, hea, img, g_moral, NSO, reg_date, password) VALUES (?, ?,?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
			$stmt = $connection->prepare($sql);
			$stmt->bind_param('sssssssssssssssss', $idnum, $fname, $mname, $lname, 
				$entlev,$program, strtolower($username),$gender, $cnum, $email, $prevschool, $hea, $image, 
				$g_moral, $NSO, $reg_date, $mypass);
			
			move_uploaded_file($_FILES['image']['tmp_name'], $target);
			move_uploaded_file($_FILES['g_moral']['tmp_name'], "data/files/GMORAL/".$g_moral);
			move_uploaded_file($_FILES['NSO']['tmp_name'], "data/files/NSO/".$NSO);
			
			if ($stmt->execute()) {
				// LOGIN USER
				$user_id = $connection->insert_id;
				$_SESSION['id'] = $user_id;
				
				// SEND VERIFICATION IN EMAIL
				//sendVerificationEmail($email, $token, $OTP);

				// SET FLASH MESSAGE
				$_SESSION['message'] = "New student successfully added!";
				$_SESSION['alert-class'] = "alert-sucess";
				header("location: student-module.php");
				exit();
			}
			else  {

				$errors['db_error'] = "Database error: failed to register";
			}
		}
		else {
			if ($counter == 9) {
				$errors['1'] = "All field is required";
			}
		}
		mysqli_close($connection);
	}
	
	
	
	
	
	
	//************************* LOGOUT ****************************
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['id']);
		unset($_SESSION['username']);
		unset($_SESSION['email']);
		unset($_SESSION['verified']);
		header('location: index.php');
	}
	
	
	
	//************************* ENROLLMENT BUTTON ****************************
	if (isset($_POST['add'])) {
		header('location: enroll-student-submodule.php');
	}
	if (isset($_POST['enroll-backbtn'])) {
		header('location: student-module.php');
	}
	
	
	//************************* ENROLLMENT COURSE ****************************
	if (isset($_POST['addrecord'])) {
		
		$id = htmlspecialchars($_POST['id']);
		$idnum = htmlspecialchars($_POST['idnumber']);
		$name = htmlspecialchars($_POST['wholename']);
		$startdate = htmlspecialchars($_POST['startdate']);
		
		
		$entlev = htmlspecialchars($_POST['entlev']);
		$term = htmlspecialchars($_POST['term']);
		$program = htmlspecialchars($_POST['program']);
		$class = htmlspecialchars($_POST['class']);
		date_default_timezone_set('Asia/Manila');
		$enroll_date = date("F j\, Y");
		$startdate = date("F j\, Y",strtotime($startdate));

		// VALIDATION SCHOOL YEAR
		$sql = mysqli_query ($connection, "SELECT * FROM academic_year ORDER BY id DESC LIMIT 1");
			while ($r = mysqli_fetch_array($sql)) {
				$sdate = $r['start_date'];
				$edate = $r['end_date'];
			}
			$academic_year = $sdate ." to ". $edate;

		//CHECK ACADEMIC YEAR IF EXISTING IN DATABASE
		$res = mysqli_query ($connection, "SELECT * FROM students WHERE id='$id'");
		while ($row = mysqli_fetch_array($res)){
			$ay = $row['academic_year'];
		}

		if ($ay == $academic_year) {
			$errors['AY'] = "Academic year is not yet ended " . $academic_year;
			return;
		}

		// VALIDATION IF EMPTY
		if (empty($entlev)) {
			$errors['1'] = "All field is required";
			return;
		}
		if (empty($term)) {
			$errors['1'] = "All field is required";
			return;
		}
		if(empty($startdate)){
			$errors['1'] = "All field is required";
			return;
		}
		if (empty($program)) {
			$errors['1'] = "All field is required";
			return;
		}
		if (empty($class)) {
			$errors['1'] = "All field is required";
			return;
		}
		
		if (count($errors) == 0) {
			$sql = "INSERT INTO studentRecords (idnum, name, entlev, term, program,startdate,
				class, enroll_date) VALUES ('$idnum', '$name', '$entlev', '$term', 
				'$program', '$startdate','$class', '$enroll_date');";
			
			$newsql = "UPDATE students SET entlev='$entlev', term='$term', program='$program', 
			class='$class' WHERE idnum='$idnum' ";
			mysqli_query($connection, $newsql);

			$result = mysqli_query($connection, $sql);
			if ($result == TRUE) 
				{
					header("location: student-records.php?id=$id");
					$_SESSION['message'] = "Successfully Saved!";
					$_SESSION['id'] = $id;
				}
		}
		else {
			header("location: student-records.php?id=$id");
		}
		mysqli_close($connection);
	}
	
	//************************* ADD NEW COURSE ****************************
	if (isset($_POST['add-course'])) {
		$course_name = htmlspecialchars($_POST['course_name']);
		$course_code = htmlspecialchars($_POST['course_code']);
		$units = htmlspecialchars($_POST['units']);
		$program = htmlspecialchars($_POST['program']);
		date_default_timezone_set('Asia/Manila');
		$reg_date = date("F j\, Y \| g:i A", time());
		
		$sql = "INSERT INTO courses (course_name, course_code, units, program, reg_date)
			VALUES (?, ?, ?, ?, ?)";
			$stmt = $connection->prepare($sql);
			$stmt->bind_param('ssiss', $course_name, $course_code, $units,
				$program, $reg_date);
				
		if ($stmt->execute()) {
			header("location: courses-module.php");
			exit();
		}
		else  {
			$errors['db_error'] = "Database error: failed to register";
		}
	}

	//************************* ADD NEW CLASS ****************************
	if (isset($_POST['add-class'])) {
		$program_name = htmlspecialchars($_POST['program_name']);
		$program_code = htmlspecialchars($_POST['program_code']);
		$pdescription = htmlspecialchars($_POST['pdescription']);
		date_default_timezone_set('Asia/Manila');
		$reg_date = date("F j\, Y \| g:i A", time());
		
		$sql = "INSERT INTO classes (program_name, program_code, pdescription, date_created)
			VALUES (?, ?, ?, ?)";
			$stmt = $connection->prepare($sql);
			$stmt->bind_param('ssss', $program_name, $program_code, $pdescription, $reg_date);
				
		if ($stmt->execute()) {
			header("location: classes-module.php");
			exit();
		}
		else  {
			$errors['db_error'] = "Database error: failed to register";
		}
	}
	//************************* ADD NEW SECTION ****************************
	if (isset($_POST['add-section'])) {
		$id = $_POST['id'];
		$program = htmlspecialchars($_POST['program']);
		$class_name = htmlspecialchars($_POST['class_name']);
		
		if (empty($class_name)) {
			$errors['class_name'] = "Input Class Name";
		}
		//CHECK SECTION IF EXISTING IN DATABASE
		$emailQuery = "SELECT * From sections WHERE class_name=? AND program=? Limit 1";
		$stmt = $connection->prepare($emailQuery);
		$stmt->bind_param('ss', $class_name, $program);
		$stmt->execute();
		$result=$stmt->get_result();
		$userCount = $result->num_rows;
		$stmt->close();
		
		if ($userCount > 0) {
			$errors['class_name'] = "Class Name Already Exist!";
		}

		//IF NO ERRORS
		if (count($errors) == 0) {
		$sql = "INSERT INTO sections (program, class_name)
				VALUES (?, ?)";
				$stmt = $connection->prepare($sql);
				$stmt->bind_param('ss', $program, $class_name);

			if ($stmt->execute()) {
				header("location: view-program.php?id=$id");
				exit();
			}
		}
		header("location: view-program.php?id=$id");
	}

	//************************* CONFRIM ADMIN ACCESS TO ADD NEW ADMIN ****************************
	if (isset($_POST['sudoPassword'])) {
		$user = $_POST['user'];
		$Confpassword = $_POST['Confpassword'];

		if (empty($Confpassword)) {
			$errors['password'] = '1';
		}
		if (count($errors)== 0) {
			$sql = "SELECT * FROM users WHERE username=? Limit 1";
			$stmt = $connection->prepare($sql);
			$stmt->bind_param('s', $user);
			$stmt->execute();
			$result = $stmt->get_result();
			$admin = $result->fetch_assoc();

			if (password_verify($Confpassword, $admin['password'])) {
				header('location: users-add-admin-submodule.php');
			}
			else {
				$errors['password'] = "Access Denied";
			}
		}
	}

	//************************* ADD NEW ADMIN ****************************
	if (isset($_POST['addNewAdmin'])) {
		$fname = htmlspecialchars($_POST['fname']); //XXS-Protection
		$mname = htmlspecialchars($_POST['mname']);
		$lname = htmlspecialchars($_POST['lname']);
		$pass = htmlspecialchars($_POST['pass']);
		$passConf = htmlspecialchars($_POST['passConf']);

		$sql = mysqli_query ($connection, "SELECT * FROM users ORDER BY id DESC LIMIT 1");
		while ($r = mysqli_fetch_array($sql)){
			$numid = $r['id_user'];
		}
		$number = substr($numid, 5);
		date_default_timezone_set('Asia/Manila');
		$dyear = date("Y");
		$increment = (int)$number + 1;

		$admin_name = $lname . ", " . $fname . ", " . $mname;
		
		$email = htmlspecialchars($_POST['email']);

		if (empty($fname)) {
			$errors['fname'] = "1";
		}
		if (empty($mname)) {
			$errors['manme'] = "2";
		}
		if (empty($lname)) {
			$errors['lname'] = "3";
		}
		if (empty($email)) {
			$errors['email'] = "4";
		}
		if ($passConf != $pass) {
			$errors['password'] = "5";
		}
		//CHECK EMAIL IF EXISTING IN DATABASE
		$emailQuery = "SELECT * From users WHERE email=? Limit 1";
		$stmt = $connection->prepare($emailQuery);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result=$stmt->get_result();
		$userCount = $result->num_rows;
		$stmt->close();
		
		if ($userCount > 0) {
			$errors['email'] = "6";
		}

		date_default_timezone_set('Asia/Manila');
		$reg_date = date("F j\, Y");

		$words = explode(" ", $fname);
		$acronym = "";
		foreach ($words as $w) {
			$acronym .= $w[0];
		}
		$initials = strtolower($acronym);
		$middle = strtolower($mname[0]);
		$username = $lname ."". $initials ."". $middle . "@admin-aja.edu.com";
		
		$id_user = $dyear .'-'. $increment;

		if (count($errors) == 0) {
			$pass = password_hash($pass, PASSWORD_DEFAULT);
			$verified = False;
			$acctype = 'admin';
			$OTP = rand(999999, 111111);
			$token = bin2hex(random_bytes(50));

			$sql = "INSERT INTO users (id_user, admin_name, username, email,
			acctype, verified, OTP, reg_date, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = $connection->prepare($sql);
			$stmt->bind_param('sssssbiss', $id_user, $admin_name, strtolower($username),
			$email, $acctype, $verified, $OTP, $reg_date, $pass);
			
			if ($stmt->execute()) {
				// SEND VERIFICATION IN EMAIL
				// sendVerificationEmail($email, $token, $OTP);
				SendCode($email, $OTP);

				header('location: users-module.php');
			}
		}
	}
	
	//************************* ADD NEW FACULTY ****************************
	if (isset($_POST['add-faculty'])) {

		$sql = mysqli_query ($connection, "SELECT * FROM faculty ORDER BY id DESC LIMIT 1");
		while ($r = mysqli_fetch_array($sql)){
			$numid = $r['faculty_id'];
		}
		$number = substr($numid, 5);
		date_default_timezone_set('Asia/Manila');
		$dyear = date("Y");
		$increment = (int)$number + 1;
							
		$fname = htmlspecialchars($_POST['fname']);
		$mname = htmlspecialchars($_POST['mname']);
		$lname = htmlspecialchars($_POST['lname']);
		$fullname = $fname . " " . $mname[0] . ". " . $lname;

		$gender = htmlspecialchars($_POST['gender']);
		$special = htmlspecialchars($_POST['special']);
		$reviewcenter = htmlspecialchars($_POST['reviewcenter']);
		$status = htmlspecialchars($_POST['status']);
		$email = htmlspecialchars($_POST['email']);
		$pass = htmlspecialchars($_POST['pass']);
		$passConf = htmlspecialchars($_POST['passConf']);
		$sched = array();
		foreach($_POST['schedule']as $check) {
            $sched["{$check}"] = array("start"=>$_POST["{$check}starttime"],"end"=>$_POST["{$check}endtime"]);
    	}
        $myjson = json_encode($sched);
		
		// VALIDATION IF EMPTY
		if (empty($fullname)) {
			$errors['fullname'] = "";
		}
		if (empty($gender)) {
			$errors['gender'] = "";
		}
		
		if (empty($reviewcenter)) {
			$errors['reviewcenter'] = "";
		}
		if (empty($status)) {
			$errors['status'] = "";
		}
		if (empty($email)) {
			$errors['email'] = "";
		}
		if (empty($pass)) {
			$errors['pass'] = "";
		}
		if (empty($passConf)) {
			$errors['passConf'] = "";
		}
		if ($pass != $passConf) {
			$errors['password'] = "Password do not match";
		}
		//CHECK EMAIL IF EXISTING IN DATABASE
		$emailQuery = "SELECT * From faculty WHERE email=? Limit 1";
		$stmt = $connection->prepare($emailQuery);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result=$stmt->get_result();
		$userCount = $result->num_rows;
		$stmt->close();
		
		if ($userCount > 0) {
			$errors['email'] = "";
		}
		
		if (count($errors) == 0) {
			$pass = password_hash($pass, PASSWORD_BCRYPT);
			$acctype = 'faculty';
			date_default_timezone_set('Asia/Manila');
			$reg_date = date("F j\, Y");

			$words = explode(" ", $fname);
			$acronym = "";
			foreach ($words as $w) {
				$acronym .= $w[0];
			}
			$initials = strtolower($acronym);
			$middle = strtolower($mname[0]);
			$username = $lname ."". $initials ."". $middle . "@educa.edu.ph";
			$faculty_id = $dyear .'-'. $increment;

			$sql = "INSERT INTO faculty (fullname, gender, special,schedule, status, reviewcenter,
			email, password, username, faculty_id, reg_date)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
			$stmt = $connection->prepare($sql);
			$stmt->bind_param('sssssssssss', $fullname, $gender, $special, $myjson,$status, $reviewcenter,
			$email, $pass, strtolower($username), $faculty_id, $reg_date);

			if ($stmt->execute()) {

				header('location: faculty-module.php');
			}
			else  {
				$errors['db_error'] = "Database error: failed to register";
			}
		}
	}
	
	//************************* ADD ANNOUNCEMENT FACULTY ****************************
	if (isset($_POST['announcce-btn'])) {
		$announcement = htmlspecialchars($_POST['announcement']);
		$admin_name = $_SESSION['username'];
		date_default_timezone_set('Asia/Manila');
		$post_date = date("F j\, Y");

		$sql = "INSERT INTO announcements (announcement, admin_name, post_date)
			VALUES (?, ?, ?)";
			$stmt = $connection->prepare($sql);
			$stmt->bind_param('sss', $announcement, $admin_name, $post_date);

		if ($stmt->execute()) {
			header('location: admin-dashboard.php');
		}
	}

	//************************* ADD ANNOUNCEMENT FACULTY ****************************
	if (isset($_POST['add-ay'])) {
		$start_date = $_POST['school_year'];
		$end_date = $_POST['schoolyear'];

		$sql = "INSERT INTO academic_year (start_date, end_date)
			VALUES (?, ?)";
			$stmt = $connection->prepare($sql);
			$stmt->bind_param('ss', $start_date, $end_date);

			if ($stmt->execute()) {
				header('location: admin-dashboard.php');
			}
	}

	//************************* VERIFY NEW USER ADMIN OTP ****************************
	if (isset($_POST['confirmOTP'])) {

		$id = $_POST['id'];
		$code = $_POST['a'] . $_POST['b'] . $_POST['c'] .
					$_POST['d'] . $_POST['e'] . $_POST['f'];
		$otp_code = intval($code);
		
        $check_code = "SELECT * FROM users WHERE OTP = $otp_code";
		
		if ($otp_code == NULL) {
			$errors['otp-error'] = "You've entered incorrect code!";
		}
		else {
			$code_res = mysqli_query($connection, $check_code);
			if(mysqli_num_rows($code_res) > 0){
				$fetch_data = mysqli_fetch_assoc($code_res);
				$fetch_code = $fetch_data['OTP'];
				$id = $fetch_data['id'];
				$code = 0;
				$verified = 1;
				
				$update_otp = "UPDATE users SET OTP = $code, verified = $verified WHERE OTP = $fetch_code";
				$update_res = mysqli_query($connection, $update_otp);
				if($update_res){
					header('location: users-module.php');
					exit();
				}else{
					$errors['otp-error'] = "Failed while updating code!";
				}
			}else{
				$errors['otp-error'] = "You've entered incorrect code!";
			}
		}
	}
	//************************* DEDUCT BALANCE ****************************
	if(isset($_POST['paid'])){
		$index = $_POST['index'];
		$year_term = $_POST['year_term'];
		$idnum = $_POST['idnum'];
		$sql2 = "SELECT * FROM students  WHERE idnum = '$idnum'";
		$updateRes = mysqli_query($connection, $sql2);
		$balance = 0;
		while ($r = mysqli_fetch_array($updateRes)){
			$userid = $r['id'];
			$json = json_decode($r['extrafees']);
			foreach($json as $key=> $newValue){
				foreach($newValue as $curindex =>$value){
					if($curindex==$index&&$key==$year_term){
						if($json->$year_term[$index]->ispaid){
							$json->$year_term[$index]->ispaid = false;
							if($value->iscourse){
	
								$balance += $value->price;
							}else{
								$balance += $value->expenseprice;
							}
						}else{
							$json->$year_term[$index]->ispaid = true;
							
						}
						
					}else{
						if(!$value->ispaid){
							if($value->iscourse){
	
								$balance += $value->price;
							}else{
								$balance += $value->expenseprice;
							}
						}
					}
	
				}
			}
		

			
		}
		if($balance==null){
			$balance = 0;
		}
		$encoded = json_encode($json);
		$sql1 = "UPDATE students SET balance = {$balance} , extrafees = '{$encoded}' WHERE idnum = '{$idnum}'";
		
		
		$updateBal = mysqli_query($connection, $sql1);

		header("location: payment-module.php?id=$userid");
	}
	//************************* DELETE BALANCE ****************************
	if(isset($_POST['removeBalance'])){
		$year_term = $_POST['year_term'];
		$expensename = $_POST['expensename'];
		$idnum = $_POST['idnum'];

		$sql2 = "SELECT * FROM students  WHERE idnum = '$idnum'";
		$updateRes = mysqli_query($connection, $sql2);
		$index= 0;
		while ($r = mysqli_fetch_array($updateRes)){
			$balance = $r['balance'];
			$oldJson = json_decode($r['extrafees']);
			$userid = $r['id'];
			foreach($oldJson->$year_term as $value){
				if($value->expensename==$expensename){
					$balance -= $value->expenseprice;
					unset($oldJson->$year_term[$index]);
				}
				$index++;
			}
			
		}
		$encoded = json_encode($oldJson);
		$sql1 = "UPDATE students SET balance = $balance,extrafees = '$encoded'  WHERE idnum = '$idnum'";
		$updateBal = mysqli_query($connection, $sql1);
		header("location: payment-module.php?id=$userid");

	}
	//************************* EDIT ****************************
	if(isset($_POST['payterm'])){
		$year_term = $_POST['year_term'];
		$idnum = $_POST['idnum'];
		$coursename = $_POST['coursename'];
		$expensename = $_POST['expensename'];
		$index = $_POST['index'];
		$price = $_POST['price'];
		$sql2 = "SELECT * FROM students  WHERE idnum = '$idnum'";
		$updateRes = mysqli_query($connection, $sql2);
		$balance = 0;
		while ($r = mysqli_fetch_array($updateRes)){
			$userid = $r['id'];
			
			$oldJson = json_decode($r['extrafees']);
			foreach($oldJson as $key=> $newValue){

				if($coursename!=null){
				
					foreach($newValue as $curIndex =>$value){
						if($curIndex==$index &&$key==$year_term){
							$oldJson->$year_term[$index]=array("coursename"=>$value->coursename,'price'=>$price,'ispaid'=>$value->ispaid,'iscourse'=>true);
							if(!$value->ispaid){
								$balance += $price;
							}
						}else{
	
							if(!$value->ispaid){
								if($value->iscourse){
	
									$balance += $value->price;
								}else{
									$balance += $value->expenseprice;
								}
							}
						}
					}
				}else{
					foreach($newValue as $curIndex =>$value){
						if($curIndex==$index&&$key==$year_term){
							$oldJson->$year_term[$index]=array("expensename"=>$expensename,'expenseprice'=>$price,'ispaid'=>$value->ispaid);
							if(!$value->ispaid){
								$balance += $price;
							}
						}else{
	
							if(!$value->ispaid){
								if($value->iscourse){
	
									$balance += $value->price;
								}else{
									$balance += $value->expenseprice;
								}
							}
						}
					}
				}
			}
			
			
			
		}
		$encoded = json_encode($oldJson);
		$sql1 = "UPDATE students SET balance = $balance,extrafees='$encoded' WHERE idnum = '$idnum'";
		$updateBal = mysqli_query($connection, $sql1);
		header("location: payment-module.php?id=$userid");
	}
	//************************* ENROLL STUDENT COURSES ****************************
	if (isset($_POST['courseSelect'])) {
		$id = $_POST['id'];
		$idnum = $_POST['idnum'];
		$fullname = $_POST['fullname'];
		$year_term = $_POST['year_term'];
		$program_class = $_POST['program_class'];
		$sql = "INSERT INTO course_enrolled (idnum, fullname, year_term, program_class, course) VALUES (?, ?, ?, ?, ?)";
		$stmt = $connection->prepare($sql);
		$sql2 = "SELECT * FROM students  WHERE idnum = '$idnum'";
		$updateRes = mysqli_query($connection, $sql2);
		$balance= 0;
		while ($r = mysqli_fetch_array($updateRes)){
			if($r['extrafees']!=null){
				$oldJson = json_decode($r['extrafees']);
				
				foreach($oldJson->$year_term as $value){
					if(!$value->ispaid){
						if($value->iscourse){

							$balance += $value->price;
						}else{
							$balance += $value->expenseprice;
						}
					}
				}
			}
		}
		
		foreach ($_POST['check'] as $value) {
			if($oldJson!=null){
				if($oldJson->$year_term==null){
					$temp = (array) $oldJson;
					$temp[$year_term] = array(array("coursename"=>$value,'price'=>100,'ispaid'=>false,'iscourse'=>true));
					$oldJson = $temp;
				}else{

					array_push($oldJson->$year_term,array("coursename"=>$value,'price'=>100,'ispaid'=>false,'iscourse'=>true));
				}
			}else{
				$temp = array();
				$temp[$year_term] = array(array("coursename"=>$value,'price'=>100,'ispaid'=>false,'iscourse'=>true));
				$oldJson = $temp;
			}
			$balance += 100;	
			$stmt->bind_param('sssss', $idnum, $fullname, $year_term, $program_class, $value);
			$stmt->execute();	
		}
		$encoded = json_encode($oldJson);
		$sql1 = "UPDATE students SET balance = $balance,extrafees='$encoded' WHERE idnum = '$idnum'";
		$updateBal = mysqli_query($connection, $sql1);
		header("location: enroll-courses.php?id=$id&yt_id=$year_term");
	}
	//************************* ASSIGN FACULTY COURSE LOADS ****************************
	if (isset($_POST['facultyLoads'])) {
		$id = $_POST['id'];
		$faculty_id = $_POST['faculty_id'];
		$fullname = $_POST['fullname'];

		$sql = "INSERT INTO faculty_loads (faculty_id, fullname, course_name) VALUES (?, ?, ?)";
		$stmt = $connection->prepare($sql);

		foreach ($_POST['check'] as $value) {
			$stmt->bind_param('sss', $faculty_id, $fullname, $value);
			$stmt->execute();
		}
		header("location: facultyLoad.php?id=$id");
	}
	//************************* COURSE TURNED OFF ****************************
	if (isset($_POST['turnOff'])) {
		$id = $_POST['id'];

		$update = "UPDATE courses SET status = 'disable' WHERE id = $id";
		$res = mysqli_query($connection, $update);
		if($res){
			header('location: courses-module.php');
			exit();
		}
	}

	//************************* ASSIGN CLASS TO FACULTY ****************************
	if (isset($_POST['assignfacultyClass'])) {

		echo ("HUEHUE");
		$id = $_POST['id'];
		$class = $_POST['class'];

		$str = preg_replace('~[^A-Z_0-9]~', '', $class);

		$update = "UPDATE faculty_loads SET class='$str' WHERE id=$id";
		$res = mysqli_query($connection, $update);
		if($res){
			header("location: view-my-students.php?id=$id");
			exit();
		}
	}
?>

