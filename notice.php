<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
        
    $msg="";
    if(isset($_POST['submit'])){
        $title = mysqli_real_escape_string($con,$_POST['qaHeading']);
        $Details = mysqli_real_escape_string($con,$_POST['qaDetails']);
        $qa = mysqli_query($con, "INSERT INTO `notice` (`id`, `teacher`, `title`, `details`, `timestamp`) VALUES (NULL, '$user', '$title', '$Details', NOW());");
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
?>

<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
	<div class="section" style="">
        <div class="row">
            <div class="col-md-10">
                <?php
                if($userType == 'teacher'){
                ?>
                <div class="box90">
                    <button id="showButton" onclick="showForm()" type="button" style="float:right;" class="btn btn-outline-info"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    <button id="hideButton" onclick="hideForm()" type="button" style="float:right; display:none" class="btn btn-outline-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <h5 class="boxHeader">Create New Notice:</h5>
                    <?php
                        if(isset($msg))echo $msg;
                    ?>
                    <form method="post" id="noticeForm" style="display:none">
                        <label style="color:blue;" for="qaHeading">Heading:</label>
                        <input required id="qaHeading" type="text" name="qaHeading" placeholder="Enter a title of your post" class="form-control">
                        <br>
                        <label style="color:blue;" for="qaDetails">Details:</label>
                        <textarea required id="qaDetails" name="qaDetails" class="form-control" rows="6">
                        </textarea>
                        <script>
                                CKEDITOR.replace( 'qaDetails' );
                        </script>               
                        <br>
                        <button type="submit" name="submit" id="postBtn" class="btn btn-info">Post</button>
                    </form>
                </div>
                <?php
                }
                ?>
                <div class="box90" style="margin-top:20px;">
                    <h5 class="boxHeader">Recent Notices:</h5>
                <?php
                    

                    $qa_data = mysqli_query($con, "SELECT * FROM `notice` ORDER BY id DESC");
                    if(mysqli_num_rows($qa_data)>0){
                        while($row = mysqli_fetch_array($qa_data)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $time = $row['timestamp'];
                            $time = date('d-M h:i A', strtotime($time));

                            $userEmail = $row['teacher'];
                            
                        
                            $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$userEmail'");
                            $row = mysqli_fetch_array($teacher_info);
                            $teacher_name = $row['name'];
                        ?>
                            
                            <a style="text-decoration: none;" href="notice_details.php?id=<?php echo $id; ?>"><div class="reviewBox hoverEffect paged-element" style="margin-bottom:10px;">
                            <div class="quoteSignOne"></div>
                            <div class="quoteSignTwo"></div>
                            <p style="font-weight: bold;"><?php echo $title?></p>
                            <h1><?php echo $time;?></h1>
                            <h1>by <span style="color:Maroon;"><?php echo $teacher_name; ?></span></h1>
                            </div></a>
                        <?php
                        
                        }
                    }
                    else {

                ?>
                    <h6 style="color:#7f7f7f; font-style: italic;">Nothing to show yet.</h6>
                <?php
                    }
                ?>
                </div>
            </div>
            <?php
                require_once('inc/chatbar.php');
            ?>
        </div>
	</div>
     <script>
        
        function showForm(){
            document.getElementById("noticeForm").style.display = "block"
            document.getElementById("hideButton").style.display = "block"
            document.getElementById("showButton").style.display = "none"
        }

        function hideForm(){
            document.getElementById("noticeForm").style.display = "none"
            document.getElementById("hideButton").style.display = "none"
            document.getElementById("showButton").style.display = "block"
        }

    </script>
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