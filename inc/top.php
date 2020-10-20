<?php
	session_start();
	require_once('db.php');
	$user = "";
	if(isset($_SESSION['teacher'])){
		$userType = 'teacher';
		$user = $_SESSION['teacher'];
		$qr = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$user'");
		$row = mysqli_fetch_array($qr);
		$name = $row['name'];
		$designation = $row['designation'];
		$ProfileId = $row['id'];

	}
	else if(isset($_SESSION['student'])){
		$userType = 'student';
		$user = $_SESSION['student'];
		$qr = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$user'");
		$row = mysqli_fetch_array($qr);
		$name = $row['name'];	
		$studentClass = $row['class'];
		$studentSection = $row['section'];
		$studentRoll = $row['roll'];
		$ProfileId = $row['id'];
	}
	else if(isset($_SESSION['admin'])){
		$userType = 'admin';
		$user = $_SESSION['admin'];
		$name = "Admin";	
		
		$ProfileId = "";
	}
	if(isset($name))$url_name = str_replace(" ", "-", $name);
?>
<!DOCTYPE html>
<html>
<head>
	<title>BAUST Classroom</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="img/logo.png">
	<link href="https://fonts.maateen.me/kalpurush/font.css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
	
  	<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  	

</head>
<body>
	
	
	<div class="top">
		<div class="top_one">
			<div class="container">
			<div class="row uppr"> 
		      <!-- TOP LEFT -->
		      <div class="col-md-5 col-sm-6">
		        <div class="top-address uppernav">
				<?php
					if(!empty($user)){
				?>
				<a href="profile.php?name=<?php echo $url_name;?>" class=""><i class="fa fa-user"></i> <?php echo $name;?></a>
				<a href="logout.php"><i class="fa fa-power-off"></i> Log Out</a>
				<?php
					}
					else{
				?>
		          <a href="login.php" class=""><i class="fa fa-user"></i> Login</a>
			  	  <a href="signup.php">Sign Up</a>
				<?php
					}
				?>
		        </div>
		      </div>
		      <div class="col-md-3 col-sm-3">
		        <div class="top-number">
		          
		        </div>
		      </div>
		      <!-- TOP RIGHT -->
		      <div class="col-md-4 col-sm-3">
		        <div class="top-right-menu">
		          <ul class="social-icons text-right">
		            <li><a class="facebook social-icon" href="javascript:void(0)" title="Facebook"><i class="fa fa-facebook"></i></a></li>
		            <li><a class="github social-icon" href="javascript:void(0)" title="GitHub"><i class="fa fa-github"></i></a></li>
		            <li><a class="linkedin social-icon" href="javascript:void(0)" title="linkedin"><i class="fa fa-linkedin"></i></a></li>
		          </ul>
		        </div>
		      </div>
		    </div>
		 </div>
		</div>
		<div>
	      <div class="uniName">
			<center><img class="logo" src="img/logo.png" ></center>
			<h3 style="text-align: center; font-weight: bold;">BAUST Classroom - An Online Education Platform</h3>
	      </div>
		</div>

		 <div class="container top_three">
			<div class="topnav" id="myTopnav">
			  <a><b class="logo2">Department of CSE</b></a>
              <a href="index.php" class="nav_content">Home</a>
              <a href="online_exams.php" class="nav_content">Online Exams</a>
              <a href="tasks.php" class="nav_content">Tasks</a>
			  <a href="attendance.php" class="nav_content">Attendance</a>
			  <a href="resource.php" class="nav_content">Resources</a>
			  <a href="qa.php" class="nav_content">Q & A</a>
			  <a href="notice.php" class="nav_content">Notices</a>
			  
			  <a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars" aria-hidden="true"></i></a>
			</div>
		</div>
	</div>

	<!--ENF OF TOP. (PLEASE "TEMPLATE EXTEND" the above part as TOP/HEAD) -->
