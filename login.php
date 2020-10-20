<?php
	require_once('inc/top.php');
	if(isset($_SESSION['teacher'])){
		header('Location: index.php'); 
	}
	else if(isset($_SESSION['student'])){
		header('Location: index.php'); 
	}
	if(isset($_POST['submit'])){
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		$userType = $_POST['userType'];
		$msg = "";
		if($userType=="Teacher"){
		
			$qr = "SELECT * FROM teacher_register WHERE email = '$email'";
			$rn = mysqli_query($con,$qr);
			if(mysqli_num_rows($rn)>0){
				$row = mysqli_fetch_array($rn);

				$db_user = $row['email'];
				$db_pass = $row['password'];
				$approved = $row['approved'];
				if($db_pass===$password){
					if($approved == 1){
						$msg = "<div class='alertSuccess'>
						<i class='fa fa-check'></i> Username and Password matched!
						</div>";
						$_SESSION['teacher']=$db_user;
						header('Location: index.php');
					}    
					else{
						$msg = "<div class='alertSuccess'>
						<i class='fa fa-check'></i> Username and Password matched!
						</div><div class='alertDanger'>
						<i class='fa fa-check'></i> Your Account has not approved yet, Please Wait for Approval!
						</div>";
					}
				}
				else{
					$msg = "<div class='alertDanger'>
					<i class='fa fa-times'></i> Password Doesn't match!
					</div>";
					
				} 
			}
			else{
					$msg = "<div class='alertDanger'>
						<i class='fa fa-times'></i> Email Doesn't match!
				</div>";
			}
		}
		else if($userType == "Student"){
		
			$qr = "SELECT * FROM student_register WHERE email = '$email'";
			$rn = mysqli_query($con,$qr);
			if(mysqli_num_rows($rn)>0){
				$row = mysqli_fetch_array($rn);

				$db_user = $row['email'];
				$db_pass = $row['password'];
				$approved = $row['approved'];
				if($db_pass===$password){
					if($approved == 1){
						$msg = "<div class='alertSuccess'>
						<i class='fa fa-check'></i> Username and Password matched!
						</div>";
						$_SESSION['student']=$db_user;
						header('Location: index.php');
					}    
					else{
						$msg = "<div class='alertSuccess'>
						<i class='fa fa-check'></i> Username and Password matched!
						</div><div class='alertDanger'>
						<i class='fa fa-check'></i> Your Account has not approved yet, Please Wait for Approval!
						</div>";
					}
				}
				else{
					$msg = "<div class='alertDanger'>
					<i class='fa fa-times'></i> Password Doesn't match!
					</div>";
					
				} 
			
			}
			else{
					$msg = "<div class='alertDanger'>
						<i class='fa fa-times'></i> Email Doesn't match!
				</div>";
			}
		}
		else if($userType == "Admin"){
			echo "hh";
			$qr = "SELECT * FROM `admin` WHERE email = '$email'";
			$rn = mysqli_query($con,$qr);
			if(mysqli_num_rows($rn)>0){
				$row = mysqli_fetch_array($rn);

				$db_user = $row['email'];
				$db_pass = $row['password'];
				
				if($db_pass===$password){
					$msg = "<div class='alertSuccess'>
					<i class='fa fa-times'></i> Username and Password matched!
					</div>";
					$_SESSION['admin']=$db_user;
					header('Location: admin.php');    
				}
				else{
					$msg = "<div class='alertDanger'>
					<i class='fa fa-times'></i> Password Doesn't match!
					</div>";
					
				} 
			
			}
			else{
					$msg = "<div class='alertDanger'>
						<i class='fa fa-times'></i> Email Doesn't match!
				</div>";
			}
		}
		
	}

?>






	<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
	<div class="section" style="">
		<div class="box30">
			<?php 
				if(isset($msg))echo $msg;
			?>
			 <h5 class="boxHeader">Login:</h5>
			 
			 <form method="post">
			 	<label for="email">Email:</label>
			 	<input required id="email" type="email" name="email" placeholder="Enter your email" class="form-control" >
			 	<br>
			 	<label for="password">Password:</label>
			 	<input required id="password" type="password" name="password" placeholder="Enter your password"  class="form-control">
			 	<br>
				<label for="userType">User Type:</label>
				<select required id="userType" name="userType" class="form-control">
					<option value="Teacher">Teacher</option>
					<option value="Student">Student</option>
					<option value="Admin">Admin</option>
				</select>
				<br>
				
			 	<button type="submit" name="submit" id="loginBtn" class="btn btn-success">Login</button>
			 </form>
		</div>
		<br>
		<center><a href="signup.php" class="btn btn-primary createAccountButton">Create New Account</button></a>
	</div>
	<!--Please, place all your div/box/anything inside the above SECTION-->





<?php
	require_once('inc/footer.php');
?>