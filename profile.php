<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
?>
<input type="hidden" id="hiddenName" value="<?php echo $name; ?>">

<!--SECTION STARTS HERE -->
    <!--Please, place all your div/box/anything inside the above SECTION-->
    <div class="section" style="">
        <div class="row">
            <div class="col-md-10">
                <div class="box80">
                    <div style="font-family: Helvetica; background: #f9f9f9; border: 1px solid #e5e5e5; margin-top: 10px; padding: 10px;">
                    <center><div id="profileImage"></div></center>  
                        <br>
                        <div class="profileInfo">
                            <?php
                                if($userType == 'teacher'){
                                    
                            ?>
                            
                                <h2 style="text-align: center; color: #1B6DC1;"><?php echo $name; ?></h2>
                                <h5 style="text-align: center; color: #000;">Email: <?php echo $user; ?></h5>
                                <h5 style="text-align: center; color: #000;">Designation: <?php echo $designation; ?></h5>
                            
                            <?php 
                                }else if($userType == 'student'){
                                    
                                    

                            ?>
                                <h2 style="text-align: center; color: #1B6DC1;"><?php echo $name; ?></h2>
                                <h5 style="text-align: center; color: #000;"><b>Email:</b> <?php echo $user; ?></h5>
                                <h5 style="text-align: center; color: #000;"><b>Roll:</b> <?php echo $studentRoll; ?></h5>
                                <h5 style="text-align: center; color: #000;"><b>Class:</b> <?php echo $studentClass; ?></h5>
                                <h5 style="text-align: center; color: #000;"><b>Section:</b> <?php echo $studentSection; ?></h5>
                            <?php
                                }
                            ?>
                        </div>
                        <br>
                        <center><a href="edit_profile.php?userType=<?php echo $userType; ?>&id=<?php echo $ProfileId; ?>"><button class="btn btn-warning">Edit Profile</button></a></center>
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
$(document).ready(function(){
    var fullName = $('#hiddenName').val();
    console.log(fullName);
    var res = fullName.split(" ");
    var firstName = res[0].toUpperCase();
    //console.log(res.length);
    if(res.length>1){
        var lastName = res[1].toUpperCase();
    }
    //console.log(res[0]);
    if(res.length>1){
        var intials = firstName.charAt(0) + lastName.charAt(0);
    }
    else{
        var intials = firstName.charAt(0);  
    }
    var profileImage = $('#profileImage').text(intials);
});
</script>
<?php
    require_once('inc/footer.php');
?>