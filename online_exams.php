<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
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
        $qr = mysqli_query($con, "INSERT INTO `online_exam`(`id`, `title`, `subject`, `teacher`, `class`, `section`, `start`, `end`, `date`, `no_of_question`, `mark_per_mcq`, `mark_per_sq`, `archived`) VALUES (NULL, '$title', '$subject', '$user', '$class', '$section', '$start_time', '$end_time', '$date', '$noq', '$markMcq', '$markSq', 0)");
        if($qr){
            $msg = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully set exam.
                </div>";            
        }    
    }



?>

<!-- SECTION STARTS HERE -->
    <!--Please, place all your div/box/anything inside the above SECTION-->
    <div class="section" style="">
        <?php 
            if(isset($_GET['showArchive'])){
        
                if($userType == 'teacher'){
            ?>
                

                <div class="box90" style="margin-top:20px;">
                     <a href="online_exams.php"><button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Go Back</button></a>
                     <br>
                     <br>
                    <h5 class="boxHeader">Archived Exams:</h5>
                    <?php
                    $qx = mysqli_query($con, "SELECT * FROM online_exam WHERE teacher = '$user' AND archived = 1 ORDER BY id DESC");
                    if(mysqli_num_rows($qx)>0){
                        while($row = mysqli_fetch_array($qx)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $class = $row['class'];
                            $section = $row['section'];
                            $className = $class.' - '.$section;
                            $subject = $row['subject'];
                            $teacher = $row['teacher'];
                            
                            $noq = $row['no_of_question'];
                            $start_date = $row['date'];
                            $start_time = $row['start'];
                            $end_time = $row['end'];
                            $current_date = date('Y-m-d');
                            $current_time = date('H:i:s');
                            $star_date = new DateTime($current_date.' '.$current_time);
                            $since_start = $star_date->diff(new DateTime($start_date.' '.$start_time));
                            

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
                            $ct = 0;
                            if($fl==1){
                                $ct++;
                ?>
                    <a style="text-decoration: none;" href="setQ.php?id=<?php echo $id; ?>"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                    <p style="font-weight: bold; margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                    <h1><?php 
                        
                        echo "Exam Finished at ".date('h:i A', strtotime($end_time)).' '.date('d M', strtotime($start_date));
                        
                    ?></h1>
                    <h1>For <span style="color:teal;"><?php echo $className; ?></span></h1>
                    <h1>Subject: <span style="color:teal;"><?php echo $subject; ?></span></h1>
                    </div></a>
                    
                <?php
                            }
                            
                        }
                        if($ct==0){ ?>
                            <h6 style="color:#7f7f7f; font-style: italic;">There is no recently finished exam to show for your class</h6>
                
                        <?php }
                    }
                    else{
                ?>
                    <h6 style="color:#7f7f7f; font-style: italic;">There is no recently finished exam to show for your class</h6>
                <?php
                    }
                ?>
                </div>
                <?php
                }
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
                    <h5 class="boxHeader">Set New Exam:  </h5>
                 
                    <?php
                        if(isset($msg))echo $msg;
                    ?>

                    <form method="post" id="setExamForm" style="display:none">
                        <div class="row">
                            <div class="col-6">
                                <label style="color:blue;" for="titleid">Title:</label>
                                <input type="text" name="title" required id="titleid" class="form-control" placeholder="Enter title of the Exam">
                            </div>
                            <div class="col-6">
                                <label style="color:blue;" for="subjectid">Subject:</label>
                                <input type="text" name="subject" required id="subjectid" class="form-control" placeholder="Enter name of subject">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
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
                            </div>  
                            <div class="col-6">
                                <label style="color:blue;" for="section">Section:</label>
                                <select required id="section" name="section" class="form-control">
                                    <option value="" disabled selected>Select Section</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                </select>        
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label style="color:blue;" for="startid">Start Time:</label>
                                <input type="time" name="start" required id="startid" class="form-control">
                            </div>
                            <div class="col-4">
                                <label style="color:blue;" for="startid">End Time:</label>
                                <input type="time" name="end" required id="endid" class="form-control">
                            </div>
                            <div class="col-4">
                                <label style="color:blue;" for="endid">Date:</label>
                                <input type="date" name="date" required id="dateid" class="form-control">           
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label style="color:blue;" for="noqid">Number of Question:</label>
                                <input type="number" name="noq" required id="noqid" class="form-control" placeholder="Enter number of question">
                            </div>
                            <div class="col-4">
                                <label style="color:blue;" for="noqid">Mark Per MCQ:</label>
                                <input type="number" name="markMcq" required id="markMcqId" class="form-control" placeholder="Enter Mark Per MCQ">
                            </div>
                            <div class="col-4">
                                <label style="color:blue;" for="startid">Mark Per Short question:</label>
                                <input type="number" name="markSq" required id="markSqId" class="form-control" placeholder="Enter mark per short question">
                            </div>
                        </div>
                        
                        <br>
                        <button type="submit" name="submit" id="createBtn" class="btn btn-warning">Create</button>
                    </form>
                </div>
                <div class="box80" style="margin-top:20px;">
                    <h5 class="boxHeader">Upcoming Exam: (Set Questions / Update)</h5>
                <?php
                    $qx = mysqli_query($con, "SELECT * FROM online_exam WHERE teacher = '$user' AND archived = 0 ORDER BY start DESC");
                    if(mysqli_num_rows($qx)>0){
                        while($row = mysqli_fetch_array($qx)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $class = $row['class'];
                            $section = $row['section'];
                            $className = $class.' - '.$section;
                            $subject = $row['subject'];
                            $teacher = $row['teacher'];
                            
                            $noq = $row['no_of_question'];
                            $start_date = $row['date'];
                            $start_time = $row['start'];
                            $end_time = $row['end'];
                            $current_date = date('Y-m-d');
                            $current_time = date('H:i:s');
                            $star_date = new DateTime($current_date.' '.$current_time);
                            $since_start = $star_date->diff(new DateTime($start_date.' '.$start_time));
                            

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
                            if($fl!=1){
                            
                ?>
                    <a style="text-decoration: none;" href="setQ.php?id=<?php echo $id; ?>"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                    <p style="font-weight: bold; margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                    <h1><?php 
                        if($fl==0){
                            echo "Exam Starts in ";
                            if($since_start->y>0)echo $since_start->y.' years';
                            if($since_start->m>0)echo $since_start->m.' months ';
                            if($since_start->d>0)echo $since_start->d.' days ';
                            if($since_start->h>0)echo $since_start->h.' hours ';
                            if($since_start->i>0)echo $since_start->i.' minutes ';
                            if($since_start->s>0)echo $since_start->s.' seconds<br>';
                        }
                        else if($fl==2){
                            echo "Exam is Ongoing. Finishes at ".date('h:i:s A', strtotime($end_time));
                        }
                    ?></h1>
                    <h1>For <span style="color:teal;"><?php echo $className; ?></span></h1>
                    <h1>Subject: <span style="color:teal;"><?php echo $subject; ?></span></h1>
                    </div></a>
                <?php
                            }
                        }

                    }
                    else{
                ?>
                    <h6 style="color:#7f7f7f; font-style: italic;">There is no scheduled exam available for your class</h6>
                <?php
                        }

                ?>
                </div>

                <div class="box80" style="margin-top:20px;">
                    <h5 class="boxHeader">Finished Exams:</h5>
                <?php
                    $qx = mysqli_query($con, "SELECT * FROM online_exam WHERE teacher = '$user' AND archived = 0 ORDER BY id DESC");
                    if(mysqli_num_rows($qx)>0){
                        while($row = mysqli_fetch_array($qx)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $class = $row['class'];
                            $section = $row['section'];
                            $className = $class.' - '.$section;
                            $subject = $row['subject'];
                            $teacher = $row['teacher'];
                            
                            $noq = $row['no_of_question'];
                            $start_date = $row['date'];
                            $start_time = $row['start'];
                            $end_time = $row['end'];
                            $current_date = date('Y-m-d');
                            $current_time = date('H:i:s');
                            $star_date = new DateTime($current_date.' '.$current_time);
                            $since_start = $star_date->diff(new DateTime($start_date.' '.$start_time));
                            

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
                            $ct = 0;
                            if($fl==1){
                                $ct++;
                ?>
                    <a style="text-decoration: none;" href="setQ.php?id=<?php echo $id; ?>"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                    <p style="font-weight: bold; margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                    <h1><?php 
                        
                        echo "Exam Finished at ".date('h:i A', strtotime($end_time)).' '.date('d M', strtotime($start_date));
                        
                    ?></h1>
                    <h1>For <span style="color:teal;"><?php echo $className; ?></span></h1>
                    <h1>Subject: <span style="color:teal;"><?php echo $subject; ?></span></h1>
                    </div></a>
                    
                <?php
                            }
                            
                        }
                        if($ct==0){ ?>
                            <h6 style="color:#7f7f7f; font-style: italic;">There is no recently finished exam to show for your class</h6>
                
                        <?php }
                    }
                    else{
                ?>
                    <h6 style="color:#7f7f7f; font-style: italic;">There is no recently finished exam to show for your class</h6>
                <?php
                    }
                ?>
                </div>
                <?php
                }
                else if($userType=='student'){
                ?>
                <div class="box80" style="margin-top:20px;">
                    <h5 class="boxHeader">Upcoming Exams:</h5>
                <?php
                    $qx = mysqli_query($con, "SELECT * FROM online_exam WHERE class = '$studentClass' AND section = '$studentSection' AND archived = 0 ORDER BY id DESC");
                    if(mysqli_num_rows($qx)>0){
                        while($row = mysqli_fetch_array($qx)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $class = $row['class'];
                            $section = $row['section'];
                            $className = $class.' - '.$section;
                            $subject = $row['subject'];
                            $teacher = $row['teacher'];
                            
                            $noq = $row['no_of_question'];
                            $start_date = $row['date'];
                            $start_time = $row['start'];
                            $end_time = $row['end'];
                            $current_date = date('Y-m-d');
                            $current_time = date('H:i:s');
                            $star_date = new DateTime($current_date.' '.$current_time);
                            $since_start = $star_date->diff(new DateTime($start_date.' '.$start_time));
                            $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$teacher'");
                            $row = mysqli_fetch_array($teacher_info);
                            $teacher_name = $row['name'];

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
                            if($fl!=1){
                            
                ?>
                    <a style="text-decoration: none;" href="online_exam_details.php?id=<?php echo $id; ?>&question_no=1"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                    <p style="font-weight: bold; margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                    <h1><?php 
                        if($fl==0){
                            echo "Exam Starts in ";
                            if($since_start->y>0)echo $since_start->y.' years';
                            if($since_start->m>0)echo $since_start->m.' months ';
                            if($since_start->d>0)echo $since_start->d.' days ';
                            if($since_start->h>0)echo $since_start->h.' hours ';
                            if($since_start->i>0)echo $since_start->i.' minutes ';
                            if($since_start->s>0)echo $since_start->s.' seconds<br>';
                        }
                        else if($fl==2){
                            echo "Exam is Ongoing. Finishes at ".date('h:i:s A', strtotime($end_time));
                        }
                    ?></h1>
                    <h1>For <span style="color:teal;"><?php echo $className; ?></span></h1>
                    <h1>Subject: <span style="color:teal;"><?php echo $subject; ?></span></h1>
                    <h1>by <span style="color:maroon;"><?php echo $teacher_name; ?></span></h1>
                    </div></a>
                <?php
                            }
                        }
                    }
                    else{
                ?>
                    <h6 style="color:#7f7f7f; font-style: italic;">There is no scheduled exam available for your class</h6>
                <?php
                    }
                ?>
                </div>
                <div class="box80" style="margin-top:20px;">
                    <h5 class="boxHeader">Finished Exams:</h5>
                <?php
                    $qx = mysqli_query($con, "SELECT * FROM online_exam WHERE class = '$studentClass' AND section = '$studentSection' AND archived = 0 ORDER BY id DESC");
                    if(mysqli_num_rows($qx)>0){
                        while($row = mysqli_fetch_array($qx)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $class = $row['class'];
                            $section = $row['section'];
                            $className = $class.' - '.$section;
                            $subject = $row['subject'];
                            $teacher = $row['teacher'];
                            
                            $noq = $row['no_of_question'];
                            $start_date = $row['date'];
                            $start_time = $row['start'];
                            $end_time = $row['end'];
                            $current_date = date('Y-m-d');
                            $current_time = date('H:i:s');
                            $star_date = new DateTime($current_date.' '.$current_time);
                            $since_start = $star_date->diff(new DateTime($start_date.' '.$start_time));
                            $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$teacher'");
                            $row = mysqli_fetch_array($teacher_info);
                            $teacher_name = $row['name'];

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
                            $ct = 0;
                            if($fl==1){
                                $ct++;
                ?>
                    <a style="text-decoration: none;" href="online_exam_details.php?id=<?php echo $id; ?>"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                    <p style="font-weight: bold; margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                    <h1><?php 
                        
                        echo "Exam Finished at ".date('h:i A', strtotime($end_time)).' '.date('d M', strtotime($start_date));
                        
                    ?></h1>
                    <h1>For <span style="color:teal;"><?php echo $className; ?></span></h1>
                    <h1>Subject: <span style="color:teal;"><?php echo $subject; ?></span></h1>
                    <h1>by <span style="color:maroon;"><?php echo $teacher_name; ?></span></h1>
                    </div></a>
                <?php
                            }
                            
                        }
                        if($ct==0){ ?>
                            <h6 style="color:#7f7f7f; font-style: italic;">There is no recently finished exam to show for your class</h6>
                
                        <?php }
                    }
                    else{
                ?>
                    <h6 style="color:#7f7f7f; font-style: italic;">There is no recently finished exam to show for your class</h6>
                <?php
                    }
                ?>
                </div>
                <?php
                }

                if($userType=='teacher'){
                ?>
                <a href="online_exams.php?showArchive=1"><button class="btn btn-secondary" style="margin-left: 10%">Show Archive</button></a>
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
            document.getElementById("setExamForm").style.display = "block"
            document.getElementById("hideButton").style.display = "block"
            document.getElementById("showButton").style.display = "none"
        }

        function hideForm(){
            document.getElementById("setExamForm").style.display = "none"
            document.getElementById("hideButton").style.display = "none"
            document.getElementById("showButton").style.display = "block"
        }

    </script>
    <!--Please, place all your div/box/anything inside the above SECTION-->

<?php
    require_once('inc/footer.php');
?>