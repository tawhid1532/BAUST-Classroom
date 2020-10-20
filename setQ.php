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
        $start_date = $row['date'];
        $start_time = $row['start'];
        $start_timeObj =new DateTime($start_time);
        $end_time = $row['end'];
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');
        $isArchived = $row['archived'];
        $mark_per_mcq = $row['mark_per_mcq'];
        $mark_per_sq = $row['mark_per_sq'];

        
        $noOfMCQ_query = mysqli_query($con, "SELECT * FROM `exam_questions` WHERE exam_id = '$exam_id' AND question_type = 'mcq'");
        $noOfMCQ = mysqli_num_rows($noOfMCQ_query);

        $noOfsQ_query = mysqli_query($con, "SELECT * FROM `exam_questions` WHERE exam_id = '$exam_id' AND question_type = 'sq'");
        $noOfsQ = mysqli_num_rows($noOfsQ_query);


        $Total_mark = $noOfMCQ*$mark_per_mcq + $noOfsQ*$mark_per_sq; 

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

    $msg="";
    if(isset($_POST['addQ'])){
        

        $Q_query = mysqli_query($con, "SELECT * FROM `exam_questions` WHERE `exam_id` = '$exam_id'");
        $count = mysqli_num_rows($Q_query);

        $question_type = "mcq";

        $question = $_POST['question'];
        
        $op1 = $_POST['op1'];
        $op2 = $_POST['op2'];
        $op3 = $_POST['op3'];
        $op4 = $_POST['op4'];
        $ans = $_POST['ans'];
   
        
        $duration = ($count+1)*30;
        $end_time = $start_timeObj->modify('+'.$duration.' seconds');
        $end_time = $end_time->format("H:i:s");
        $q_no = $count + 1; 

        if($q_no <= $noq){
            $qa = mysqli_query($con, "INSERT INTO `exam_questions`(`id`, `exam_id`, `question_type`, `q_no`, `question`, `answer`, `option1`, `option2`, `option3`, `option4`, `end`) VALUES (NULL, '$exam_id','$question_type','$q_no', '$question', '$ans', '$op1', '$op2', '$op3', '$op4', '$end_time');");
            if($qa){
                $msg = "<div class='alertSuccess'>
                            <i class='fa fa-check'></i> Successfully Added!
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
                            <i class='fa fa-times'></i> You have already created ".$noq." questions
                    </div>";
        }
    }
    if(isset($_POST['addQ2'])){
        

        $Q_query = mysqli_query($con, "SELECT * FROM `exam_questions` WHERE `exam_id` = '$exam_id'");
        $count = mysqli_num_rows($Q_query);

        
        $question = $_POST['question2'];
        $question_type = "sq";
    
        $op1 = "";
        $op2 = "";
        $op3 = "";
        $op4 = "";
        $ans = "";
    
        $duration = ($count+1)*30;
        $end_time = $start_timeObj->modify('+'.$duration.' seconds');
        $end_time = $end_time->format("H:i:s");
        $q_no = $count + 1; 

        if($q_no <= $noq){
            $qa = mysqli_query($con, "INSERT INTO `exam_questions`(`id`, `exam_id`, `question_type`, `q_no`, `question`, `answer`, `option1`, `option2`, `option3`, `option4`, `end`) VALUES (NULL, '$exam_id','$question_type','$q_no', '$question', '$ans', '$op1', '$op2', '$op3', '$op4', '$end_time');");
            if($qa){
                $msg = "<div class='alertSuccess'>
                            <i class='fa fa-check'></i> Successfully Added!
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
                            <i class='fa fa-times'></i> You have already created ".$noq." questions
                    </div>";
        }
    }

?>

<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
	<div class="section" style="">
        <div class="box80">

            <a href="delete.php?delete_type=online_exam&exam_id=<?php echo $exam_id; ?>">
                <button 
                    id="showButton" 
                    type="button" 
                    style="float:right;" 
                    class="btn btn-outline-danger" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Delete">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </a>

            <a href="archive.php?archive_type=online_exam&exam_id=<?php echo $exam_id; ?>">
                <button 
                    id="showButton" 
                    type="button" 
                    style="float:right;" 
                    class="btn btn-outline-dark" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Archive" <?php if($isArchived == 1)echo "disabled"?>>
                    <i class="fa fa-archive" aria-hidden="true"></i>
                </button>
            </a>
            
            <a href="update_exam.php?id=<?php echo $exam_id; ?>">
                <button 
                    id="showButton" 
                    type="button" 
                    style="float:right;" 
                    class="btn btn-outline-info" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Edit">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
            </a>
            <h5 class="boxHeader">Title: <?php echo $title; ?></h5>
            <h6><b>Subject:</b> <?php echo $subject; ?></h6>
            <h6><b>Class:</b> <?php echo $className; ?></h6>
            <h6><b>Number of question:</b> <?php echo $noq; ?></h6>
            <h6><b>Mark Per MCQ:</b> <?php echo $mark_per_mcq; ?></h6>
            <h6><b>Mark Per Short Question:</b> <?php echo $mark_per_sq; ?></h6>
            <h6><b>Total Mark:</b> <?php echo $Total_mark; ?></h6>
            <h6><b>Start Time:</b> <?php echo date('d M', strtotime($start_date)); ?> - <?php echo date('h:i A', strtotime($start_time)); ?></h6>
            <h6><b>Question:</b></h6>
            <?php
                $Questions_query = mysqli_query($con, "SELECT * FROM `exam_questions` WHERE `exam_id` = '$exam_id'");
                if(mysqli_num_rows($Questions_query)>0){
                    $i=1;
                    while($row = mysqli_fetch_array($Questions_query)){
                        $question_id = $row['id'];

                        $question_type = $row['question_type'];
                        $ques = $row['question'];
                        $option1 = $row['option1'];
                        $option2 = $row['option2'];
                        $option3 = $row['option3'];
                        $option4 = $row['option4'];
                        $answer = $row['answer'];
            ?>
            <br>

            <a href="update_question.php?id=<?php echo $exam_id; ?>&question_id=<?php echo $question_id; ?>"><button type="button" style="float:right;" class="btn btn-outline-info"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
            <h6><?php echo $i; ?>. <?php echo $ques; ?></h6>
            <div class="form-inline">
            <?php if($question_type == "mcq"){ ?>
                <?php echo 'A) '.$option1; ?>&nbsp;
                <?php echo 'B) '.$option2; ?>&nbsp;
                <?php echo 'C) '.$option3; ?>&nbsp;
                <?php echo 'D) '.$option4; ?>&nbsp;
            <?php } ?>
            </div>
            <?php if($question_type == "mcq"){ ?>
            <h6>Answer: <?php echo $answer; ?></h6>
            <?php } ?>
            <?php
                        $i++;
                    }
                }
                if(isset($msg))echo $msg;
                if($fl==0){
            ?>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="teacher-tab" data-toggle="tab" href="#teacher" role="tab" aria-controls="teacher" aria-selected="true">Multiple Choice Question:</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="student-tab" data-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="false">Short Question:</a>
                </li>
            </ul>
            <br>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="teacher" role="tabpanel" aria-labelledby="teacher-tab">
                    <form method="post">
                        <label for="questionid">Add question:</label>
                        <input type="text" name="question" required id="questionid" placeholder="Enter the Question" class="form-control">
                        <br>
                        <div class="form-inline">
                            
                            <input type="text" name="op1" placeholder="option A" class="form-control">&nbsp;&nbsp;
                            <input type="text" name="op2" placeholder="option B" class="form-control">&nbsp;&nbsp;
                            <input type="text" name="op3" placeholder="option C" class="form-control">&nbsp;&nbsp;
                            <input type="text" name="op4" placeholder="option D" class="form-control">&nbsp;
                            <select required name="ans" class="form-control">
                                <option value="" disabled selected>Correct Answer</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select> 
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="addQ">Add</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                    <form method="post">
                        <label for="questionid2">Add question:</label>
                        
                        <input type="text" name="question2" required id="questionid2" placeholder="Enter the Question" class="form-control">

                        <br>
                        <button type="submit" class="btn btn-primary" name="addQ2">Add</button>
                    </form>
                </div>
            </div>
            
        <?php }
             
        ?>
           
        </div>
        <?php
        if($fl==1){
            $qr = mysqli_query($con, "SELECT DISTINCT student FROM `answer_submit` WHERE exam_id = '$exam_id';");
            if(mysqli_num_rows($qr)>0){
                
            ?>
            <div class="box80">
                <h5 class="boxHeader">Participants:</h5>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Roll</th>
                      <th scope="col">Achieved Mark</th>
                      <th scope="col">Evaluation</th>
                    </tr>
                  </thead>
                  <tbody>
            <?php
                while($row = mysqli_fetch_array($qr)){
                    $student = $row['student'];
                    //$mark = $row['mark'];
                    $student_info = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$student'");
                    $row = mysqli_fetch_array($student_info);
                    $student_name = $row['name'];
                    $student_roll = $row['roll'];
                    $student_id = $row['id'];

                    $qxxx = mysqli_query($con, "SELECT * FROM online_exam_result WHERE exam_id = '$exam_id' AND student = '$student'");
            ?>
                    <tr>
                      <th scope="row">1</th>
                      <td><?php echo $student_name; ?></td>
                      <td><?php echo $student_roll; ?></td>
                      <td>
                        <?php 
                            if(mysqli_num_rows($qxxx)>0){
                                $mark = mysqli_fetch_array($qxxx);
                                echo $mark['mark'];
                            }
                            else{
                                echo "Not Yet Evaluated";
                            } 
                        ?>
                      </td>
                      <td><a href="exam_evaluation.php?exam_id=<?php echo $exam_id; ?>&student_id=<?php echo $student_id ?>"><button type="button" class="btn btn-dark" <?php if(mysqli_num_rows($qxxx)>0)echo "disabled"; ?>>Evaluate<?php if(mysqli_num_rows($qxxx)>0)echo "d"; ?></button></a></td>
                    </tr>
            <?php
                }
            ?>
                  </tbody>
                </table>
            </div>
            <?php
            }
        }
        ?>
    </div>
<?php
	require_once('inc/footer.php');
?>