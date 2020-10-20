<?php
	require_once('db.php');
	$exam_id = $_POST['exam_id'];
	$question_no = $_POST['question_no'];
	$student = $_POST['student'];
	$answer = $_POST['answer'];
	
	$check_answer = mysqli_query($con, "SELECT * FROM `exam_questions` WHERE exam_id = '$exam_id' AND q_no = '$question_no'");
	if(mysqli_num_rows($check_answer)>0){
		$row = mysqli_fetch_array($check_answer);
		$question_id = $row['id'];
		$dbanswer = $row['answer'];
		if($dbanswer==$answer){
			$correct = 1;
		}
		else{
			$correct = 0;
		}
	}

	if(isset($_POST['exam_id'])){
        
        $checkDoubleSubmit = mysqli_num_rows(mysqli_query($con, "SELECT * FROM answer_submit WHERE exam_id = '$exam_id' AND question_id = '$question_id' AND student = '$student' "));
        if($checkDoubleSubmit>0){
        	echo "Already Submitted";
        }
        else{
	        $ins_query="INSERT INTO `answer_submit` (`id`, `exam_id`, `question_id`, `student`, `answer`, `correct`) VALUES (NULL, '$exam_id', '$question_id', '$student', '$answer', '$correct');";
	        $run = mysqli_query($con,$ins_query);
        }
    }
?>