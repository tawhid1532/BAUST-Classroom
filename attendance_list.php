<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    
    if(isset($_GET['id'])){
        $class_id = $_GET['id'];
    }
    $msg="";
    $qr = mysqli_query($con, "SELECT * FROM `attendance_info` WHERE id = '$class_id'");
    if(mysqli_num_rows($qr)>0){
      $row = mysqli_fetch_array($qr);
      $teacher = $row['teacher'];
      
      
      $class = $row['class'];
      $section = $row['section'];
      $isArchived = $row['archived'];
      
      $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$teacher'");
      $rw = mysqli_fetch_array($teacher_info);
      $teacher_name = $rw['name'];
    }

?>

<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
	<div class="section" style="">
        <div class="row">
            <div class="col-md-10">
                <?php 
                    if($userType == 'teacher'){
                ?>

                <div class="box80">
                    <a href="take_attendance.php?id=<?php echo $class_id; ?>"><button class="btn btn-warning">Take Attendance</button></a>
                </div>
                <div class="box80" style="margin-top:20px;">
                    <a href="delete.php?delete_type=attendance&attendance_id=<?php echo $class_id; ?>">
                        <button 
                            id="showButton" 
                            type="button" 
                            style="float:right;" 
                            class="btn btn-outline-danger" 
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Delete">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </a>

                    <a href="archive.php?archive_type=attendance&attendance_id=<?php echo $class_id; ?>">
                        <button 
                            id="showButton" 
                            type="button" 
                            style="float:right;" 
                            class="btn btn-outline-dark" 
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Archive" <?php if($isArchived == 1)echo "disabled"?>>
                            <i class="fa fa-archive" aria-hidden="true"></i>
                        </button>
                    </a>
        		    <h5 class="boxHeader">Date wise Attendace Record:</h5>
                    <h6 style="font-weight: bold;">Teacher: <?php echo $teacher_name ?></h6>
                    <h6 style="font-weight: bold;">Class: <?php echo $class; ?></h6>
                    <h6 style="font-weight: bold;">Section: <?php echo $section; ?></h6>
                <?php
                    

                    $attendence_data = mysqli_query($con, "SELECT * FROM `daily_attendance` WHERE a_id = '$class_id'");
                    if(mysqli_num_rows($attendence_data)>0){
                        while($row = mysqli_fetch_array($attendence_data)){
                            $id = $row['id'];
                            //$date_list = $row['date']
                            $dt = new DateTime($row['date']);
                            $date = $dt->format('Y-m-d');
                ?>
                    <a href="daily_attendance.php?class_id=<?php echo $class_id; ?>&id=<?php echo $id; ?>" style="text-decoration:none;"><div style="background:#A7CDF2; padding:15px; font-weight:bold; margin-top:10px; "><?php echo $date; ?></div></a>
                <?php

                        }
                    }
                    else{
                ?>
                    <h6 style="color:#7f7f7f; font-style: italic;">You haven't created anything yet.</h6>
                <?php
                    }
                ?>
                </div>

                <?php
                }
                ?>
                
            </div>
            <?php
                require_once('inc/chatbar.php');
            ?>
        </div>
	</div>
	<!--Please, place all your div/box/anything inside the above SECTION-->

<?php
	require_once('inc/footer.php');
?>