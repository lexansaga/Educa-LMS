<?php
require_once 'controllers/authController.php';
require 'controllers/accessController.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<title> Student Enrollment </title>
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="icon" type="image/x-icon" href="styles/favicon.ico" />

	<!-- CUSTOM STYLESHEET -->
	<link rel="stylesheet" href="admin-dashboard.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
	<script src="https://kit.fontawesome.com/575abfd474.js" crossorigin="anonymous"></script>
	<!-- BOOTSRAP -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

	<!--wrapper start-->
	<div class="wrapper">
		<!--header menu start-->
		<div class="header">
			<div class="header-menu">
				<div class="title">
					<div class="menu-button">
						<span></span>
						<span></span>
						<span></span>
					</div>Educa Academy
				</div>
			</div>
		</div>
		<!--header menu end-->
		<!--sidebar start-->
		<div class="sidebar">
			<div class="sidebar-menu">
				<center class="profile">
					<img src="styles/logo.png" alt="">
					<p><?php echo $_SESSION['username']; ?></p>
				</center>
				<hr>
				</hr>
				<li class="item">
					<a href="admin-dashboard.php" class="menu-btn">
						<i class="fas fa-desktop"></i>Dashboard
					</a>
				</li>
				<li class="item">
					<a href="student-module.php" class="menu-btn">
						<span><i class="fas fa-graduation-cap"></i>Student</span>
					</a>
				</li>
				<li class="item">
					<a href="faculty-module.php" class="menu-btn">
						<i class="fas fa-users"></i>Faculty
					</a>
				</li>
				<li class="item">
					<a href="courses-module.php" class="menu-btn">
						<i class="fas fa-clipboard-list"></i>Courses
					</a>
				</li>
				<li class="item">
					<a href="classes-module.php" class="menu-btn">
						<i class="fas fa-clipboard-list"></i>Classes
					</a>
				</li>
				<li class="item">
					<a href="grading-module.php" class="menu-btn">
						<i class="fas fa-file-excel"></i>Grading
					</a>
				</li>
				<li class="item">
					<a href="users-module.php" class="menu-btn">
						<i class="fas fa-users-cog"></i>Users
					</a>
				</li>

				<!-- Button trigger modal -->
				<li class="item">
					<div class="menu-btn">
						<button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
							<i class="fas fa-sign-out-alt"></i>Logout
						</button>
					</div>
				</li>
			</div>
		</div>
		<!--sidebar end-->
		<!--main container start-->
		<div class="content">
			<div class="directory">
				<p>Student Module / Student Enrollment</p>
			</div>

			<hr>
			</hr>

			<!--START OF FORM -->
			<form action="enroll-student-submodule.php" method="POST" enctype="multipart/form-data">

				<div class="back-btn">
					<button type="submit" name="enroll-backbtn" class="btn btn-danger">Back
						<i class="fas fa-backspace"></i>
					</button>
				</div>
				<!-- REGISTRATION FORM -->
				<div class="registration">
					<h4>Student Enrollment Form</h4>
					<hr>
					</hr>

					<div class="primary">
						<div class="p1">
							<p>
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<!-- ID Number -->
								<label>ID Number:</label><br>

								<?php
								$sql = mysqli_query($connection, "SELECT * FROM students ORDER BY id DESC LIMIT 1");
								while ($r = mysqli_fetch_array($sql)) {
									$numid = $r['idnum'];
								}
								$number = substr($numid, 5);
								$number = (int)$number;
								date_default_timezone_set('Asia/Manila');
								$dyear = date("Y");
								?>
								<input type="text" name="idnum" value="<?php echo $dyear . '-' . ($number + 1); ?>" class="form-input" readonly>

							<p>


								<!-- FIRST NAME -->
								<label>First Name:</label><br>
								<input type="text" name="fname" value="<?php echo $fname; ?>" class="form-input" placeholder="First name" maxlength="20" minlength="2">
							<p>
								<label>Middle Name:</label><br>
								<!-- MIDDLE NAME -->
								<input type="text" name="mname" value="<?php echo $mname; ?>" class="form-input" placeholder="Middle name" maxlength="20" minlength="2">
							<p>
								<label>Last Name:</label><br>
								<!-- LAST NAME -->
								<input type="text" name="lname" value="<?php echo $lname; ?>" class="form-input" placeholder="Last name" maxlength="20" minlength="2">
							<p>
						</div>

						<div class="p2">
							<p>
								<label>Gender:</label><br>
								<!-- GENDER -->
								<select name="gender">
									<option value="" selected disabled>-- Gender --</option>
									<option <?php if (isset($gender) && $gender == "male") echo "selected"; ?> value="male">Male</option>
									<option <?php if (isset($gender) && $gender == "female") echo "selected"; ?> value="female">Female</option>
								</select>

							<p>
								<label>Contact Number:</label><br>
								<!-- CONTACT NUMBER -->
								<input type="text" id="myField" name="cnum" value="<?php echo $cnum; ?>" class="form-input" placeholder="eg. 09xxxxxxxxx" maxlength="11" pattern="(?=.*[0-9]).{11,11}">
							<p>
								<label>Email Address:</label><br>
								<!-- EMAIL ADDRESS -->
								<input type="text" name="email" value="<?php echo $email; ?>" class="form-input" placeholder="Email Address" maxlength="50" minlength="2">
							<p>


								<label>Program: </label><br>

								<select name="program">
									<option value="" selected disabled>-- Status --</option>
									<?php
									$course = mysqli_query($connection, "SELECT * FROM classes");
									while ($rows = mysqli_fetch_array($course)) {
									?>

										<option <?php if (isset($program) && $program == $rows['program_name']) echo "selected"; ?> value="<?php echo $rows['program_name'] ?>"><?php echo $rows['program_name'] ?></option>

									<?php } ?>
								</select>
						</div>

						<div class="p3">
							<p>
								<label>Recent 2x2 picture (on white background)</label><br>
								<!-- ADD IMAGE -->
								<input type="hidden" name="size" value="1000000" max-size="2000">
								<input class="files" type="file" name="image" accept="image/*" max-size="2000">
							<p>

								<label>Transcipt of Records</label><br>
								<!-- ADD GOOD MORAL -->
								<input type="hidden" name="size" value="1000000" max-size="2000">
								<input class="files" type="file" name="g_moral" value="Choose File" accept="application/pdf" max-size="2000">
							<p>

								<label>Birth Certificate (NSO/PSA)</label><br>
								<!-- ADD NSO -->
								<input class="files" type="file" name="NSO" value="Choose File" accept="application/pdf" max-size="2000">
							<p>
								<label>Password: </label><br>
								<input type="password" name="pass" placeholder="password">
								<br>
								<label>Confirm Password: </label><br>
								<input type="password" name="passConf" placeholder="confirm password">
								<br>
							<div class="enroll-student">
								<button type="submit" name="enroll-backbtn" class="btn btn-danger">Cancel
									<i class="fas fa-backspace"></i>
								</button>

								<button type="submit" name="enroll-success" class="btn btn-success">Submit
									<i class="fas fa-save"></i>
								</button>
							</div>

							<div class="file-errors">
								<!-- DISPLAY ERRORS -->
								<?php if (count($errors) > 0) : ?>
									<?php if (count($errors) == 11) : ?>
										<div class="">
											<?php
											echo "<br>The following error(s) occurred:<p>";
											echo "All fields must be fileld out<br><br>";
											?>
										</div>

									<?php else : ?>
										<div class="">
											<?php
											echo "<br>The following error(s) occurred:<p>";
											foreach ($errors as $error) :
											?>
												<li><?php echo $error; ?></li>
											<?php endforeach;
											echo "<br>"; ?>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>

						</div>
					</div>

				</div>

			</form>
			<!--END OF FORM -->

		</div>
		<!--main container end-->
	</div>
	<!--wrapper end-->

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="exampleModalLabel">Are you sure you want to logout?</h6>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

					<button class="btn btn-danger">
						<a href="admin-dashboard.php?logout=1" class="menu-btn">
							<i class="fas fa-sign-out-alt"></i>Logout
						</a>
					</button>
				</div>
			</div>
		</div>
	</div>

	<div>
		<?php
		include("preloader.php")
		?>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$(".sidebar-btn").click(function() {
				$(".wrapper").toggleClass("collapse");
			});
		});

		$("#myField").keyup(function() {
			$("#myField").val(this.value.match(/[0-9]*/));
		});
	</script>
	<script src="script.js"></script>
</body>

</html>