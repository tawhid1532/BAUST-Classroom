<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    if(isset($_GET['id'])){
        $task_id = $_GET['id'];
    }   
    


    if(isset($_POST['publish'])){
        $publish = mysqli_query($con, "UPDATE `task` SET `publish` = '1' WHERE `task`.`id` = '$task_id';");
        if(isset($publish)){
            $task_query2 = mysqli_query($con, "SELECT * FROM `task` WHERE `id` = '$task_id'");
            $row = mysqli_fetch_array($task_query2);
            $published = $row['publish'];
        }


    }

    $task_query = mysqli_query($con, "SELECT * FROM `task` WHERE `id` = '$task_id'");
    if(mysqli_num_rows($task_query)>0){
        $row = mysqli_fetch_array($task_query);
        $qaHeading = $row['title'];
        $qaDetails = $row['details'];
        $poster = $row['teacher'];
        $TotalMark = $row['mark'];
        $filename = $row['filename'];
        $dealine_date = date('d M', strtotime($row['date']));
        $dealine_time = date('h:i A', strtotime($row['time']));
        date_default_timezone_set("Asia/Dhaka");
        $dd = $row['date'];
        $dt = $row['time'];
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');
        $isArchived = $row['archived'];
        //echo $current_date;
        //echo $dd;
        //echo $dt;
        //echo $current_time;
        $fl = 0;
        if($current_date >= $dd){
            if($current_date>$dd){
                $fl = 1;
            }
            else if($current_date==$dd){
                if($current_time>$dt){
                    $fl = 1;
                }
            }   
        }
        $published = $row['publish'];
        $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$poster'");
        $row = mysqli_fetch_array($teacher_info);
        $poster_name = $row['name'];
       
        
    }
    $msg="";
    if(isset($_POST['submit'])){
        $check = mysqli_query($con, "SELECT * FROM task_submit WHERE student = '$user' AND `task_id` = '$task_id'");
        if(mysqli_num_rows($check)>0){
            $msg = "<div class='alertDanger'>
                        <i class='fa fa-times'></i> You have already submitted.
                    </div>";
        }
        else{
            $file_name = $_FILES['rfile']['name'];
            $file_size =$_FILES['rfile']['size'];
            $file_tmp =$_FILES['rfile']['tmp_name'];

            if($file_size < 209710000){
                $qa = mysqli_query($con, "INSERT INTO `task_submit` (`id`, `task_id`, `student`, `file_name`, `mark`) VALUES (NULL, '$task_id', '$user', '$file_name', '0');");
                $up = move_uploaded_file($file_tmp,"task_submit/".$file_name);   
                if($qa){
                    $msg = "<div class='alertSuccess'>
                                <i class='fa fa-check'></i> Successfully Submitted!
                        </div>";
                }
                else{
                    $msg = "<div class='alertDanger'>
                                <i class='fa fa-times'></i> Something went wrong! Please try again.
                        </div>";
                }
            }
            else{
                $msg = "<div class='alertDanger'>
                            <i class='fa fa-times'></i> File should not be greater than 2 MB.
                        </div>";
            }
        }
    }

?>

