<?php
	require_once('db.php');
	
	if(isset($_GET['receiver'])){
		$receiver_mail = $_GET['receiver'];

		$qr = mysqli_query($con, "SELECT DISTINCT sender FROM pm WHERE receiver = '$receiver_mail' AND seen = 0");
		if(mysqli_num_rows($qr)>0){
			
?>
			<div class="list-group" style="max-height: 300px;position: relative; overflow-y: scroll;">
			<?php 
				while($row = mysqli_fetch_array($qr)){
					$sender = $row['sender'];
					$getTeacherName = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$sender'");
					if(mysqli_num_rows($getTeacherName)>0){
						$row2 = mysqli_fetch_array($getTeacherName);
						$name = $row2['name'];
					}
					else{
						$getStudentName = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$sender'");
						if(mysqli_num_rows($getStudentName)>0){
							$row2 = mysqli_fetch_array($getStudentName);
							$name = $row2['name'];
						}	
					}
			?>
				<a href="chat.php?username=<?php echo $sender ?>" class="list-group-item list-group-item-action"><span style="color: green;"><?php echo $name; ?></span> <span class="badge badge-success">New</span></a>
			<?php
				}
			?>
			</div>
<?php
			

		}
	}
?>