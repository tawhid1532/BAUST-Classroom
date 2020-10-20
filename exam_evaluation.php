<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
     else if($userType=='student'){
        header('Location: index.php');   
    }
    if(isset($_GET['exam_id'])){
        $exam_id = $_GET['exam_id'];
    }  
    if(isset($_GET['student_id'])){
        $student_id = $_GET['student_id'];
    }  
    $student_info = mysqli_query($con, "SELECT * FROM student_register WHERE id = '$student_id'");
    $row = mysqli_fetch_array($student_info);
    $student_name = $row['name'];
    $student_email = $row['email'];
    $student_roll = $row['roll'];

    $msg = "";
    $msg2 = "";

    if(isset($_POST['MarkSubmit'])){
        $mark = $_POST['giveMark'];
        $q_id = $_POST['question_id'];
        $check = mysqli_query($con, "SELECT * FROM `short_question_mark` WHERE student = '$student_email' AND question_id = '$q_id'");
        if(mysqli_num_rows($check)>0){
            $msg = "<div class='alertDanger'>
                            <i class='fa fa-check'></i> Already Given Mark!
                    </div>";
        }
        else{
            $qxx = mysqli_query($con, "INSERT INTO `short_question_mark` (`id`, `student`, `question_id`, `mark`) VALUES (NULL, '$student_email', '$q_id', '$mark');");
            if($qxx){
                $msg = "<div class='alertSuccess'>
                                <i class='fa fa-check'></i> Successfully Given Mark!
                        </div>";
            }
        }
    }
    if(isset($_POST['publish'])){
        $TotalMark = 0;
        $pq = mysqli_query($con, "SELECT * FROM `answer_submit` WHERE exam_id = '$exam_id' AND student = '$student_email';"); 
        if(mysqli_num_rows($pq)>0){
            while($row = mysqli_fetch_array($pq)){

                $ques_id = $row['question_id'];

                $checkType = mysqli_query($con, "SELECT * FROM `exam_questions` WHERE id='$ques_id'");
                $rowxx = mysqli_fetch_array($checkType);
                $question_type = $rowxx['question_type'];
                if($question_type == 'mcq'){
                    $px = mysqli_query($con, "SELECT * FROM `answer_submit` WHERE exam_id = '$exam_id' AND student = '$student_email' AND correct = '1' AND question_id = '$ques_id'");
                    if(mysqli_num_rows($px)==1){

                        $getMCQMark = mysqli_query($con, "SELECT * FROM `online_exam` WHERE id = '$exam_id'");
                        $rowyy = mysqli_fetch_array($getMCQMark);
                        $mark_per_mcq = $rowyy['mark_per_mcq'];

                        $TotalMark += $mark_per_mcq;
                    }
                }
                else{
                    $getSQMark = mysqli_query($con, "SELECT * FROM `short_question_mark` WHERE student = '$student_email' AND question_id = '$ques_id'");
                    if(mysqli_num_rows($getSQMark)==1){
                        $rowzz = mysqli_fetch_array($getSQMark);
                        $mark = $rowzz['mark'];

                        $TotalMark += $mark;
                    }
                }
                
            }

            $checkResult = mysqli_query($con, "SELECT * FROM online_exam_result WHERE exam_id = '$exam_id' AND student = '$student_email'");
            if(mysqli_num_rows($checkResult)>0){
                $msg2 = "<div class='alertDanger'>
                        <i class='fa fa-check'></i> Already Published!
                </div>";
            }
            else{
                $insert = mysqli_query($con, "INSERT INTO `online_exam_result`(`id`, `exam_id`, `student`, `mark`)  VALUES (NULL,'$exam_id','$student_email','$TotalMark')");

                if($insert){
                    $msg2 = "<div class='alertSuccess'>
                        <i class='fa fa-check'></i> Successfully Published!
                </div>";
                }
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
        <div class="row">
            <div class="col-md-7">
                
                <div class="box90">
                   <a href="setQ.php?id=<?php echo $exam_id; ?>"><button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Go Back</button></a>
                   <br>
                   <br> 
                   <h5 class="boxHeader">Answer Sheet of <span style="color:black;"><?php echo $student_name.' Roll: '.$student_roll ?>:  </span></h5>
                    <?php
                        $AnswerSheet = mysqli_query($con, "SELECT * FROM `answer_submit` WHERE exam_id = '$exam_id' AND student = '$student_email';");
                        if(mysqli_num_rows($AnswerSheet)>0){
                            while($row = mysqli_fetch_array($AnswerSheet)){
                                $question_id = $row['question_id'];
                                $he_answered = $row['answer'];
                                
                                $questionDetails = mysqli_query($con, "SELECT * FROM `exam_questions` WHERE id = '$question_id'");
                                $row2 = mysqli_fetch_array($questionDetails);
                                $question_statement = $row2['question'];
                                $correct_answer = $row2['answer'];
                                $question_type = $row2['question_type'];
                                
                                if($question_type == "mcq"){
                    ?>
                                <?php if($he_answered == $correct_answer){ echo  '<h5 style="color:green; float:right"><i class="fa fa-check" aria-hidden="true" ></i></h5>';}else{
                                    echo '<h5 style="color:green; float:right"><i class="fa fa-times" aria-hidden="true"></i></h5>';
                                }?>
                                <h6 style="color:#1b6dc1"> <?php echo $question_statement; ?></h6>
                                <h6>Answered by student: <?php echo $he_answered; ?> </h6>
                                <h6>Correct answer: <?php echo $correct_answer; ?> </h6>

                                
                    <?php
                                }
                                else{
                                    $check = mysqli_query($con, "SELECT * FROM `short_question_mark` WHERE student = '$student_email' AND question_id = '$question_id'");
                    ?>
                                
                                <a href="exam_evaluation.php?exam_id=<?php echo $exam_id; ?>&student_id=<?php echo $student_id ?>&question_id=<?php echo $question_id ?>"><button type="button" class="btn btn-primary btn-sm float-right" <?php if(mysqli_num_rows($check)>0)echo "disabled"; ?>>Evaluate<?php if(mysqli_num_rows($check)>0)echo 'd';?></button></a>
                                <h6 style="color:#1b6dc1"><?php echo $question_statement; ?></h6>
                                <h6>Answered by student: <?php echo $he_answered; ?> </h6>
                                
                    <?php
                                }
                            }
                        }
                        else{
                        ?>
                            <h5 style="color:#7f7f7f;"><i>Nothing to show</i></h5>
                        <?php
                        }

                    ?>
                    
                </div>
            </div>
            <div class="col-md-5">
                <div class="box90">
                   
                   <h5 class="boxHeader">Evaluate:  </h5>
                    

                    <?php
                        if(isset($msg))echo $msg;
                    ?>
                    <?php
                        if(isset($_GET['question_id'])){
                            $qid = $_GET['question_id'];
                            $questionDetails = mysqli_query($con, "SELECT * FROM `exam_questions` WHERE id = '$question_id'");
                            $row3 = mysqli_fetch_array($questionDetails);
                            $question_statement = $row3['question'];

                            $AnswerSheet = mysqli_query($con, "SELECT * FROM `answer_submit` WHERE exam_id = '$exam_id' AND student = '$student_email' AND question_id = '$qid';");
                            $row4 = mysqli_fetch_array($AnswerSheet);
                            $answer = $row4['answer'];

                            $markQuery = mysqli_query($con, "SELECT * FROM `online_exam` WHERE id = '$exam_id'");
                            $row5 = mysqli_fetch_array($markQuery);
                            $mark = $row5['mark_per_sq'];
                    ?>      

                            <h6 style="float: right"><?php echo $mark; ?></h6>
                            <h6 style="color:#1b6dc1"><?php echo $question_statement; ?></h6>
                            <h6>Ans: <?php echo $answer; ?></h6>
                            <form method="post" id="setExamForm">
                                <input type="hidden" name="question_id" value="<?php echo $qid; ?>">
                                <input type="number" required name="giveMark" placeholder="Enter Mark " class="form-control">
                                <br>
                                <button type="submit" name="MarkSubmit" class="btn btn-warning">Submit</button>
                            </form>
                    <?php
                        }

                    ?>
                    
                </div>
            </div>
        </div>
        <br>
        <div style="margin-left: 3%;">
            
            <form method="post">
                <button type="submit" name="publish" class="btn btn-danger">Publish</button>
            </form>
        </div>
    </div>
    
    <!--Please, place all your div/box/anything inside the above SECTION-->

<?php
    require_once('inc/footer.php');
?>