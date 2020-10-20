<?php
	require_once('inc/top.php');
?>





	<!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
	<div class="section" style="">
			<?php if(!empty($user)){?>
		<div class="row">
			<div class="col-md-10">
				<div class="sliderBox">
					<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
							<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
							<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
						</ol>
						<div class="carousel-inner">
							<div class="carousel-item active">
							<img src="img/pic1.jpg" class="d-block w-100" alt="...">
							</div>
							<div class="carousel-item">
							<img src="img/pic2.jpg" class="d-block w-100" alt="...">
							</div>
							<div class="carousel-item">
							<img src="img/pic3.jpg" class="d-block w-100" alt="...">
							</div>
						</div>
						<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>	
				</div>
				<br>
				<div class="box90">
				 	<h5 class="boxHeader">Recent Q&A:</h5>
				 	<?php
                    

                    $qa_data = mysqli_query($con, "SELECT * FROM `qa_post` ORDER BY id DESC Limit 2");
                    if(mysqli_num_rows($qa_data)>0){
                        while($row = mysqli_fetch_array($qa_data)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $time = $row['time'];
                            $time = date('d-M h:i A', strtotime($time));

                            $userEmail = $row['user'];
                            $TypeofUser = $row['userType'];
                            if($TypeofUser == 'teacher'){
                                $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$userEmail'");
                                $row = mysqli_fetch_array($teacher_info);
                                $teacher_name = $row['name'];
                        ?>
                            
                            <a style="text-decoration: none;" href="qa_details.php?id=<?php echo $id; ?>"><div class="reviewBox hoverEffect paged-element" style="margin-bottom:10px;">
                            <div class="quoteSignOne"></div>
                            <div class="quoteSignTwo"></div>
                            <p style="font-weight: bold;"><?php echo $title?></p>
                            <h1><?php echo $time;?></h1>
                            <h1>by <span style="color:Maroon;"><?php echo $teacher_name; ?></span></h1>
                            </div></a>
                        <?php
                            }
                            else if($TypeofUser == 'student'){
                                $student_info = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$userEmail'");
                                $row = mysqli_fetch_array($student_info);
                                $student_name = $row['name'];
                        ?>
                            
                            
                            <a style="text-decoration: none;" href="qa_details.php?id=<?php echo $id; ?>"><div class="reviewBox hoverEffect paged-element" style="margin-bottom:10px;">
                            <div class="quoteSignOne"></div>
                            <div class="quoteSignTwo"></div>
                            <p style="font-weight: bold;"><?php echo $title?></p>
                            <h1><?php echo $time;?></h1>
                            <h1>by <span style="color:RebeccaPurple;"><?php echo $student_name; ?></span></h1>
                            </div></a>
                            
                            <!--<a href="qa_details.php?id=<?php echo $id; ?>" style="text-decoration:none;"><div style="background:#A7CDF2; padding:15px; font-weight:bold; margin-top:10px; "><h5 style="width: 500px;"><?php echo $title; ?> - <i>by <small style="color: blue;"><?php echo $student_name ?></small></i> </h5></div></a>-->
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
				<br>
				<div class="box90">
					<h5 class="boxHeader">Recent Shared Resources:</h5>
					<?php
                    
                    $resource = mysqli_query($con, "SELECT * FROM `resource` ORDER BY id DESC Limit 3");
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
			<?php require_once('inc/chatbar.php'); ?>
		</div>
		<?php }
		else{
		?>
		<div class="sliderBox">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active">
					<img src="img/pic1.jpg" class="d-block w-100" alt="...">
					</div>
					<div class="carousel-item">
					<img src="img/pic2.jpg" class="d-block w-100" alt="...">
					</div>
					<div class="carousel-item">
					<img src="img/pic3.jpg" class="d-block w-100" alt="...">
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>	
		</div>
		<br>
		<div class="box90">
			<h5 class="boxHeader" style="text-align: center;">Please Log in to See more.</h5>
			<center><a href="login.php"><button class="btn btn-info">Login</button></a></center>
		</div>
		<?php
		}
		 ?>
		
	</div>
	<!--Please, place all your div/box/anything inside the above SECTION-->




<?php
	require_once('inc/footer.php');
?>