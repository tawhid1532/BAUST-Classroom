<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
        
    $msg="";
    if(isset($_POST['submit'])){
        $class = $_POST['class'];
        $section = $_POST['section'];
        $session = $_POST['session'];
        $check = mysqli_query($con, "SELECT * FROM attendance_info WHERE teacher = '$user' AND class = '$class' AND section = '$section' AND archived = 0");
        if(mysqli_num_rows($check)>0){
            $msg = "<div class='alertDanger'>
                        <i class='fa fa-times'></i> You have already created an attendance sheet for this class
                </div>";
        }
        else{
            $qr = mysqli_query($con, "INSERT INTO `attendance_info`(`id`, `teacher`, `class`, `section`, `session`, `archived`) VALUES (NULL, '$user', '$class', '$section','$session', 0);");
            if($qr){
                $msg = "<div class='alertSuccess'>
                            <i class='fa fa-check'></i> Successfully Created!
                    </div>";
            }
            else{
                $msg = "<div class='alertDanger'>
                            <i class='fa fa-times'></i> Something went wrong! Please try again.
                    </div>";
            }
        }
}
?>

<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
	<div class="section" style="">
        <?php
        if(isset($_GET['showArchive'])){
        ?>
        <div class="box80" style="margin-top:20px;">
                <a href="attendance.php"><button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Go Back</button></a>
                <br>
                <br>
                <h5 class="boxHeader">Archived Attendance Sheets:</h5>
                <?php
                    

                    $attendence_data = mysqli_query($con, "SELECT * FROM `attendance_info` WHERE teacher = '$user' AND archived = 1");
                    if(mysqli_num_rows($attendence_data)>0){
                        while($row = mysqli_fetch_array($attendence_data)){
                            $id = $row['id'];
                            $class = $row['class'];
                            $section = $row['section'];
                            $session = $row['session'];
                            $className = $class .' - '.$section . ' Section -'.$session.' Session';
                ?>
                    <a href="attendance_list.php?id=<?php echo $id; ?>" style="text-decoration:none;"><div style="background:#A7CDF2; padding:15px; font-weight:bold; margin-top:10px; "><?php echo $className; ?></div></a>
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
        		    <h5 class="boxHeader">Create New Attendance Sheet:</h5>
                    <?php
                        if(isset($msg))echo $msg;
                    ?>
                    <form method="post" id="NewAttendenceForm" style="display:none">
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
                        <input type="text" name="session" class="form-control" placeholder="Ex: 2016-17">
        			 	<br>
        			 	<button type="submit" name="submit" id="createBtn" class="btn btn-info">Create</button>
                    </form>
        		</div>
                <div class="box80" style="margin-top:20px;">
        		    <h5 class="boxHeader">Your Attendance Sheets:</h5>
                <?php
                    

                    $attendence_data = mysqli_query($con, "SELECT * FROM `attendance_info` WHERE teacher = '$user' AND archived = 0");
                    if(mysqli_num_rows($attendence_data)>0){
                        while($row = mysqli_fetch_array($attendence_data)){
                            $id = $row['id'];
                            $class = $row['class'];
                            $section = $row['section'];
                            $session = $row['session'];
                            $className = $class .' - '.$section . ' Section - '.$session.' Session';
                ?>
                    <a href="attendance_list.php?id=<?php echo $id; ?>" style="text-decoration:none;"><div style="background:#A7CDF2; padding:15px; font-weight:bold; margin-top:10px; "><?php echo $className; ?></div></a>
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
                    <h5 class="boxHeader">Your Attendance Sheets:</h5>
                <?php
                    $qx = mysqli_query($con, "SELECT * FROM attendance_info WHERE section = '$studentSection' AND class = '$studentClass' AND archived = 0");
                    if(mysqli_num_rows($qx)>0){
                        while($row = mysqli_fetch_array($qx)){
                            $id = $row['id'];
                            $class = $row['class'];
                            $section = $row['section'];
                            $session = $row['session'];
                            $teacher = $row['teacher'];
                            $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$teacher'");
                            $row = mysqli_fetch_array($teacher_info);
                            $teacher_name = $row['name'];
                            $className = $class .' - '.$section . ' Section - '.$session.' session - '.$teacher_name.' Sir';
                ?>
                    <a href="take_attendance.php?id=<?php echo $id; ?>" style="text-decoration:none;"><div style="background:#A7CDF2; padding:15px; font-weight:bold; margin-top:10px; "><?php echo $className; ?></div></a>
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
                <a href="attendance.php?showArchive=1"><button class="btn btn-secondary" style="margin-left: 10%">Show Archive</button></a>
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
            document.getElementById("NewAttendenceForm").style.display = "block"
            document.getElementById("hideButton").style.display = "block"
            document.getElementById("showButton").style.display = "none"
        }

        function hideForm(){
            document.getElementById("NewAttendenceForm").style.display = "none"
            document.getElementById("hideButton").style.display = "none"
            document.getElementById("showButton").style.display = "block"
        }

    </script>
	<!--Please, place all your div/box/anything inside the above SECTION-->

<?php
	require_once('inc/footer.php');
?>