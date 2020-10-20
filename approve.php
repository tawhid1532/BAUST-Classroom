<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    else if($userType=='student'){
        header('Location: index.php');   
    }

    if(isset($_GET['user_type'])){
        $user_type = $_GET['user_type'];
        if($user_type == "student"){
            if(isset($_GET['email'])){
                $student_email = $_GET['email'];
            }   
        }
        else if($user_type == "teacher"){
            if(isset($_GET['email'])){
                $teacher_email = $_GET['email'];
            }   
        }    
    }
    $msg = "";

    if(isset($_POST['deleteit'])){
        if($user_type == 'student'){
            $archive = mysqli_query($con, "UPDATE `student_register` SET `approved` = '1' WHERE `student_register`.`email` = '$student_email';");
            if($archive){
                $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully Approved Student.
                </div>"; 
            }
            else{
                $msg = "<div class='alertDanger'>
                    <i class='fa fa-check'></i> Something went wrong.
                </div>"; 
            }
        }
        else if($user_type == 'teacher'){
            $archive = mysqli_query($con, "UPDATE `teacher_register` SET `approved` = '1' WHERE `teacher_register`.`email` = '$teacher_email';");
            if($archive){
                $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully Approved Teacher.
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
                href='admin.php'><button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Go Back</button></a>
           <br>
           <br> 
            <?php
                if(isset($msg))echo $msg;
            ?>
            <h5 class="boxHeader">Are you sure you want Approve this user?</h5>
            <form method="post">
                <button type="submit" name="deleteit" class="btn btn-danger">Approve</button>
            </form>
        </div>
    </div>
    
    <!--Please, place all your div/box/anything inside the above SECTION-->

<?php
    require_once('inc/footer.php');
?>