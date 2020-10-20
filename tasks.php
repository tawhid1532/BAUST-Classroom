<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
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
            $qr = mysqli_query($con, "INSERT INTO `task`(`id`, `title`, `details`, `class`, `filename`, `date`, `time`, `teacher`, `publish`, `archived`, `mark`)  VALUES (NULL, '$title', '$details', '$class', '$filename', '$date', '$time', '$user', '0', 0, '$mark');");
            $up = move_uploaded_file($file_tmp,"task/".$filename);   
            if($qr){
                $msg = "<div class='alertSuccess'>
                            <i class='fa fa-check'></i> Successfully Submitted Task
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
        <?php
            if(isset($_GET['showArchive'])){
             
                if($userType == 'teacher'){
                ?>
                <div class="box90" style="margin-top:20px;">
                    <a href="tasks.php"><button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Go Back</button></a>
                     <br>
                     <br>
                    <h5 class="boxHeader">Archived Tasks:</h5>
                <?php
                    

                    $task_data = mysqli_query($con, "SELECT * FROM `task` WHERE teacher = '$user' AND archived = 1 ORDER BY id DESC");
                    if(mysqli_num_rows($task_data)>0){
                        while($row = mysqli_fetch_array($task_data)){
                            $id = $row['id'];
                            $class = $row['class'];
                            $title = $row['title'];
                            $dealine_date = date('d M', strtotime($row['date']));
                            $dealine_time = date('h:i A', strtotime($row['time']));
                            
                            
                ?>
                    
                    <a style="text-decoration: none;" href="task_details.php?id=<?php echo $id; ?>"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                    <p style="font-weight: bold;margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                    <h1>Deadline: <?php echo $dealine_date;?> <?php echo $dealine_time;?></h1>
                    <h1>For <span style="color:teal;"><?php echo $class; ?></span></h1>
                    </div></a>
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
                else if($userType=='student'){
                ?>
                <div class="box80" style="margin-top:20px;">
                    <h5 class="boxHeader">Your Tasks:</h5>
                <?php
                    $qx = mysqli_query($con, "SELECT * FROM task WHERE class = '$studentClass'");
                    if(mysqli_num_rows($qx)>0){
                        while($row = mysqli_fetch_array($qx)){
                            $id = $row['id'];
                            $class = $row['class'];
                            $title = $row['title'];
                            $teacher = $row['teacher'];
                            $dealine_date = date('d M', strtotime($row['date']));
                            $dealine_time = date('h:i A', strtotime($row['time']));
                            $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$teacher'");
                            $row = mysqli_fetch_array($teacher_info);
                            $teacher_name = $row['name'];

                            
                ?>
                    <a style="text-decoration: none;" href="task_details.php?id=<?php echo $id; ?>"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                    <p style="font-weight: bold;margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                    <h1>Deadline: <?php echo $dealine_date;?> <?php echo $dealine_time;?></h1>
                    <h1>For <span style="color:teal;"><?php echo $class; ?></span></h1>
                    <h1>by <span style="color:maroon;"><?php echo $teacher_name; ?></span></h1>
                    </div></a>
                <?php

                        }
                    }
                    else{
                ?>
                    <h6 style="color:#7f7f7f; font-style: italic;">There is no attendance info available for your class</h6>
                <?php
                    }
                ?>
                </div>
                <?php
                }
                ?>
            <?php
            }
            else{
        ?>
        <div class="row">
            <div class="col-md-10">
                <?php 
                    if($userType == 'teacher'){
                ?>
        		<div class="box80">
                    <button id="showButton" onclick="showForm()" type="button" style="float:right;" class="btn btn-outline-info"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    <button id="hideButton" onclick="hideForm()" type="button" style="float:right; display:none" class="btn btn-outline-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
            		<h5 class="boxHeader">Create New Task:</h5>
                    <?php
                        if(isset($msg))echo $msg;
                    ?>
                    <form method="post" enctype="multipart/form-data" id="setTaskForm" style="display:none">
                        <label style="color:blue;" for="title">Title:</label>
                        <input type="text" required id="title" name="rtitle" class="form-control" placeholder="Write a title for your resource">
                        <br>
                        <label style="color:blue;" for="description">Description: (Optional)</label>
                        <textarea name="rdescription" class="form-control" placeholder="You can write a short description about your resource"></textarea>
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
                        <label style="color:blue;" for="file">Upload File: </label>
                        <input type="file" required id="file" name="rfile" class="form-control-file">    
                        <br>
                        <label style="color:blue;" for="">Deadline Date & Time: </label>
                        <div class="form-inline">
                            <input type="date" required name="date" class="form-control">    
                            &nbsp;&nbsp;&nbsp;
                            <input type="time" required name="time" class="form-control">    
                        </div>
                        <br>
                        <label style="color:blue;" for="mark">Total Mark: </label>
                        <input type="number" id="mark" class="form-control" required name="mark" placeholder="Total Mark of this task">
                        <br>
                        <button type="submit" name="submitTask" id="shareBtn" class="btn btn-info">Submit Task</button>
                    </form>
        		</div>
                <div class="box80" style="margin-top:20px;">
        		    <h5 class="boxHeader">Your Tasks:</h5>
                <?php
                    

                    $task_data = mysqli_query($con, "SELECT * FROM `task` WHERE teacher = '$user' AND archived = 0 ORDER BY id DESC");
                    if(mysqli_num_rows($task_data)>0){
                        while($row = mysqli_fetch_array($task_data)){
                            $id = $row['id'];
                            $class = $row['class'];
                            $title = $row['title'];
                            $dealine_date = date('d M', strtotime($row['date']));
                            $dealine_time = date('h:i A', strtotime($row['time']));
                            
                            
                ?>
                    
                    <a style="text-decoration: none;" href="task_details.php?id=<?php echo $id; ?>"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                    <p style="font-weight: bold;margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                    <h1>Deadline: <?php echo $dealine_date;?> <?php echo $dealine_time;?></h1>
                    <h1>For <span style="color:teal;"><?php echo $class; ?></span></h1>
                    </div></a>
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
                else if($userType=='student'){
                ?>
                <div class="box80" style="margin-top:20px;">
                    <h5 class="boxHeader">Your Tasks:</h5>
                <?php
                    $qx = mysqli_query($con, "SELECT * FROM task WHERE class = '$studentClass' ORDER By id DESC ");
                    if(mysqli_num_rows($qx)>0){
                        while($row = mysqli_fetch_array($qx)){
                            $id = $row['id'];
                            $class = $row['class'];
                            $title = $row['title'];
                            $teacher = $row['teacher'];
                            $dealine_date = date('d M', strtotime($row['date']));
                            $dealine_time = date('h:i A', strtotime($row['time']));
                            $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$teacher'");
                            $row = mysqli_fetch_array($teacher_info);
                            $teacher_name = $row['name'];

                            
                ?>
                    <a style="text-decoration: none;" href="task_details.php?id=<?php echo $id; ?>"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                    <p style="font-weight: bold;margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                    <h1>Deadline: <?php echo $dealine_date;?> <?php echo $dealine_time;?></h1>
                    <h1>For <span style="color:teal;"><?php echo $class; ?></span></h1>
                    <h1>by <span style="color:maroon;"><?php echo $teacher_name; ?></span></h1>
                    </div></a>
                <?php

                        }
                    }
                    else{
                ?>
                    <h6 style="color:#7f7f7f; font-style: italic;">There is no attendance info available for your class</h6>
                <?php
                    }
                ?>
                </div>
                <?php
                }

                if($userType=='teacher'){
                ?>
                <a href="tasks.php?showArchive=1"><button class="btn btn-secondary" style="margin-left: 10%">Show Archive</button></a>
            <?php } ?>
            </div>
            <?php
                require_once('inc/chatbar.php');
            ?>
        </div>
        <?php
            }
        ?>
	</div>
    <script>
        
        function showForm(){
            document.getElementById("setTaskForm").style.display = "block"
            document.getElementById("hideButton").style.display = "block"
            document.getElementById("showButton").style.display = "none"
        }

        function hideForm(){
            document.getElementById("setTaskForm").style.display = "none"
            document.getElementById("hideButton").style.display = "none"
            document.getElementById("showButton").style.display = "block"
        }

    </script>
	<!--Please, place all your div/box/anything inside the above SECTION-->

<?php
	require_once('inc/footer.php');
?>