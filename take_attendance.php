<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    $a_id = $_GET['id'];
    $q = mysqli_query($con, "SELECT * FROM attendance_info WHERE id = '$a_id'");
    if(mysqli_num_rows($q)>0){
        $row = mysqli_fetch_array($q);
        $teacher = $row['teacher'];
        
        
        $class = $row['class'];
        $section = $row['section'];

        $teacher_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE email = '$teacher'");
        $rw = mysqli_fetch_array($teacher_info);
        $teacher_name = $rw['name'];
    }
    else{
        header('Location: index.php');   
    }
    
    $avrage = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    
    $msg = "";
    if(isset($_POST['submitAttendence'])){
        $qq = mysqli_query($con, "SELECT * FROM `daily_attendance` WHERE a_id='$a_id' AND DATE(`date`) = CURDATE()");
        if(mysqli_num_rows($qq)>0){
            $msg = "<h5 style='color:red'>You have already taken todays attendance</h5>";
        }
        else{
            $data = [];
            for($i=1;$i<=60;$i++){
                $roll = "roll".$i;
                //echo $roll.'<br>';
                $value = $_POST[$roll];
                //echo $value.'<br>';
                array_push($data, (int)$value);
            }
            $dt = json_encode($data);

            $qx = mysqli_query($con, "INSERT INTO `daily_attendance` (`id`, `a_id`, `data`, `date`) VALUES (NULL, '$a_id', '$dt', NOW());");
            
        }
    }
    
    $i=0;
    $qr = mysqli_query($con, "SELECT * FROM daily_attendance WHERE a_id = '$a_id'");
    while($row = mysqli_fetch_array($qr)){
        $i = $i + 1;
        $yourArray = json_decode($row['data']);
        $j=0;
        foreach($yourArray as $value)
        {
            $avrage[$j] += $value;
            $j++;
        }   
    }
    //echo $avrage[0].'<br>';
    //echo $i.'<br>';
    for($k=0;$k<=59;$k++){
        $avrage[$k] = ($avrage[$k]?$avrage[$k]/$i:0);    
    }
    
    
    //echo $avrage[8]*100;
    //$xl = json_decode($row['data']);
    foreach($avrage as $x){
        //echo $x.'<br>';
    }

