<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    if(isset($_GET['userType'])){
        $TypeUser = $_GET['userType'];
    }
    if(isset($_GET['id'])){
        $userId = $_GET['id'];
    }
    if($TypeUser == 'student'){
        $qr = mysqli_query($con, "SELECT * FROM student_register WHERE id = '$userId'");
        $row = mysqli_fetch_array($qr);
        $name = $row['name'];   
        $studentClass = $row['class'];
        $studentSection = $row['section'];
        $studentRoll = $row['roll'];
        $email = $row['email'];
    }
    else if($TypeUser == 'teacher'){
        $qr = mysqli_query($con, "SELECT * FROM teacher_register WHERE id = '$userId'");
        $row = mysqli_fetch_array($qr);
        $name = $row['name'];
        $designation = $row['designation'];
        $email = $row['email'];
    }

    if(isset($_POST['studentUpdate'])){
        $Sname = $_POST['name'];
        $class = $_POST['class'];
        $section = $_POST['section'];
        $roll = $_POST['roll'];
        $qx = mysqli_query($con, "UPDATE `student_register` SET `name` = '$Sname', `roll` = '$roll', `class` = '$class', `section` = '$section' WHERE `student_register`.`id` = '$userId';");
        if($qx){
            $msg = "<div class='alertSuccess'>
                <i class='fa fa-check'></i> Successfully Updated!
        </div>";
        }
        else{
            $msg = "<div class='alertDanger'>
                <i class='fa fa-times'></i> Something went wrong! Please try again.
        </div>";
        }
    }
    if(isset($_POST['teacherUpdate'])){
        $Tname = $_POST['name'];
        $designation = $_POST['designation'];
        $qx = mysqli_query($con, "UPDATE `teacher_register` SET `name` = '$Tname', `designation` = '$designation' WHERE `teacher_register`.`id` = '$userId';");
        if($qx){
            $msg = "<div class='alertSuccess'>
                <i class='fa fa-check'></i> Successfully Updated!
        </div>";
        }
        else{
            $msg = "<div class='alertDanger'>
                <i class='fa fa-times'></i> Something went wrong! Please try again.
        </div>";
        }
    }
?>
<input type="hidden" id="hiddenName" value="<?php echo $name; ?>">

<!--SECTION STARTS HERE -->
    <!--Please, place all your div/box/anything inside the above SECTION-->
    <div class="section" style="">
        <div class="box40">
            <h5 class="boxHeader">Edit Profile Info:</h5>
            <?php
            if($TypeUser == 'teacher'){
            ?>
            <?php if(isset($msg))echo $msg; ?>
            <form method="post">
                <label style="color:green;" for="nameOfTeacher">Name:</label>
                <input required id="nameOfTeacher" type="text" name="name" placeholder="Enter your name" class="form-control" value="<?php if(isset($name))echo $name; ?>">
                <br>
                <label style="color:green;" for="Temail">Email:</label>
                <input required id="Temail" type="email" name="email" placeholder="Enter your email" class="form-control" readonly value="<?php if(isset($email))echo $email; ?>">
                <br>
                <label style="color:green;" for="designation">Designation:</label>
                <input required id="designation" type="text" name="designation" placeholder="Enter your Designation" class="form-control" value="<?php if(isset($designation))echo $designation; ?>">
                
                <br>
                <br>
                <button type="submit" id="signUpBtn" name="teacherUpdate" class="btn btn-success">Update</button>
            </form>
            <?php
            }else if($TypeUser == 'student'){
            ?>
            <?php if(isset($msg))echo $msg; ?>
            <form method="post">
                <label style="color:blue;" for="nameOfUser">Name:</label>
                <input required id="nameOfUser" type="text" name="name" placeholder="Enter your name" class="form-control" value="<?php if(isset($name))echo $name; ?>">
                <br>
                <label style="color:blue;" for="email">Email:</label>
                <input required id="email" type="email" name="email" placeholder="Enter your email" class="form-control" readonly value="<?php if(isset($email))echo $email; ?>">
                <br>
                <label style="color:blue;" for="class">Class:</label>
                <select required id="class" name="class" class="form-control">
                    <option value="" disabled selected>Select Class</option>
                    <option value="Level 1 Term 1"<?php if($studentClass == "Level 1 Term 1")echo "selected"; ?>>Level 1 Term 1</option>
                    <option value="Level 1 Term 2"<?php if($studentClass == "Level 1 Term 2")echo "selected"; ?>>Level 1 Term 2</option>
                    <option value="Level 2 Term 1"<?php if($studentClass == "Level 2 Term 1")echo "selected"; ?>>Level 2 Term 1</option>
                    <option value="Level 2 Term 2"<?php if($studentClass == "Level 2 Term 2")echo "selected"; ?>>Level 2 Term 2</option>
                    <option value="Level 3 Term 1"<?php if($studentClass == "Level 3 Term 1")echo "selected"; ?>>Level 3 Term 1</option>
                    <option value="Level 3 Term 2"<?php if($studentClass == "Level 3 Term 2")echo "selected"; ?>>Level 3 Term 2</option>
                    <option value="Level 4 Term 1"<?php if($studentClass == "Level 4 Term 1")echo "selected"; ?>>Level 4 Term 1</option>
                    <option value="Level 4 Term 2"<?php if($studentClass == "Level 4 Term 2")echo "selected"; ?>>Level 4 Term 2</option>
                </select>
                <br>
                <label style="color:blue;" for="section">Section:</label>
                <select required id="section" name="section" class="form-control">
                    <option value="" disabled selected>Select Section</option>
                    <option value="A"<?php if($studentSection == 'A')echo "selected"; ?>>A</option>
                    <option value="B"<?php if($studentSection == 'B')echo "selected"; ?>>B</option>
                </select>
                <br>
                <label style="color:blue;" for="roll">Roll:</label>
                <input required id="roll" type="text" name="roll" placeholder="Enter your roll" class="form-control" value="<?php if(isset($studentRoll))echo $studentRoll; ?>">
                
                <br>
                <button type="submit" id="signUpBtn" name="studentUpdate" class="btn btn-success">Update</button>
            </form>
            <?php
            }
            ?>
        </div>
    </div>
    <!--Please, place all your div/box/anything inside the above SECTION-->

<?php
    require_once('inc/footer.php');
?>