<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
     else if($userType=='student'){
        header('Location: index.php');   
    }
    if(isset($_GET['id'])){
        $exam_id = $_GET['id'];
    }  
    date_default_timezone_set("Asia/Dhaka");
    $msg="";
    if(isset($_POST['submit'])){
        $class = $_POST['class'];
        $section = $_POST['section'];
        $title = $_POST['title'];
        $subject = $_POST['subject'];
        $noq = $_POST['noq'];
        $date = $_POST['date'];
        $start_time = $_POST['start'];
        /*$start_timef =  new DateTime($start_time);
        $count = $noq*30;
        $end_time = $start_timef->modify('+'.$count.' seconds');
        $end_time = $end_time->format("H:i:s");*/
        $markMcq = $_POST['markMcq'];
        $markSq = $_POST['markSq'];
        $end_time = $_POST['end'];
        $qr = mysqli_query($con, "UPDATE `online_exam` SET `title` = '$title', `subject` = '$subject', `class` = '$class', `section` = '$section', `start` = '$start_time', `end` = '$end_time', `date` = '$date', `no_of_question` = '$noq', `mark_per_mcq` = '$markMcq', `mark_per_sq` = '$markSq' WHERE `online_exam`.`id` = '$exam_id' AND `online_exam`.`teacher` = '$user';");
        if($qr){
            $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully updated exam.
                </div>";            
        }
        else{
            $msg = "<div class='alertDanger'>
                    <i class='fa fa-check'></i> Something went wrong.
                </div>";               
        }    
    }

    $exam_query = mysqli_query($con, "SELECT * FROM `online_exam` WHERE `id` = '$exam_id'");
    if(mysqli_num_rows($exam_query)>0){
        $row = mysqli_fetch_array($exam_query);
        $title = $row['title'];
        $class = $row['class'];
        $section = $row['section'];
        $className = $class.' - '.$section;
        $subject = $row['subject'];
        $teacher = $row['teacher'];
        $noq = $row['no_of_question'];
        $mark_per_mcq = $row['mark_per_mcq'];
        $mark_per_sq = $row['mark_per_sq'];
        $start_date = $row['date'];
        $start_time = $row['start'];
        $start_timeObj =new DateTime($start_time);
        $end_time = $row['end'];
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');    
        
        $fl = 0;
        if($current_date == $start_date){
            if($current_time > $start_time){
                if($current_time < $end_time){
                    $fl = 2;
                }
                else{
                    $fl = 1;
                }

            }
        }
        else if($current_date>$start_date){
            $fl = 1;
        }
        //$time_difference = new DateTime(date('Y-m-d H:i:s', strtotime($time_difference)));
        
    }


?>

<!-- SECTION STARTS HERE -->
    <!--Please, place all your div/box/anything inside the above SECTION-->
    <div class="section" style="">
        <div class="row">
            <div class="col-md-10">
                
                <div class="box80">
                   <a href="setQ.php?id=<?php echo $exam_id; ?>"><button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Go Back</button></a>
                   <br>
                   <br> 
                   <h5 class="boxHeader">Update Exam:  </h5>
                    

                    <?php
                        if(isset($msg))echo $msg;
                    ?>

                    <form method="post" id="setExamForm">
                        <div class="row">
                            <div class="col-6">
                                <label style="color:blue;" for="titleid">Title:</label>
                                <input type="text" name="title" required id="titleid" class="form-control" placeholder="Enter title of the Exam" value="<?php echo $title; ?>">
                            </div>
                            <div class="col-6">
                                <label style="color:blue;" for="subjectid">Subject:</label>
                                <input type="text" name="subject" required id="subjectid" class="form-control" placeholder="Enter name of subject" value="<?php echo $subject; ?>">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label style="color:blue;" for="class">Class:</label>
                                <select required id="class" name="class" class="form-control">
                                    <option value="" disabled>Select Class</option>
                                    <option value="Level 1 Term 1" <?php if($class == "Level 1 Term 1"){echo "selected";}?> >Level 1 Term 1</option>
                                    <option value="Level 1 Term 2"<?php if($class == "Level 1 Term 2"){echo "selected";}?> >Level 1 Term 2</option>
                                    <option value="Level 2 Term 1"<?php if($class == "Level 2 Term 1"){echo "selected";}?> >Level 2 Term 1</option>
                                    <option value="Level 2 Term 2"<?php if($class == "Level 2 Term 2"){echo "selected";}?> >Level 2 Term 2</option>
                                    <option value="Level 3 Term 1"<?php if($class == "Level 3 Term 1"){echo "selected";}?> >Level 3 Term 1</option>
                                    <option value="Level 3 Term 2"<?php if($class == "Level 3 Term 2"){echo "selected";}?> >Level 3 Term 2</option>
                                    <option value="Level 4 Term 1"<?php if($class == "Level 4 Term 1"){echo "selected";}?> >Level 4 Term 1</option>
                                    <option value="Level 4 Term 2"<?php if($class == "Level 4 Term 2"){echo "selected";}?> >Level 4 Term 2</option>
                                </select>
                            </div>  
                            <div class="col-6">
                                <label style="color:blue;" for="section">Section:</label>
                                <select required id="section" name="section" class="form-control">
                                    <option value="" disabled>Select Section</option>
                                    <option value="A" <?php if($section == "A"){echo "selected";}?> >A</option>
                                    <option value="B" <?php if($section == "B"){echo "selected";}?> >B</option>
                                </select>        
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label style="color:blue;" for="startid">Start Time:</label>
                                <input type="time" name="start" required id="startid" class="form-control" value="<?php echo $start_time;?>">
                            </div>
                            <div class="col-4">
                                <label style="color:blue;" for="startid">End Time:</label>
                                <input type="time" name="end" required id="endid" class="form-control" value="<?php echo $end_time;?>">
                            </div>
                            <div class="col-4">
                                <label style="color:blue;" for="endid">Date:</label>
                                <input type="date" name="date" required id="dateid" class="form-control" value="<?php echo $start_date;?>">           
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label style="color:blue;" for="noqid">Number of Question:</label>
                                <input type="number" name="noq" required id="noqid" class="form-control" placeholder="Enter number of question" value="<?php echo $noq;?>">
                            </div>
                            <div class="col-4">
                                <label style="color:blue;" for="noqid">Mark Per MCQ:</label>
                                <input type="number" name="markMcq" required id="markMcqId" class="form-control" placeholder="Enter Mark Per MCQ" value="<?php echo $mark_per_mcq;?>">
                            </div>
                            <div class="col-4">
                                <label style="color:blue;" for="startid">Mark Per Short question:</label>
                                <input type="number" name="markSq" required id="markSqId" class="form-control" placeholder="Enter mark per short question" value="<?php echo $mark_per_sq;?>">
                            </div>
                        </div>
                        
                        <br>
                        <button type="submit" name="submit" id="createBtn" class="btn btn-warning">Update</button>
                    </form>
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