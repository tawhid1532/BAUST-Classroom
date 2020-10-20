<?php
	require_once('db.php');
	$user = $_POST['name11'];
	$receiver_user = $_POST['name22'];
	$message = mysqli_real_escape_string($con, $_POST['name33']);

	if(isset($_POST['name33'])){

        $ins_query="INSERT INTO `pm`(`id`, `sender`, `receiver`, `message`, `timestamp`, `seen`) VALUES (NULL, '$user', '$receiver_user', '$message', NOW(), 0);";
        $run = mysqli_query($con,$ins_query);
        echo "o";
    }
?>