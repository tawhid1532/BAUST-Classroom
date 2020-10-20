<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    if(isset($_GET['id'])){
        $task_id = $_GET['id'];
    }   
    
    $task_query = mysqli_query($con, "SELECT * FROM `task` WHERE `id` = '$task_id'");
    if(mysqli_num_rows($task_query)>0){
        $row = mysqli_fetch_array($task_query);
        $qaHeading = $row['title'];
        $qaDetails = $row['details'];
        $class = $row['class'];
        $mark=$row['mark'];
        $poster = $row['teacher'];
        $filename = $row['filename'];
        $dealine_date = date('d M', strtotime($row['date']));
        $dealine_time = date('h:i A', strtotime($row['time']));
        date_default_timezone_set("Asia/Dhaka");
        $dd = $row['date'];
        $dt = $row['time'];
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');
        $isArchived = 0;
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
    if(isset($_POST['submitTask'])){
        $title = mysqli_real_escape_string($con,$_POST['rtitle']);
        $details = mysqli_real_escape_string($con,$_POST['rdescription']);
        $filename = $_FILES['rfile']['name'];
        $file_size =$_FILES['rfile']['size'];
        $file_tmp =$_FILES['rfile']['tmp_name'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $class = $_POST['class'];
        $mark = $_POST['mark'];
        if($file_size < 209710000){
            $qr = mysqli_query($con, "UPDATE `task` SET `title` = '$title', `details` = 'details', `class` = '$class', `filename` = '$filename', `date` = '$date', `time` = '$time', `mark`= '$mark' WHERE `task`.`id` = '$task_id';");
            $up = move_uploaded_file($file_tmp,"task/".$filename);   
            if($qr){
                $msg = "<div class='alertSuccess'>
                            <i class='fa fa-check'></i> Successfully Updated Task
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
        		 <h5 class="boxHeader">Update Task:</h5>
                    <?php
                        if(isset($msg))echo $msg;
                    ?>
                    <form method="post" enctype="multipart/form-data">
                        <label style="color:blue;" for="title">Title:</label>
                        <input type="text" required id="title" name="rtitle" class="form-control" placeholder="Write a title for your resource" value="<?php echo $qaHeading; ?>">
                        <br>
                        <label style="color:blue;" for="description">Description: (Optional)</label>
                        <textarea name="rdescription" class="form-control" placeholder="You can write a short description about your resource" ><?php echo $qaDetails; ?></textarea>
                        <br>  
                        <label style="color:blue;" for="class">Class:</label>
                        <select required id="class" name="class" class="form-control">
                            <option value="" disabled>Select Class</option>
                            <option 
                                value="Level 1 Term 1"
                                <?php if($class == "Level 1 Term 1"){echo "selected";}?>
                                >
                                Level 1 Term 1
                            </option>
                            <option 
                                value="Level 1 Term 2" 
                                <?php if($class == "Level 1 Term 2"){echo "selected";}?>
                                >
                                Level 1 Term 2
                            </option>
                            <option 
                                value="Level 2 Term 1"
                                <?php if($class == "Level 2 Term 1"){echo "selected";}?>
                                >
                                Level 2 Term 1
                            </option>
                            <option 
                                value="Level 2 Term 2"
                                <?php if($class == "Level 2 Term 2"){echo "selected";}?>
                                >
                                Level 2 Term 2
                            </option>
                            <option 
                                value="Level 3 Term 1"
                                <?php if($class == "Level 3 Term 1"){echo "selected";}?>
                                >
                                Level 3 Term 1
                            </option>
                            <option 
                                value="Level 3 Term 2"
                                <?php if($class == "Level 3 Term 2"){echo "selected";}?>
                                >
                                Level 3 Term 2
                            </option>
                            <option 
                                value="Level 4 Term 1" 
                                <?php if($class == "Level 4 Term 1"){echo "selected";}?>
                                >
                                Level 4 Term 1
                            </option>
                            <option 
                                value="Level 4 Term 2"
                                <?php if($class == "Level 4 Term 2"){echo "selected";}?>
                                >
                                Level 4 Term 2
                            </option>
                        </select>
                        <br>
                        <label style="color:blue;" for="file">Upload File: </label>
                        <input type="file" required id="file" name="rfile" class="form-control-file">    
                        <br>
                        <label style="color:blue;" for="">Deadline Date & Time: </label>
                        <div class="form-inline">
                            <input type="date" required name="date" class="form-control" value="<?php echo $dd; ?>">    
                            &nbsp;&nbsp;&nbsp;
                            <input type="time" required name="time" class="form-control" value="<?php echo $dt; ?>">    
                        </div>
                        <br>
                        <label style="color:blue;" for="mark">Total Mark: </label>
                        <input type="number" id="mark" class="form-control" required name="mark" placeholder="Total Mark of this task" value="<?php echo $mark;?>">
                        <br>
                        <button type="submit" name="submitTask" id="shareBtn" class="btn btn-info">Update Task</button>
                    </form>
        		</div>
                <?php } ?>
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