<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
	<div class="section" style="">
        <div class="row">
            <div class="col-md-10">
        		<div class="box2nd90">
                    <?php if($userType=="teacher"){ ?>
                    <a href="delete.php?delete_type=task&task_id=<?php echo $task_id; ?>">
                        <button 
                            id="showButton" 
                            type="button" 
                            style="float:right;" 
                            class="btn btn-danger" 
                            data-toggle="tooltip" 
                            data-placement="top" title="Delete">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </a>
                    
                    
                    <a href="archive.php?archive_type=task&task_id=<?php echo $task_id; ?>">
                        <button 
                            id="showButton" 
                            type="button" 
                            style="float:right;" 
                            class="btn btn-dark" 
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Archive" <?php if($isArchived == 1)echo "disabled"?>>
                            <i class="fa fa-archive" aria-hidden="true"></i>
                        </button>
                    </a>
                    
                    <a href="task_update.php?id=<?php echo $task_id; ?>">
                        <button 
                            id="showButton" 
                            type="button" 
                            style="float:right;" 
                            class="btn btn-success" 
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Edit">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                    </a>
        		  <?php } ?>
                    <h5 class="box2ndHeader">Deadline: <?php echo $dealine_date; ?> <?php echo $dealine_time; ?> </h5>
                    <div style="padding: 20px;">

                      <h3><?php echo $qaHeading;?></h3>

                      <h6 style='color:maroon; font-weight:bold;'><?php echo $poster_name ?></h6>
                      <h6>Total Mark: <?php echo $TotalMark; ?></h6>
                      <div class="card">
                          <?php if(!empty($qaDetails)){ ?>
                          <div class="card-body">
                            <p class="card-text"><?php echo $qaDetails; ?></p>
                          </div>
                      <?php } ?>
                          <div class="card-footer"><a href="task/<?php echo $filename; ?>"><h6 class="card-text"><?php echo $filename; ?></h6></a></div>
                      </div>
                  </div>
                  <div style="padding: 10px 20px;">
                    <?php 
                        if($userType=="student"){
                            $checkSubmission = mysqli_query($con, "SELECT * FROM `task_submit` WHERE student = '$user' AND task_id = '$task_id'");

                            

                        ?>
                    <?php if(isset($msg))echo $msg; ?>
                        <?php if($fl==0){?>
                    <form method="post"  enctype="multipart/form-data">
                        <label style="color:blue;" for="file">Submit Task: </label>
                        <input type="file" required id="file" name="rfile" class="form-control-file">    
                        <br>
                        <button type="submit" name="submit" id="commentBtn" class="btn btn-info" <?php if(mysqli_num_rows($checkSubmission)>0)echo "disabled";  ?>>Submit</button>
                    </form>
                        <?php }else{?>
                        <h5>Submission is closed.</h5>
                        <?php } ?>
                    <?php } ?>
                  </div>
        		</div>
                <?php if($userType=="teacher"){?>
                <div class="box2nd90">
                    <h5 class="box2ndHeader">Submitted Tasks by students:<span class="boxSpan"><form method="post"><button style="" class="" type="submit" name="publish" <?php if($published=='1')echo "disabled"; ?>><?php if($published=='1'){echo "Published";}else echo "Publish" ?></button></form></span></h5>
                        <?php
                            $qx= mysqli_query($con, "SELECT * FROM task_submit WHERE task_id = '$task_id'");
                            if(mysqli_num_rows($qx)>0){
                                while($row=mysqli_fetch_array($qx)){
                                    $id = $row['id'];
                                    $file = $row['file_name'];
                                    $student = $row['student'];
                                    $mark = $row['mark'];
                                    $student_info = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$student'");
                                    $row = mysqli_fetch_array($student_info);
                                    $student_name = $row['name'];
                                    $student_roll = $row['roll'];

                        ?>
                        <div class="card">
                          <div class="card-footer form-inline">
                            <a href="task_submit/<?php echo $file; ?>"><h6 class="card-text"><?php echo $student_name; ?> - Roll:<?php echo $student_roll ?> <?php echo $file; ?></h6></a>&nbsp;&nbsp;&nbsp;
                            <form class="" method="post">
                                <input type="text" name="<?php echo 'mark'.$id; ?>" class="form-control">&nbsp;&nbsp;&nbsp;
                                <button class="btn btn-warning" <?php if($mark!=0)echo "disabled"; ?> type="submit" name="<?php echo 'submitmark'.$id; ?>">Give Mark</button>&nbsp;
                            </form>

                        <?php

                                    if(isset($_POST['submitmark'.$id])){
                                        $checkmark = mysqli_query($con, "SELECT * FROM task_submit WHERE id = '$id'");
                                        $row = mysqli_fetch_array($checkmark);
                                        $givenMark = $row['mark'];
                                        if($givenMark>0){
                                            echo " Already Given ".$givenMark." marks";
                                        }
                                        else{
                                            $Xmark = $_POST['mark'.$id];
                                            $updateMark = mysqli_query($con, "UPDATE `task_submit` SET `mark` = '$Xmark' WHERE `task_submit`.`id` = '$id';");
                                            if($updateMark) echo " Given ".$Xmark." marks";
                                        }
                                    }  
                        ?>
                            </div>
                        </div>
                        <?php
                                }
                            }
                            else{
                                echo "<h5 style='padding:10px 20px; color:#7f7f7f;'>Nothing Found</h5>";
                            }
                        ?>
                      
                </div>
                <?php }else if($userType=="student"){ 
                        if($published=='1'){

                        
                    ?>
                        <div class="box90">
                            <h5 class="boxHeader">Marks:</h5>
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">Roll</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Mark</th>
                                </tr>
                              </thead>
                              <tbody>
                        <?php
                            $qx= mysqli_query($con, "SELECT * FROM task_submit WHERE task_id = '$task_id'");
                            if(mysqli_num_rows($qx)>0){
                                while($row=mysqli_fetch_array($qx)){
                                
                                    $student = $row['student'];
                                    $mark = $row['mark'];
                                    $student_info = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$student'");
                                    $row = mysqli_fetch_array($student_info);
                                    $student_name = $row['name'];
                                    $student_roll = $row['roll'];
                        ?>
                                <tr>
                                  <td><?php echo $student_roll; ?></td>
                                  <td><?php echo $student_name; ?></td>
                                  <td><?php echo $mark; ?></td>
                                </tr>
                            <?php
                                    }
                                }
                            ?>
                              </tbody>
                            </table>
                        </div>
                <?php 
                        }
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