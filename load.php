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
	}
	else if(isset($_SESSION['student'])){
		$userType = 'student';
		$user = $_SESSION['student'];
		$qr = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$user'");
		$row = mysqli_fetch_array($qr);
		$name = $row['name'];	
		$studentClass = $row['class'];
		$studentSection = $row['section'];
	}
    //$receiver_user=$_GET['receiver'];
    
	$receiver_mail = $_GET['receiver'];
	$check = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$receiver_mail'");
	$check2 = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$receiver_mail'");
	if(mysqli_num_rows($check)>0){
		$row=mysqli_fetch_array($check);
		$receiver_name = $row['name'];
		$receiver_type = 'teacher';
	}
	else if(mysqli_num_rows($check2)>0){
		$row=mysqli_fetch_array($check2);
		$receiver_name = $row['name'];
		$receiver_type = 'student';
	}

    $check = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$user'");
	$check2 = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$user'");
	if(mysqli_num_rows($check)>0){
		$row=mysqli_fetch_array($check);
		$sender_name = $row['name'];
		$sender_type = 'teacher';
	}
	else if(mysqli_num_rows($check2)>0){
		$row=mysqli_fetch_array($check2);
		$sender_name = $row['name'];
		$sender_type = 'student';
	}
    /*$receiver_user = $_SESSION['receiver_user'];*/
    /*$receiver_name = $_SESSION['receiver_name'];*/
    $m_query = "SELECT * FROM pm WHERE (sender='$user' AND receiver = '$receiver_mail') OR (receiver ='$user' AND sender = '$receiver_mail') ORDER BY id ASC;";
    $m_run = mysqli_query($con, $m_query);
       if(mysqli_num_rows($m_run)>0){
            while($m_row=mysqli_fetch_array($m_run)){
                $message = $m_row['message'];
                $user1 = $m_row['sender'];
                $user2 = $m_row['receiver'];
                $time = $m_row['timestamp'];

                if($user1==$user){

            ?>
				<!--<h5 style="text-align: right;font-weight: bold; color: <?php if($sender_type=="student"){echo "teal";}else{echo "maroon";}?>"><?php echo $sender_name; ?></h5>-->
                <li class="chat2"><h5 style=""><?php echo $message; ?></h5></li>
                <?php  
                        }
                        else{
                   
                ?>
                <h5 style="margin:0; font-weight: bold; color: <?php if($receiver_type=="student"){echo "teal";}else{echo "maroon";}?>"><?php echo $receiver_name; ?></h5>
                <li class="chat1"><h5 style=""><?php echo $message; ?></h5></li>
                <?php
                            
                    }

                }
            }
?>

		