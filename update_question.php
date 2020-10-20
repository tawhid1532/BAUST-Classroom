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
    if(isset($_GET['question_id'])){
        $question_id = $_GET['question_id'];
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
   
            
        $qa = mysqli_query($con, "UPDATE `exam_questions` SET `question` = '$question', `answer` = '$ans', `option1` = '$op1', `option2` = '$op2', `option3` = '$op3', `option4` = '$op4' WHERE `exam_questions`.`id` = '$question_id'");
        if($qa){
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
    if(isset($_POST['addQ2'])){
        
        $question = $_POST['question2'];
    
        
        $qa = mysqli_query($con, "UPDATE `exam_questions` SET `question` = '$question' WHERE `exam_questions`.`id` = '$question_id'");
        if($qa){
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

    $Questions_query = mysqli_query($con, "SELECT * FROM `exam_questions` WHERE `exam_id` = '$exam_id' AND id = '$question_id'");
    if(mysqli_num_rows($Questions_query)>0){
        $i=1;
        $row = mysqli_fetch_array($Questions_query);
        $question_type = $row['question_type'];
        $ques = $row['question'];
        if($question_type == "mcq"){
            $option1 = $row['option1'];
            $option2 = $row['option2'];
            $option3 = $row['option3'];
            $option4 = $row['option4'];
            $answer = $row['answer'];
        }
    }


?>

<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
	<div class="section" style="">
        <div class="box80">
            <a href="setQ.php?id=<?php echo $exam_id; ?>"><button id="showButton" type="button"  class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Go Back</button></a>
            <br>
            <br>
            <?php if($question_type == "mcq"){?>
                    <form method="post">
                        <label for="questionid">Update question:</label>
                        <input type="text" name="question" required id="questionid" placeholder="Enter the Question" class="form-control" value="<?php echo $ques; ?>">
                        <br>
                        <div class="form-inline">
                            
                            <input type="text" name="op1" placeholder="option A" class="form-control" value="<?php echo $option1; ?>">&nbsp;&nbsp;
                            <input type="text" name="op2" placeholder="option B" class="form-control" value="<?php echo $option2; ?>">&nbsp;&nbsp;
                            <input type="text" name="op3" placeholder="option C" class="form-control" value="<?php echo $option3; ?>">&nbsp;&nbsp;
                            <input type="text" name="op4" placeholder="option D" class="form-control" value="<?php echo $option4; ?>">&nbsp;
                            <select required name="ans" class="form-control">
                                <option value="" disabled>Correct Answer</option>
                                <option value="A" <?php if($answer == "A"){echo "selected";}?>>A</option>
                                <option value="B" <?php if($answer == "B"){echo "selected";}?>>B</option>
                                <option value="C" <?php if($answer == "C"){echo "selected";}?>>C</option>
                                <option value="D" <?php if($answer == "D"){echo "selected";}?>>D</option>
                            </select> 
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="addQ">Update</button>
                    </form>
            <?php }else if($question_type == "sq"){ ?>
                    <form method="post">
                        <label for="questionid2">Add question:</label>
                        
                        <input type="text" name="question2" required id="questionid2" placeholder="Enter the Question" class="form-control" value="<?php echo $ques; ?>">

                        <br>
                        <button type="submit" class="btn btn-primary" name="addQ2">Update</button>
                    </form>
                
            <?php } ?>
      
        </div>
    </div>
<?php
	require_once('inc/footer.php');
?>