<?php
	require_once('inc/top.php');
	$msg="";
	if(isset($_POST['teacherReg'])){
		$Temail = $_POST['Temail'];
		$nameOfTeacher = $_POST['nameOfTeacher'];
		$designation = $_POST['designation'];
		$pass = $_POST['Tpassword'];
		$conPass = $_POST['TRetypePassword'];
		if($pass == $conPass){
			$check = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$Temail'");
			$check2 = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$Temail'");
			if(mysqli_num_rows($check)>0){
				$msg = "<div class='alertDanger'>
					<i class='fa fa-times'></i> An account with this email already exists!
			</div>";	
			}
			else if(mysqli_num_rows($check2)>0){
				$msg = "<div class='alertDanger'>
					<i class='fa fa-times'></i> An account with this email already exists!
			</div>";	
			}
			else{
				$qr = mysqli_query($con, "INSERT INTO `teacher_register`(`id`, `name`, `email`, `designation`, `password`, `approved`) VALUES (NULL, '$nameOfTeacher', '$Temail', '$designation', '$pass', 0);");
				if($qr){
					$msg = "<div class='alertSuccess'>
						<i class='fa fa-check'></i> Successfully Registered, Please Login.
				</div>";
				}
				else{
					$msg = "<div class='alertDanger'>
						<i class='fa fa-times'></i> Something went wrong! Please try again.
				</div>";
				}
			}
		}
		else{
			$msg = "<div class='alertDanger'>
					<i class='fa fa-times'></i> Both Password should be same!
			</div>";
		}
	}
	else if(isset($_POST['studentReg'])){
		$email = $_POST['email'];
		$nameOfUser = $_POST['nameOfUser'];
		$class = $_POST['class'];
		$roll = $_POST['roll'];
		$section = $_POST['section'];
		$pass = $_POST['password'];
		$conPass = $_POST['RetypePassword'];
		if($pass == $conPass){
			$check = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$email'");
			$check2 = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$email'");
			if(mysqli_num_rows($check)>0){
				$msg = "<div class='alertDanger'>
					<i class='fa fa-times'></i> An account with this email already exists!
			</div>";	
			}
			else if(mysqli_num_rows($check2)>0){
				$msg = "<div class='alertDanger'>
					<i class='fa fa-times'></i> An account with this email already exists!
			</div>";	
			}
			else{
				$qr = mysqli_query($con, "INSERT INTO `student_register`(`id`, `email`, `name`, `roll`, `class`, `section`, `password`, `approved`)  VALUES (NULL, '$email', '$nameOfUser', '$roll', '$class', '$section', '$pass', 0);");
				if($qr){
					$msg = "<div class='alertSuccess'>
						<i class='fa fa-check'></i> Successfully Registered, Please Login.
				</div>";
				}
				else{
					$msg = "<div class='alertDanger'>
						<i class='fa fa-times'></i> Something went wrong! Please try again.
				</div>";
				}
			}
		}
		else{
			$msg = "<div class='alertDanger'>
					<i class='fa fa-times'></i> Both Password should be same!
			</div>";
		}
	}
?>





	<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->

	<div class="section" style="">
		<div class="box40">
			<h5 class="boxHeader">Sign Up:</h5>
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="teacher-tab" data-toggle="tab" href="#teacher" role="tab" aria-controls="teacher" aria-selected="true">Sign Up as Teacher</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="student-tab" data-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="false">Sign Up as Student</a>
				</li>
			</ul>
			<br>
			<?php if(isset($msg))echo $msg; ?>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="teacher" role="tabpanel" aria-labelledby="teacher-tab">
					<h6 style="color:green;">Teachers:</h6>				
					<form method="post">
						<label style="color:green;" for="nameOfTeacher">Name:</label>
						<input required id="nameOfTeacher" type="text" name="nameOfTeacher" placeholder="Enter your name" class="form-control" value="<?php if(isset($nameOfTeacher))echo $nameOfTeacher; ?>">
						<br>
						<label style="color:green;" for="Temail">Email:</label>
						<input required id="Temail" type="email" name="Temail" placeholder="Enter your email" class="form-control" value="<?php if(isset($Temail))echo $Temail; ?>">
						<br>
						<label style="color:green;" for="designation">Designation:</label>
						<input required id="designation" type="text" name="designation" placeholder="Enter your Designation" class="form-control" value="<?php if(isset($designation))echo $designation; ?>">
						<br>
						<label style="color:green;" for="Tpassword">Password:</label>
						<input required id="Tpassword" type="password" name="Tpassword" placeholder="Enter your password"  class="form-control">
						<br>
						<label style="color:green;" for="TRetypePassword">Re-Type Password:</label>
						<input required id="TRetypePassword" type="password" name="TRetypePassword" placeholder="Enter your password again"  class="form-control">
						<br>
						<br>
						<button type="submit" id="signUpBtn" name="teacherReg" class="btn btn-success">Create Account</button>
					</form>
				</div>
				<div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
					<h6 style="color:blue;">Students:</h6>				
					<form method="post">
						<label style="color:blue;" for="nameOfUser">Name:</label>
						<input required id="nameOfUser" type="text" name="nameOfUser" placeholder="Enter your name" class="form-control" value="<?php if(isset($nameOfUser))echo $nameOfUser; ?>">
						<br>
						<label style="color:blue;" for="email">Email:</label>
						<input required id="email" type="email" name="email" placeholder="Enter your email" class="form-control" value="<?php if(isset($email))echo $email; ?>">
						<br>
						<label style="color:blue;" for="class">Class:</label>
						<select required id="class" name="class" class="form-control">
							<option value="" disabled selected>Select Class</option>
							<option value="Level 1 Term 1">Level 1 Term 1</option>
							<option value="Level 1 Term 2">Level 1 Term 2</option>
							<option value="Level 2 Term 1">Level 2 Term 1</option>
							<option value="Level 2 Term 2">Level 2 Term 2</option>
							<option value="Level 3 Term 1">Level 3 Term 1</option>
							<option value="Level 3 Term 2">Level 3 Term 2</option>
							<option value="Level 4 Term 1">Level 4 Term 1</option>
							<option value="Level 4 Term 2">Level 4 Term 2</option>
						</select>
						<br>
						<label style="color:blue;" for="section">Section:</label>
						<select required id="section" name="section" class="form-control">
							<option value="" disabled selected>Select Section</option>
							<option value="A">A</option>
							<option value="B">B</option>
						</select>
						<br>
						<label style="color:blue;" for="roll">Roll:</label>
						<input required id="roll" type="text" name="roll" placeholder="Enter your roll" class="form-control" value="<?php if(isset($roll))echo $roll; ?>">
						<br>
						<label style="color:blue;" for="password">Password:</label>
						<input required id="password" type="password" name="password" placeholder="Enter your password"  class="form-control">
						<br>
						<label style="color:blue;" for="RetypePassword">Re-Type Password:</label>
						<input required id="RetypePassword" type="password" name="RetypePassword" placeholder="Enter your password again"  class="form-control">
						<br>
						<br>
						<button type="submit" id="signUpBtn" name="studentReg" class="btn btn-success">Create Account</button>
					</form>
				</div>
			</div>
				
			 
		</div>
		
	</div>
	<!--Please, place all your div/box/anything inside the above SECTION-->






<?php
	require_once('inc/footer.php');
?>