<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
     
    $msg = "";

    if(isset($_GET['id'])){
        $notice_id = $_GET['id'];
    }

    $getNoticeDetials = mysqli_query($con, "SELECT * FROM notice WHERE id = '$notice_id'");
    if(mysqli_num_rows($getNoticeDetials)>0){
        $row = mysqli_fetch_array($getNoticeDetials);
        $title = $row['title'];
        $details = $row['details'];
        $teacher = $row['teacher'];
        $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$teacher'");
        $rows = mysqli_fetch_array($teacher_info);
        $teacher_name = $rows['name'];
        $time = date('d M h:i A', strtotime($row['timestamp']));

    }
    else{
        $msg = "<div class='alertDanger'>
                    <i class='fa fa-check'></i> 404 Not Found.
                </div>"; 
    }
    
?>

<!-- SECTION STARTS HERE -->
    <!--Please, place all your div/box/anything inside the above SECTION-->
    <div class="section" style="">
        <?php
            if(isset($msg))echo $msg;
        ?>
        <div class="box80">
            <!-- <a href='notice.php'><button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Go Back</button></a>
           <br>
           <br>  -->
            <?php
                if(isset($msg))echo $msg;
            ?>
            <h6 style="float: right;">Posted: <?php echo $time; ?></h6>
            <h5 class="boxHeader"><?php echo $title; ?></h5>
            <h6 style="color:Maroon; font-weight:bold;"><?php echo $teacher_name; ?></h6>
            <div style="background-color: #f9f9f9;border: 1px dashed #e5e5e5; border-radius: 5px; padding: 10px">
                <?php echo $details; ?>
            </div>
        </div>
    </div>
    
    <!--Please, place all your div/box/anything inside the above SECTION-->

<?php
    require_once('inc/footer.php');
?>