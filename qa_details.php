<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    if(isset($_GET['id'])){
        $post_id = $_GET['id'];
    }   
    
    $post_query = mysqli_query($con, "SELECT * FROM `qa_post` WHERE `id` = '$post_id'");
    if(mysqli_num_rows($post_query)>0){
        $row = mysqli_fetch_array($post_query);
        $qaHeading = $row['title'];
        $qaDetails = $row['details'];
        $poster = $row['user'];
        $posterType = $row['userType'];
        $time = date('d M h:i A', strtotime($row['time']));
        if($posterType == 'teacher'){
            $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$poster'");
            $row = mysqli_fetch_array($teacher_info);
            $poster_name = $row['name'];
    
        }
        else if($posterType == 'student'){
            $student_info = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$poster'");
            $row = mysqli_fetch_array($student_info);
            $poster_name = $row['name'];
        }
        
        
    }

    $msg="";
    if(isset($_POST['submit'])){
        $comment = $_POST['qaComment'];
        $qa = mysqli_query($con, "INSERT INTO `qa_comment` (`id`, `post_id`, `comment`, `commenter`, `commenterType`, `time`) VALUES (NULL, '$post_id', '$comment', '$user', '$userType', NOW());");
        if($qa){
            $msg = "<div class='alertSuccess'>
                        <i class='fa fa-check'></i> Successfully Posted!
                </div>";
        }
        else{
            $msg = "<div class='alertDanger'>
                        <i class='fa fa-times'></i> Something went wrong! Please try again.
                </div>";
        }
    }
    $ct=0;
    
    if(isset($_POST['likeBtn'])){
        $vote_query = mysqli_query($con, "SELECT * FROM `qa_vote` WHERE user = '$user' AND post_id = '$post_id'");
        if(mysqli_num_rows($vote_query)==0){
            $vq = mysqli_query($con, "INSERT INTO `qa_vote` (`id`, `post_id`, `user`) VALUES (NULL, '$post_id', '$user');");
            if($vq){
                
            }
        }
    }
    $vote_query = mysqli_query($con, "SELECT * FROM `qa_vote` WHERE post_id = '$post_id'");
    if(mysqli_num_rows($vote_query)>0){
        $ct = mysqli_num_rows($vote_query);
    }   
    $vote_flag=0;
    $check_user_vote = mysqli_query($con, "SELECT * FROM `qa_vote` WHERE user = '$user' AND post_id='$post_id'");
    if(mysqli_num_rows($check_user_vote)>0)$vote_flag = 1; 

?>

<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
	<div class="section" style="">
        <div class="row">
            <div class="col-md-10">
                <div class="box2nd90">
                  <h5 class="box2ndHeader">Posted: <?php echo $time; ?><span class="boxSpan"> <form method="post"><button <?php if($vote_flag==1)echo "disabled"; ?> type="submit" name="likeBtn" style="background:#6495ED"><i class="fa fa-thumbs-up"></i></button></form></span><small style="float: right;"><?php if(isset($ct)) echo $ct;?> &nbsp;</small></h5>
                  <div style="padding: 20px;">
                      <h3><?php echo $qaHeading;?></h3>
                      <h6 <?php if($posterType=='teacher'){echo "style='color:Maroon; font-weight:bold;'";}else{echo "style='color:RebeccaPurple; font-weight:bold;'";} ?>><?php echo $poster_name ?></h6>
                      <?php echo $qaDetails; ?>
                  </div>
                  <div style="padding: 20px;">
                    <h5 class="boxHeader">Comments:</h5>
                    <?php

                    $comment_query = mysqli_query($con, "SELECT * FROM `qa_comment` WHERE `post_id` = '$post_id'");
                    if(mysqli_num_rows($comment_query)>0){
                        while($row = mysqli_fetch_array($comment_query)){
                            $Com = $row['comment'];
                            $commenter = $row['commenter'];
                            $commenterType = $row['commenterType'];
                            $time = date('d M h:i A', strtotime($row['time']));
                            if($commenterType == 'teacher'){
                                $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$commenter'");
                                $row = mysqli_fetch_array($teacher_info);
                                $commenter_name = $row['name'];
                        
                            }
                            else if($commenterType == 'student'){
                                $student_info = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$commenter'");
                                $row = mysqli_fetch_array($student_info);
                                $commenter_name = $row['name'];
                            }
                       
                    ?>
                    <h5 class="box2ndHeader">Commented: <?php echo $time; ?></h5>
                    <div style="padding: 20px; border: 2px solid #6495ED;">
                      <h6 <?php if($commenterType=='teacher'){echo "style='color:Maroon; font-weight:bold;'";}else{echo "style='color:RebeccaPurple; font-weight:bold;'";} ?>><?php echo $commenter_name ?></h6>
                      <?php echo $Com; ?>
                    </div>
                    <hr>
                    <?php
                         }   
                    }
                    ?>
                    <br>
                    <?php if(isset($msg))echo $msg; ?>
                    <form method="post">
                        <textarea required id="qaComment" name="qaComment" class="form-control" >
                            Post your Comment
                        </textarea>
                        <script>
                                CKEDITOR.replace( 'qaComment' );
                        </script>               
                        <br>
                        <button type="submit" name="submit" id="commentBtn" class="btn btn-info">Post</button>
                    </form>
                    </div>
                </div>
            </div>
            <?php
                require_once('inc/chatbar.php');
            ?>
        </div>
        
	</div>
	<!--Please, place all your div/box/anything inside the above SECTION-->
    
    <script type="text/javascript">
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
<?php
	require_once('inc/footer.php');
?>