?>
    <!--SECTION STARTS HERE -->
	<!--Please, place all your div/box/anything inside the above SECTION-->
    <div class="section" style="">
        <div class="row">
            <div class="col-md-10">
                <?php 
                    if($userType=='teacher'){ 
                ?>
                <div class="box80">
                    <a href="attendance_list.php?id=<?php echo $a_id; ?>"><button class="btn btn-warning"><i class="fa fa-backward" aria-hidden="true"></i> Show All</button></a>
                    <br>
                    <br>
                    <h5 class="boxHeader">Take Attendence:</h5>
                    <?php if(isset($msg)){echo $msg;} ?>
                    <h6 style="font-weight: bold;">Teacher: <?php echo $teacher_name; ?></h6>
                    <h6 style="font-weight: bold;">Class: <?php echo $class; ?></h6>
                    <h6 style="font-weight: bold;">Section: <?php echo $section; ?></h6>
                    <h6 style="font-weight: bold;">Date: <?php echo Date('d-M-Y'); ?></h6>
                    <hr>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Roll: 1</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll1" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll1" value="0"> Absent 
                                </label>
                                <br>        
                                <label>Roll: 2</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll2" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll2" value="0"> Absent 
                                </label>        
                                <br>
                                <label>Roll: 3</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll3" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll3" value="0"> Absent 
                                </label>
                                <br>        
                                <label>Roll: 4</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll4" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll4" value="0"> Absent 
                                </label>
                                <br>        
                                <label>Roll: 5</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll5" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll5" value="0"> Absent 
                                </label>        
                                <br>
                                <label>Roll: 6</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll6" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll6" value="0"> Absent 
                                </label>        
                                <br>
                                <label>Roll: 7</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll7" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll7" value="0"> Absent 
                                </label>        
                                <br>
                                <label>Roll: 8</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll8" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll8" value="0"> Absent 
                                </label>        
                                <br>
                                <label>Roll: 9</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll9" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll9" value="0"> Absent 
                                </label>        
                                <br>
                                <label>Roll: 10</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll10" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll10" value="0"> Absent 
                                </label>        
                                <br>
                                <label>Roll: 11</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll11" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll11" value="0"> Absent 
                                </label>        
                                <br>
                                <label>Roll: 12</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll12" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll12" value="0"> Absent 
                                </label>        
                                <br>
                                <label>Roll: 13</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll13" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll13" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 14</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll14" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll14" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 15</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll15" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll15" value="0"> Absent 
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label>Roll: 16</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll16" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll16" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 17</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll17" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll17" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 18</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll18" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll18" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 19</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll19" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll19" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 20</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll20" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll20" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 21</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll21" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll21" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 22</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll22" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll22" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 23</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll23" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll23" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 24</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll24" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll24" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 25</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll25" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll25" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 26</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll26" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll26" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 27</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll27" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll27" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 28</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll28" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll28" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 29</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll29" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll29" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 30</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll30" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll30" value="0"> Absent 
                                </label>
                                <br>
                            </div>
                            <div class="col-md-3">
                                <label>Roll: 31</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll31" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll31" value="0"> Absent 
                                </label>        
                                <br>
                                <label>Roll: 32</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll32" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll32" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 33</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll33" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll33" value="0"> Absent 
                                </label> 
                                <br>
                                <label>Roll: 34</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll34" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll34" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 35</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll35" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll35" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 36</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll36" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll36" value="0"> Absent 
                                </label> 
                                <br>
                                <label>Roll: 37</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll37" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll37" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 38</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll38" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll38" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 39</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll39" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll39" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 40</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll40" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll40" value="0"> Absent 
                                </label>                                                                      
                                <br>
                                <label>Roll: 41</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll41" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll41" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 42</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll42" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll42" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 43</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll43" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll43" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 44</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll44" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll44" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 45</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll45" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll45" value="0"> Absent 
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label>Roll: 46</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll46" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll46" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 47</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll47" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll47" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 48</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll48" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll48" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 49</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll49" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll49" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 50</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll50" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll50" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 51</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll51" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll51" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 52</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll52" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll52" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 53</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll53" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll53" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 54</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll54" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll54" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 55</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll55" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll55" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 56</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll56" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll56" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 57</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll57" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll57" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 58</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll58" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll58" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 59</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll59" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll59" value="0"> Absent 
                                </label>
                                <br>
                                <label>Roll: 60</label>
                                <br>
                                <label class="radio-inline" style="color:green;">
                                  <input type="radio" name="roll60" value="1" checked> Present&nbsp;&nbsp; 
                                </label>
                                <label class="radio-inline" style="color:red;">
                                  <input type="radio" name="roll60" value="0"> Absent 
                                </label>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success" name="submitAttendence">Submit</button>
                    </form>
                </div>
                <div class="box80" style="margin-top: 20px;">
                    <h5 class="boxHeader">Percentage of Attendance:</h5>
                    <h6 style="font-weight: bold;">Teacher: <?php echo $teacher_name; ?></h6>
                    <h6 style="font-weight: bold;">Class: <?php echo $class; ?></h6>
                    <h6 style="font-weight: bold;">Section: <?php echo $section; ?></h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <?php
                            for($i=0;$i<15;$i++){
                            ?>
                            <h5 style="font-weight: bold;">Roll <?php echo $i+1; ?>: <span style="color:blue;"><?php echo round($avrage[$i]*100); ?> %</span></h5>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                            for($i=15;$i<30;$i++){
                            ?>
                            <h5 style="font-weight: bold;">Roll <?php echo $i+1; ?>: <span style="color:blue;"><?php echo round($avrage[$i]*100); ?> %</span></h5>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                            for($i=30;$i<45;$i++){
                            ?>
                            <h5 style="font-weight: bold;">Roll <?php echo $i+1; ?>: <span style="color:blue;"><?php echo round($avrage[$i]*100); ?> %</span></h5>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                            for($i=45;$i<60;$i++){
                            ?>
                            <h5 style="font-weight: bold;">Roll <?php echo $i+1; ?>: <span style="color:blue;"><?php echo round($avrage[$i]*100); ?> %</span></h5>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    
                </div>
                <?php
                    }
                    else{
                ?>
                <div class="box80" style="margin-top: 20px;">
                    <h5 class="boxHeader">Attendance:</h5>
                    <h6 style="font-weight: bold;">Teacher: <?php echo $teacher_name; ?></h6>
                    <h6 style="font-weight: bold;">Class: <?php echo $class; ?></h6>
                    <h6 style="font-weight: bold;">Section: <?php echo $section; ?></h6>
                    <hr>
                    <h6 style="font-weight: bold;">Your Name: <?php echo $name; ?></h6>
                    <h6 style="font-weight: bold;">Your Attendance Percentage: <?php if(isset($avrage[$studentRoll-1])){ echo $avrage[$studentRoll-1]*100;} ?> %</h6>
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Attendance</th>
                        </tr>
                    <?php
                    

                    $attendence_data = mysqli_query($con, "SELECT * FROM `daily_attendance` WHERE a_id = '$a_id'");
                    if(mysqli_num_rows($attendence_data)>0){
                        while($row = mysqli_fetch_array($attendence_data)){
                            $id = $row['id'];
                            //$date_list = $row['date']
                            $dt = new DateTime($row['date']);
                            $date = $dt->format('Y-m-d');
                            $attendance_data = json_decode($row['data']);
                            $j=0;
                            foreach($attendance_data as $value)
                            {
                                $attendance_array[$j] = $value;

                                $j++;
                            }
                            //if($attendance_array[$studentRoll-1]==1)
                ?>
                        <tr>
                            <td><?php echo $date; ?></td>
                            <td><?php if(isset($attendance_array[$studentRoll-1])){ if($attendance_array[$studentRoll-1]==1){echo "<span style='color:green'>Present</span>";} else{echo "<span style='color:red'>Absent</span>";}} ?></td>

                        </tr>

                <?php

                        }
                    }
                ?>
                    </table>
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
<?php
    require_once('inc/footer.php');
?>