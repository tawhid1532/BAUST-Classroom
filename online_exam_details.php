<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    if(isset($_GET['id'])){
        $exam_id = $_GET['id'];
    }
    if(isset($_GET['question_no'])){
        $question_no = $_GET['question_no'];
    }
    $fl = 0;
    
    date_default_timezone_set("Asia/Dhaka");

    $qx = mysqli_query($con, "SELECT * FROM online_exam WHERE id = '$exam_id'");
    if(mysqli_num_rows($qx)>0){
        $row = mysqli_fetch_array($qx);
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
        $cur_date = new DateTime($current_date.' '.$current_time);
        $since_start = $cur_date->diff(new DateTime($start_date.' '.$start_time));
        $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$teacher'");
        $row = mysqli_fetch_array($teacher_info);
        $teacher_name = $row['name'];
        
        if($current_date == $start_date){
            if($current_time >= $start_time){
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

        $cur_date2 = new DateTime($current_date.' '.$current_time);
        $since_end = $cur_date2->diff(new DateTime($start_date.' '.$end_time));
    }
    if(isset($_GET['exam_finish'])){
        $fl = 1;
    }
    if(isset($question_no)){
        if($question_no<=$noq){
            $qx2 = mysqli_query($con, "SELECT * FROM exam_questions WHERE exam_id = '$exam_id' AND q_no = '$question_no'");
            if(mysqli_num_rows($qx2)>0){
                $row = mysqli_fetch_array($qx2);
                $question_type = $row['question_type'];
                $question_statement = $row['question'];
                $option1 = $row['option1'];
                $option2 = $row['option2'];
                $option3 = $row['option3'];
                $option4 = $row['option4'];
                $end_time_of_this_question = $row['end'];
                $cur_date3 = new DateTime($current_date.' '.$current_time);
                $since_end_this_question = $cur_date3->diff(new DateTime($start_date.' '.$end_time_of_this_question));
                
            }
        }
    }   

?>

<!-- SECTION STARTS HERE -->
    
    <input type="hidden" id="time_value_flag" value="<?php echo $fl; ?>">
    <input type="hidden" id="time_value_d" value="<?php echo $since_start->days; ?>">
    <input type="hidden" id="time_value_h" value="<?php echo $since_start->h; ?>">
    <input type="hidden" id="time_value_m" value="<?php echo $since_start->i; ?>">
    <input type="hidden" id="time_value_s" value="<?php echo $since_start->s; ?>">
    <input type="hidden" id="time_value_d2" value="<?php echo $since_end->days; ?>">
    <input type="hidden" id="time_value_h2" value="<?php echo $since_end->h; ?>">
    <input type="hidden" id="time_value_m2" value="<?php echo $since_end->i; ?>">
    <input type="hidden" id="time_value_s2" value="<?php echo $since_end->s; ?>">
    <input type="hidden" id="exam_id" value="<?php echo $exam_id; ?>">
    <input type="hidden" id="question_no" value="<?php if(isset($question_no)){echo $question_no;}else{echo "0";} ?>">
    <input type="hidden" id="noq" value="<?php echo $noq; ?>">
    <input type="hidden" id="question_type" value="<?php echo $question_type; ?>">
    <input type="hidden" id="since_end_this_question" value="<?php if(isset($question_no)){echo $since_end_this_question->s;}else{echo "none";} ?>">
    <input type="hidden" id="student" value="<?php echo $user; ?>">
    

    <div class="section" style="">
        <div class="box80">
            <h5 class="boxHeader"><?php echo $title; ?></h5>
            <h6 style="font-size: 14px; color:#7f7f7f;"><?php echo $className; ?>, by <?php echo $teacher_name; ?></h6>
            <h3 id="timer" style="color: blue;"></h3>
            <h4 id="timer2" style="color: blue;"></h4>
            <?php if($fl==1){?>
            <h4 id="timer3" style="color: blue;">Exam Finished!</h4>
        <?php } ?>
            <?php 
                if($fl==2){
            ?>
                <h5>Question <?php echo $question_no; ?> / <?php echo $noq; ?> </h5>
                <form method="post">
                    <label><?php echo $question_no; ?>. <?php echo $question_statement; ?></label><br>
                    <?php if($question_type == "mcq"){?>
                    <label class="radio-inline">
                      <input type="radio" id="op1" name="optradio"> <?php echo $option1; ?> &nbsp;
                    </label>
                    <label class="radio-inline">
                      <input type="radio" id="op2" name="optradio"> <?php echo $option2; ?> &nbsp;
                    </label>
                    <label class="radio-inline">
                      <input type="radio" id="op3" name="optradio"> <?php echo $option3; ?> &nbsp;
                    </label>
                    <label class="radio-inline">
                      <input type="radio" id="op4" name="optradio"> <?php echo $option4; ?> &nbsp;
                    </label>
                <?php } else{ ?>
                    <input type="text" name="shortQuestion" id="shortQuestion" class="form-control">
                <?php } ?>
                    <br>
                    <button class="btn btn-warning" type="button" id="nextBtn">Submit and Next</button>
                </form>
            <?php
                }
            ?>               
        </div>
        <br>
        <?php
            $totalMarkQuery = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM online_exam WHERE id = '$exam_id'"));
            $mark_per_mcq = $totalMarkQuery['mark_per_mcq'];
            $mark_per_sq = $totalMarkQuery['mark_per_sq'];
            $noOfMCQQuestion = mysqli_num_rows(mysqli_query($con, "SELECT * FROM exam_questions WHERE exam_id = '$exam_id' AND question_type = 'mcq'"));

            $noOfSQQuestion = mysqli_num_rows(mysqli_query($con, "SELECT * FROM exam_questions WHERE exam_id = '$exam_id' AND question_type = 'sq'"));
            
            $TotalMark = $noOfSQQuestion*$mark_per_sq + $noOfMCQQuestion*$mark_per_mcq;
            $qr = mysqli_query($con, "SELECT * FROM online_exam_result WHERE exam_id = '$exam_id' AND student = '$user'");
            if(mysqli_num_rows($qr)>0){
                
        ?>
        <div class="box80">
            <h5 class="boxHeader">Result:</h5>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Roll</th>
                  <th scope="col">Achieved Mark</th>
                  <th scope="col">Total Mark</th>
                </tr>
              </thead>
              <tbody>
        <?php
                $row = mysqli_fetch_array($qr);
                $student = $row['student'];
                $mark = $row['mark'];
                $student_info = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$student'");
                $row = mysqli_fetch_array($student_info);
                $student_name = $row['name'];
                $student_roll = $row['roll'];
        ?>
                <tr>
                  <th scope="row">1</th>
                  <td><?php echo $student_name; ?></td>
                  <td><?php echo $student_roll; ?></td>
                  <td><?php echo $mark; ?></td>
                  <td><?php echo $TotalMark; ?></td>
                </tr>
        <?php
            
        ?>
              </tbody>
            </table>
        </div>
        <?php
        }
        ?>
    </div>
<script type="text/javascript">
//var counter = 0;
//var timeleft = 60;
var exam_id = $('#exam_id').val();
var question_no = $('#question_no').val();
var noq = $('#noq').val();
var student=$("#student").val();
var question_type = $('#question_type').val();


$(document).ready(function(){
    $("#nextBtn").click(function(){
        var answer;
        if(question_type=="mcq"){
            
            if($("#op1").is(':checked')){
                answer = 'A';
            }
            if($("#op2").is(':checked')){
                answer = 'B';
            }
            if($("#op3").is(':checked')){
                answer = 'C';
            }
            if($("#op4").is(':checked')){
                answer = 'D';
            }
        }
        else{
            answer = $('#shortQuestion').val();
        }

        console.log(answer);
        var datastring='exam_id='+exam_id+'&question_no='+question_no+'&student='+student+'&answer='+answer;
        // //alert(datastring);
        
        $.ajax({
            type:"post",
            url:"answer_submit.php",
            data:datastring,
            
            cache:false,
            success:function(data)
            {
                //$("#m").val("");
                //getMessages();
            },
            error: (error)=>{
                console.log(JSON.stringify(error));
            } 
            
        });
        // return false;
        if(question_no==noq){
            console.log("Naku");
            window.location.href ='online_exam_details.php?id='+exam_id+'&exam_finish=1';    
        }
        else if(question_no<noq){
            question_no++;
            window.location.href ='online_exam_details.php?id='+exam_id+'&question_no='+question_no;
        }
        
    });
        
});
  
    

    var flag = $('#time_value_flag').val();
    console.log("flag "+flag)

    if(flag==0){
        var d = $('#time_value_d').val();
        var h =  $('#time_value_h').val();
        var m =  $('#time_value_m').val();
        var s =  $('#time_value_s').val();
        //console.log(d);
        //$('#timer').html(h+':'+m+':'+s);
        var time = parseInt(d)*24*3600 + parseInt(h)*3600 + parseInt(m)*60 + parseInt(s);
        //console.log(time);
        var fl = 0;
        function timeIt(){
            time--;
            var seconds = parseInt(time, 10);
            var days = Math.floor(seconds / (3600*24));
            seconds  -= days*3600*24;
            var hrs   = Math.floor(seconds / 3600);
            seconds  -= hrs*3600;
            var mnts = Math.floor(seconds / 60);
            seconds  -= mnts*60;
            //console.log(days+" days, "+hrs+" Hrs, "+mnts+" Minutes, "+seconds+" Seconds");
            if(days>0){
                $('#timer').html("Starts in "+days+" days, "+hrs+" Hrs, "+mnts+" Minutes, "+seconds+" Seconds");
            }
            else{
                if(hrs>0){
                    $('#timer').html("Starts in "+hrs+" Hrs, "+mnts+" Minutes, "+seconds+" Seconds");       
                }
                else{
                    if(mnts>0){
                        $('#timer').html("Starts in "+mnts+" Minutes, "+seconds+" Seconds");       
                    }
                    else{
                        if(seconds>0){
                            $('#timer').html("Starts in "+seconds+" Seconds");              
                        }
                        else{
                            fl = 1;
                            //alert("Starts Now");
                            /*if(question_no<noq){
                                question_no++;
                            }*/
                            window.location.href ='online_exam_details.php?id='+exam_id+'&question_no='+question_no;
                        }   
                    }
                }
            }
        
        }
        if(fl == 0){
            setInterval(function(){timeIt()}, 1000);
        }
    
    }
    else if(flag == 2){
        var d = $('#time_value_d2').val();
        var h =  $('#time_value_h2').val();
        var m =  $('#time_value_m2').val();
        var s =  $('#time_value_s2').val();
        //var since_end_this_question = $('#since_end_this_question').val();
        //console.log(d);
        //$('#timer').html(h+':'+m+':'+s);
        var time = parseInt(d)*24*3600 + parseInt(h)*3600 + parseInt(m)*60 + parseInt(s);
        //console.log(time);
        var fl = 0;
        function timeIt(){
            time--;
            //since_end_this_question--
            var seconds = parseInt(time, 10);
            var days = Math.floor(seconds / (3600*24));
            seconds  -= days*3600*24;
            var hrs   = Math.floor(seconds / 3600);
            seconds  -= hrs*3600;
            var mnts = Math.floor(seconds / 60);
            seconds  -= mnts*60;
            //console.log(days+" days, "+hrs+" Hrs, "+mnts+" Minutes, "+seconds+" Seconds");
            if(days>0){
                $('#timer').html("Ends in "+days+" days, "+hrs+" Hrs, "+mnts+" Minutes, "+seconds+" Seconds");
            }
            else{
                if(hrs>0){
                    $('#timer').html("Ends in "+hrs+" Hrs, "+mnts+" Minutes, "+seconds+" Seconds");       
                }
                else{
                    if(mnts>0){
                        $('#timer').html("Ends in "+mnts+" Minutes, "+seconds+" Seconds");       
                    }
                    else{
                        if(seconds>1){
                            $('#timer').html("Ends in "+seconds+" Seconds");              
                        }
                        else{
                            var answer;
                            if(question_type=="mcq"){
                                
                                if($("#op1").is(':checked')){
                                    answer = 'A';
                                }
                                if($("#op2").is(':checked')){
                                    answer = 'B';
                                }
                                if($("#op3").is(':checked')){
                                    answer = 'C';
                                }
                                if($("#op4").is(':checked')){
                                    answer = 'D';
                                }
                            }
                            else{
                                answer = $('#shortQuestion').val();
                            }

                            console.log(answer);
                            var datastring='exam_id='+exam_id+'&question_no='+question_no+'&student='+student+'&answer='+answer;
                            // //alert(datastring);
                            
                            $.ajax({
                                type:"post",
                                url:"answer_submit.php",
                                data:datastring,
                                
                                cache:false,
                                success:function(data)
                                {
                                    //$("#m").val("");
                                    //getMessages();
                                },
                                error: (error)=>{
                                    console.log(JSON.stringify(error));
                                } 
                                
                            });
                            
                            fl = 1;
                            window.location.href ='online_exam_details.php?id='+exam_id+'&exam_finish=1';
                        }   
                    }
                }
            }
            /*
            if(since_end_this_question>=0){
                $('#timer2').html("Next question comes in "+since_end_this_question+" Seconds");              
            }
            else{
                var answer;
                if($("#op1").is(':checked')){
                    answer = 'A';
                }
                if($("#op2").is(':checked')){
                    answer = 'B';
                }
                if($("#op3").is(':checked')){
                    answer = 'C';
                }
                if($("#op4").is(':checked')){
                    answer = 'D';
                }

                console.log(answer);
                var datastring='exam_id='+exam_id+'&question_no='+question_no+'&student='+student+'&answer='+answer;
                // //alert(datastring);
                
                $.ajax({
                    type:"post",
                    url:"answer_submit.php",
                    data:datastring,
                    
                    cache:false,
                    success:function(data)
                    {
                        //$("#m").val("");
                        //getMessages();
                    },
                    error: (error)=>{
                        console.log(JSON.stringify(error));
                    } 
                    
                });
                // return false;
                if(question_no==noq){
                    console.log("Naku");
                    window.location.href ='online_exam_details.php?id='+exam_id+'&exam_finish=1';    
                }
                else if(question_no<noq){
                    question_no++;
                    window.location.href ='online_exam_details.php?id='+exam_id+'&question_no='+question_no;
                }
            }*/
        }
        if(fl == 0){
            setInterval(function(){timeIt()}, 1000);
        }
    
    }
     

</script>
    <!--Please, place all your div/box/anything inside the above SECTION-->

<?php
    require_once('inc/footer.php');
?>