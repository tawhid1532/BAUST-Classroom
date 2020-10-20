<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    else if($userType=='student'){
        header('Location: index.php');   
    }

    if(isset($_GET['delete_type'])){
        $delete_type = $_GET['delete_type'];
        if($delete_type=="online_exam"){
            if(isset($_GET['exam_id'])){
                $exam_id = $_GET['exam_id'];
            }
        }
        else if($delete_type == "task"){
            if(isset($_GET['task_id'])){
                $task_id = $_GET['task_id'];
            }   
        }
        else if($delete_type == "attendance"){
            if(isset($_GET['attendance_id'])){
                $attendance_id = $_GET['attendance_id'];
            }   
        }
        else if($delete_type == "student"){
            if(isset($_GET['email'])){
                $student_email = $_GET['email'];
            }   
        }
        else if($delete_type == "teacher"){
            if(isset($_GET['email'])){
                $teacher_email = $_GET['email'];
            }   
        }    
    }
    $msg = "";

    if(isset($_POST['deleteit'])){
        if($delete_type == 'online_exam'){
            $archive = mysqli_query($con, "DELETE FROM `online_exam` WHERE `online_exam`.`id` = '$exam_id';");
            if($archive){
                $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully deleted exam.
                </div>"; 
            }
            else{
                $msg = "<div class='alertDanger'>
                    <i class='fa fa-check'></i> Something went wrong.
                </div>"; 
            }
        }
        else if($delete_type == 'task'){
            $archive = mysqli_query($con, "DELETE FROM `task` WHERE `task`.`id` = '$task_id';");
            if($archive){
                $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully deleted task.
                </div>"; 
            }
            else{
                $msg = "<div class='alertDanger'>
                    <i class='fa fa-check'></i> Something went wrong.
                </div>"; 
            }
        }
        else if($delete_type == 'attendance'){
            $archive = mysqli_query($con, "DELETE FROM `attendance_info` WHERE `attendance_info`.`id` = '$attendance_id';");
            if($archive){
                $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully deleted task.
                </div>"; 
            }
            else{
                $msg = "<div class='alertDanger'>
                    <i class='fa fa-check'></i> Something went wrong.
                </div>"; 
            }
        }

        else if($delete_type == 'student'){
            $archive = mysqli_query($con, "DELETE FROM `student_register` WHERE `student_register`.`email` = '$student_email';");
            if($archive){
                $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully deleted Student.
                </div>"; 
            }
            else{
                $msg = "<div class='alertDanger'>
                    <i class='fa fa-check'></i> Something went wrong.
                </div>"; 
            }
        }
        else if($delete_type == 'teacher'){
            $archive = mysqli_query($con, "DELETE FROM `teacher_register` WHERE `teacher_register`.`email` = '$teacher_email';");
            if($archive){
                $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully deleted Student.
                </div>"; 
            }
            else{
                $msg = "<div class='alertDanger'>
                    <i class='fa fa-check'></i> Something went wrong.
                </div>"; 
            }
        }

    }
    
?>

<!-- SECTION STARTS HERE -->
    <!--Please, place all your div/box/anything inside the above SECTION-->
    <div class="section" style="">
        <?php
            if(isset($msg2))echo $msg2;
        ?>
        <div class="box30">
            <a 
                href='<?php 
                    if($delete_type == "online_exam")
                    {
                        echo "online_exams.php";
                    }
                    else if($delete_type == "task"){
                        echo "tasks.php";   
                    }
                    else if($delete_type == "attendance"){
                        echo "attendance.php";   
                    }
                    else if($delete_type == "teacher" || $delete_type == "student"){
                        echo "admin.php";   
                    }
                    ?>'><button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Go Back</button></a>
           <br>
           <br> 
            <?php
                if(isset($msg))echo $msg;
            ?>
            <h5 class="boxHeader">Are you sure you want delete this?</h5>
            <form method="post">
                <button type="submit" name="deleteit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
    
    <!--Please, place all your div/box/anything inside the above SECTION-->

<?php
    require_once('inc/footer.php');
?>