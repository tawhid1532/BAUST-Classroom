<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
        
    $msg="";
    if(isset($_POST['submit'])){
        $title = mysqli_real_escape_string($con,$_POST['rtitle']);
        if(isset($_POST['rdescription'])){
            $rdescription = mysqli_real_escape_string($con,$_POST['rdescription']);
        }
        else{
            $rdescription = ""; 
        }
        $ctype = $_POST['ctype'];
        $url = "";
        $file_name = $_FILES['rfile']['name'];
        $file_size =$_FILES['rfile']['size'];
        $file_tmp =$_FILES['rfile']['tmp_name'];
        if($file_size < 209710000){
            $rn = mysqli_query($con,"INSERT INTO `resource` (`id`, `title`, `description`, `type`, `url`, `filename`, `user`, `userType`) VALUES (NULL, '$title', '$rdescription', '$ctype', '$url', '$file_name','$user','$userType');");  
            
            $up = move_uploaded_file($file_tmp,"resource/".$file_name);   
            if($rn && $up){
                $msg = "<div class='alertSuccess'>
                        <i class='fa fa-check'></i> Successfully Uploaded Resource.
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
                        <i class='fa fa-times'></i> File should not be greater than 2 MB.
                    </div>";
        }
    }
    $msg2="";
    if(isset($_POST['submitY'])){
        $title = mysqli_real_escape_string($con,$_POST['yrtitle']);
        if(isset($_POST['yrdescription'])){
            $rdescription = $_POST['yrdescription'];
        }
        else{
            $rdescription = ""; 
        }
        $ctype = "Youtube Video";
        $url = $_POST['Yurl'];
        $file_name = "";
        $rn = mysqli_query($con,"INSERT INTO `resource` (`id`, `title`, `description`, `type`, `url`, `filename`, `user`, `userType`) VALUES (NULL, '$title', '$rdescription', '$ctype', '$url', '$file_name','$user','$userType');");  
        
        if($rn){
            $msg2 = "<div class='alertSuccess'>
                    <i class='fa fa-check'></i> Successfully Uploaded Resource.
                </div>";            
        }
        else{
            $msg2 = "<div class='alertDanger'>
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
        		<div class="box90">
                   <button id="showButton" onclick="showForm()" type="button" style="float:right;" class="btn btn-outline-info"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    <button id="hideButton" onclick="hideForm()" type="button" style="float:right; display:none" class="btn btn-outline-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
        		   <h5 class="boxHeader">Share Resources:</h5>
                    <?php
                        if(isset($msg))echo $msg;
                    ?>
                    <form method="post" enctype="multipart/form-data" id="resourceForm" style="display:none">
                        <label style="color:blue;" for="title">Title:</label>
                        <input type="text" required id="title" name="rtitle" class="form-control" placeholder="Write a title for your resource">
                        <br>
                        <label style="color:blue;" for="description">Description: (Optional)</label>
                        <textarea name="rdescription" class="form-control" placeholder="You can write a short description about your resource"></textarea>
                        <br>  
                        <label style="color:blue;" for="type">Content Type:</label>
                        <select required id="type" name="ctype" class="form-control"  onchange="myFunction(event)">
                            <option value="" selected disabled>Select Content Type:</option>
                            <option value="PDF">PDF</option>
                            <option value="DOC">Word File / Doc</option>
                            <option value="PPT">Powerpoint File / PPTX</option>
                            <option value="CSV">Excel File / CSV</option>
                            <option value="Image">Image</option>
                            <option value="Others">Others</option>
                        </select>
                            
                        <br>
                        <label style="color:blue;" for="file">Upload File: </label>
                        <input type="file" required id="file" name="rfile" class="form-control-file" placeholder="You can write a short description about your resource">    
                        <br>
        			 	<button type="submit" name="submit" id="shareBtn" class="btn btn-info">Share</button>
                    </form>
        		</div>
                <div class="box90" style="margin-top: 20px;">
                    <button id="showButton2" onclick="showForm2()" type="button" style="float:right;" class="btn btn-outline-info"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    <button id="hideButton2" onclick="hideForm2()" type="button" style="float:right; display:none" class="btn btn-outline-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <h5 class="boxHeader">Share Youtube Video:</h5>
                    <?php
                        if(isset($msg2))echo $msg2;
                    ?>
                    <form method="post" enctype="multipart/form-data" id="resourceForm2" style="display:none">
                        <label style="color:blue;" for="ytitle">Title:</label>
                        <input type="text" required id="ytitle" name="yrtitle" class="form-control" placeholder="Write a title for your resource">
                        <br>
                        <label style="color:blue;" for="ydescription">Description: (Optional)</label>
                        <textarea id="ydescription" name="yrdescription" class="form-control" placeholder="You can write a short description about your resource"></textarea>
                        <br>
                        <label style="color:blue;" for="url">Youtube Video Url: <span style="color:red;">(Fill only if content type is Youtube video)</span></label>
                        <br>
                        <img src="img/yout.png" width="400">
                        <img src="img/yout2.png" width="300">
                        <input type="text" id="url" name="Yurl" class="form-control" placeholder="Enter the 11 digit unique id of youtube video"> 
                        <br>
                        <button type="submit" name="submitY" id="shareYoutubeBtn" class="btn btn-info">Share</button>
                    </form>
                </div>
                <div class="box90" style="margin-top:20px;">
                    <h5 class="boxHeader">Recent Shared Resources:</h5>
                <?php
                    

                    $resource = mysqli_query($con, "SELECT * FROM `resource` ORDER BY id DESC");
                    if(mysqli_num_rows($resource)>0){
                        while($row = mysqli_fetch_array($resource)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $type = $row['type'];
                            $userEmail = $row['user'];
                            $TypeofUser = $row['userType'];
                            if($TypeofUser == 'teacher'){
                                $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$userEmail'");
                                $row = mysqli_fetch_array($teacher_info);
                                $teacher_name = $row['name'];
                        ?>
                            
                            <a style="text-decoration: none;" href="resource_details.php?id=<?php echo $id; ?>"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                            <p style="font-weight: bold; margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                            <h1><?php echo $type;?></h1>
                            <h1>by <span style="color:maroon;"><?php echo $teacher_name; ?></span></h1>
                            </div></a>
                        <?php
                            }
                            else if($TypeofUser == 'student'){
                                $student_info = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$userEmail'");
                                $row = mysqli_fetch_array($student_info);
                                $student_name = $row['name'];
                        ?>
                            
                            
                            <a style="text-decoration: none;" href="resource_details.php?id=<?php echo $id; ?>"><div class="reviewBox2 hoverEffect paged-element" style="margin-bottom:10px;">
                            <p style="font-weight: bold;margin-bottom: 0; padding-bottom: 0;"><?php echo $title?></p>
                            <h1><?php echo $type;?></h1>
                            <h1>by <span style="color:RebeccaPurple;"><?php echo $student_name; ?></span></h1>
                            </div></a>
                            
                        <?php
                            }

                        }
                    }
                    else{
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
            document.getElementById("resourceForm").style.display = "block"
            document.getElementById("hideButton").style.display = "block"
            document.getElementById("showButton").style.display = "none"
        }

        function hideForm(){
            document.getElementById("resourceForm").style.display = "none"
            document.getElementById("hideButton").style.display = "none"
            document.getElementById("showButton").style.display = "block"
        }

        function showForm2(){
            document.getElementById("resourceForm2").style.display = "block"
            document.getElementById("hideButton2").style.display = "block"
            document.getElementById("showButton2").style.display = "none"
        }

        function hideForm2(){
            document.getElementById("resourceForm2").style.display = "none"
            document.getElementById("hideButton2").style.display = "none"
            document.getElementById("showButton2").style.display = "block"
        }

    </script>
	<!--Please, place all your div/box/anything inside the above SECTION-->

<?php
	require_once('inc/footer.php');
?>