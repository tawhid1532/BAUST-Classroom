<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
     else if($userType=='student'){
        header('Location: index.php');   
    }
    if(isset($_GET['archive_type'])){
        $archive_type = $_GET['archive_type'];
        if($archive_type=="online_exam"){
            if(isset($_GET['exam_id'])){
                $exam_id = $_GET['exam_id'];
            }
        }
        else if($archive_type == "task"){
            if(isset($_GET['task_id'])){
                $task_id = $_GET['task_id'];
            }   
        }
        else if($archive_type == "attendance"){
            if(isset($_GET['attendance_id'])){
                $attendance_id = $_GET['attendance_id'];
            }   
        }    
    }
    $msg = "";

    if(isset($_POST['archiveit'])){
        if($archive_type == 'online_exam'){
            $archive = mysqli_query($con, "UPDATE `online_exam` SET `archived` = '1' WHERE `online_exam`.`id` = '$exam_id';");
            if($archive){
                $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully archived exam.
                </div>"; 
            }
            else{
                $msg = "<div class='alertDanger'>
                    <i class='fa fa-check'></i> Something went wrong.
                </div>"; 
            }
        }
        else if($archive_type == 'task'){
            $archive = mysqli_query($con, "UPDATE `task` SET `archived` = '1' WHERE `task`.`id` = '$task_id';");
            if($archive){
                $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully archived task.
                </div>"; 
            }
            else{
                $msg = "<div class='alertDanger'>
                    <i class='fa fa-check'></i> Something went wrong.
                </div>"; 
            }
        }
        else if($archive_type == 'attendance'){
            $archive = mysqli_query($con, "UPDATE `attendance_info` SET `archived` = '1' WHERE `attendance_info`.`id` = '$attendance_id';");
            if($archive){
                $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully archived attendance.
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
        
        <div class="box30">
            <a 
                href='<?php 
                    if($archive_type == "online_exam")
                    {
                        echo "online_exams.php";
                    }
                    else if($archive_type == "task"){
                        echo "tasks.php";   
                    }
                    else if($archive_type == "attendance"){
                        echo "attendance.php";   
                    }
                    ?>'>
                <button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Go Back</button>
            </a>
           <br>
           <br> 
            <?php
                if(isset($msg))echo $msg;
            ?>
            <h5 class="boxHeader">Are you sure you want archive this?</h5>
            <form method="post">
                <button type="submit" name="archiveit" class="btn btn-danger">Archive</button>
            </form>
        </div>
    </div>
    
    <!--Please, place all your div/box/anything inside the above SECTION-->

<?php
    require_once('inc/footer.php');
?>