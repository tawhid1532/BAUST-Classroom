<?php
	require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    $fl=0;
    if(isset($_GET['username'])){
    	$receiver_mail = $_GET['username'];
    	$messageSeen = mysqli_query($con, "UPDATE `pm` SET `seen` = '1' WHERE `pm`.`sender` = '$receiver_mail' AND `pm`.`receiver` = '$user';");
    	
    	$check = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$receiver_mail'");
		$check2 = mysqli_query($con, "SELECT * FROM student_register WHERE email = '$receiver_mail'");
		if(mysqli_num_rows($check)>0){
			$row=mysqli_fetch_array($check);
			$receiver_name = $row['name'];
			$receiver_type = 'teacher';
		}
		else if(mysqli_num_rows($check2)>0){
			$row=mysqli_fetch_array($check2);
			$receiver_name = $row['name'];
			$receiver_type = 'student';
		}
		else{
			$fl=1;
		}
    }	
    else{
    	header('Location: index.php');	
    }
?>
<div class="section">
	<!--<div class="box80" id="" style="border: 1px solid black; height: 200px;overflow: auto;">-->

	<div class="row">
		<div class="col-md-10" style="margin: 0; padding: 0; height: 600px;">
			<?php if($fl==0){?>
			<div class="chat_window" style="">
		        <div class="top_menu">
		            <div class="buttons">
		                <!--<img style="margin-top: -12px; margin-left: -5px; " src="dp/<?php //echo $imageName;?>" width="50" class="rounded-circle">-->
		            </div>
		            <div class="title" style="color:<?php if($receiver_type=="student"){echo "teal";}else{echo "maroon";}?>"><?php echo $receiver_name; ?></div>
		        </div>
		        
		        <ul id="messages" style="overflow-y:scroll; overflow-x: hidden; height: 72%;">
		        
		        
		        </ul>
		        <div class="bottom_wrapper clearfix">
		            <form id="pm" method="post" action=''>
		                <div class="btn-group" style="width: 100%;">
		                	<textarea type="text" required id="m"   class="form-control" rows="1" placeholder="Type your message here..."></textarea>
		                	<input type="hidden" id="user" name="" value="<?php echo $user;?>">
		                	<input type="hidden" id="receiver_user" name=""  value="<?php echo $receiver_mail;?>">
		                    <button id="m_submit" type="submit" class="btn btn-dark" style="margin-left: 10px;">Send <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
		                </div>
		            </form>               
		        </div>
		    </div>
		<?php }
			  else{	
		?>
		<div class="box80">
			<h5 class="boxHeader">
				USER NOT FOUND
			</h5>
		</div>
		<?php 
			}
		?>
		</div>
		<?php
			require_once('inc/chatbar.php');
		?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#pm").submit(function(){
		//alert("Hello adil");
		var adil=$("#user").val();
		var data2=$("#receiver_user").val();
		var data3=$("#m").val();
		var datastring='name11='+adil+'&name22='+data2+'&name33='+data3;
		//alert(datastring);
		
		$.ajax({
			type:"post",
			url:"pmsend.php",
			data:datastring,
			
			cache:false,
			success:function(data)
			{
				$("#m").val("");
				//getMessages();
			}
			
		});
		return false;
		
	});
		
});
	function getMessages(letter) {
    	var div = $("#messages");
    	div.scrollTop(div.prop('scrollHeight'));
    	
	}

	$(function() {
	    getMessages();
	});


	function getData()
    {
        $.ajax({
            type: 'GET',
            url: "load.php?receiver=<?php echo $receiver_mail;?>",
            success: function(response)
            {
                //console.log(response);
                document.getElementById("messages").innerHTML=response;

            },
            error: (error)=>{
            	console.log(JSON.stringify(error));
            } 
        })
    }






setInterval(() => {
	getData();
        
     }, 2000);


setInterval(() => {
	getMessages();  // UnComment this line and in load.php line 51 change DESC to ASC 
        
    }, 1000);

</script>
<?php
	require_once('inc/footer.php');
?>
