<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    
    if(isset($_GET['class_id'])){
        $class_id = $_GET['class_id'];
    }
    if(isset($_GET['id'])){
      $attendance_id = $_GET['id'];
    }
  
    $qr = mysqli_query($con, "SELECT * FROM `attendance_info` WHERE id = '$class_id'");
    if(mysqli_num_rows($qr)>0){
      $row = mysqli_fetch_array($qr);
      $teacher = $row['teacher'];
      
      
      $class = $row['class'];
      $section = $row['section'];

      $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$teacher'");
      $rw = mysqli_fetch_array($teacher_info);
      $teacher_name = $rw['name'];
    }
    else{
      die("Nothing To Show");   
    }

    $qr2 = mysqli_query($con, "SELECT * FROM `daily_attendance` WHERE id = '$attendance_id'");
    if(mysqli_num_rows($qr2)>0){
      $row = mysqli_fetch_array($qr2);
      $dt = new DateTime($row['date']);
      $date = $dt->format('Y-m-d');
      $attendance_data = json_decode($row['data']);
      $j=0;
      foreach($attendance_data as $value)
      {
          $attendance_array[$j] = $value;

          $j++;
      }
    }
    else{
      die("Nothing To Show");   
    }
    $msg="";

?>

<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
	<div class="section" style="">
        <div class="row">
            <div class="col-md-10">
            <div class="box80" style="margin-top: 20px;">
                    <a href="attendance_list.php?id=<?php echo $class_id; ?>"><button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Show All</button></a>
                    <br>
                    <br>
                    <h5 class="boxHeader">Attendance Record: <?php echo $date; ?></h5>

                    <h6 style="font-weight: bold;">Teacher: <?php echo $teacher_name; ?></h6>
                    <h6 style="font-weight: bold;">Class: <?php echo $class; ?></h6>
                    <h6 style="font-weight: bold;">Section: <?php echo $section; ?></h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <?php
                            for($i=0;$i<15;$i++){
                            ?>
                            <h5 style="font-weight: bold;">Roll <?php echo $i+1; ?>: <?php if($attendance_array[$i]==1){ echo "<span style='color:green;'>Present</span>";} else{ echo "<span style='color:red;'>Absent</span>";} ?></h5>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                            for($i=15;$i<30;$i++){
                            ?>
                            <h5 style="font-weight: bold;">Roll <?php echo $i+1; ?>: <?php if($attendance_array[$i]==1){ echo "<span style='color:green;'>Present</span>";} else{ echo "<span style='color:red;'>Absent</span>";} ?></h5>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                            for($i=30;$i<45;$i++){
                            ?>
                            <h5 style="font-weight: bold;">Roll <?php echo $i+1; ?>: <?php if($attendance_array[$i]==1){ echo "<span style='color:green;'>Present</span>";} else{ echo "<span style='color:red;'>Absent</span>";} ?></h5>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                            for($i=45;$i<60;$i++){
                            ?>
                            <h5 style="font-weight: bold;">Roll <?php echo $i+1; ?>: <?php if($attendance_array[$i]==1){ echo "<span style='color:green;'>Present</span>";} else{ echo "<span style='color:red;'>Absent</span>";} ?></h5>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    
                </div>
  
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