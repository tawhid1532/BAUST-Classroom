<?php
    require_once('inc/top.php');
    if(empty($user)){
        header('Location: login.php');
    }
    if($userType == 'teacher' || $userType == 'student'){
        header('Location: index.php');   
    }
?>

<!--SECTION STARTS HERE -->
    <!--Please, place all your div/box/anything inside the above SECTION-->
    <div class="section" style="">
        <div class="row">
            <div class="col-md-10">
                <div class="box80">
                    <h5 class="boxHeader">New Student Requests:</h5>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Roll</th>
                          <th scope="col">Email</th>
                          <th scope="col">Class</th>
                          <th scope="col">Section</th>
                          <th scope="col">Approval</th>
                        </tr>
                      </thead>
                      <tbody>
                <?php
                        $i=0;
                        $student_info = mysqli_query($con, "SELECT * FROM student_register WHERE approved = 0");
                        while($row = mysqli_fetch_array($student_info)){
                            $student_name = $row['name'];
                            $student_roll = $row['roll'];
                            $student_email = $row['email'];
                            $student_class = $row['class'];
                            $student_section = $row['section'];
                            $i++;
                ?>
                        <tr>
                          <th scope="row"><?php echo $i; ?></th>
                          <td><?php echo $student_name; ?></td>
                          <td><?php echo $student_roll; ?></td>
                          <td><?php echo $student_email; ?></td>
                          <td><?php echo $student_class; ?></td>
                          <td><?php echo $student_section; ?></td>
                          <td>
                            <a href="delete.php?delete_type=student&email=<?php echo $student_email; ?>">
                                <button 
                                    id="showButton" 
                                    type="button" 
                                    style="float:right;" 
                                    class="btn btn-outline-danger" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Delete">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </a>
                            <a href="approve.php?user_type=student&email=<?php echo $student_email; ?>">
                                <button 
                                    id="showButton" 
                                    type="button" 
                                    style="float:right;" 
                                    class="btn btn-outline-success" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Delete">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </button>
                            </a>
                          </td>
                        </tr>
                <?php
                            }
                ?>
                      </tbody>
                    </table>
                </div>
                <div class="box80">
                    <h5 class="boxHeader">New Teacher Requests:</h5>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Email</th>
                          <th scope="col">Designation</th>
                          <th scope="col">Approval</th>
                        </tr>
                      </thead>
                      <tbody>
                <?php
                        $i=0;
                        $student_info = mysqli_query($con, "SELECT * FROM teacher_register WHERE approved = 0");
                        while($row = mysqli_fetch_array($student_info)){
                            $teacher_name = $row['name'];
                            $teacher_email = $row['email'];
                            $teacher_designation = $row['designation'];
                            $i++;
                ?>
                        <tr>
                          <th scope="row"><?php echo $i; ?></th>
                          <td><?php echo $teacher_name; ?></td>
                          <td><?php echo $teacher_email; ?></td>
                          <td><?php echo $teacher_designation; ?></td>
                          <td>
                            <a href="delete.php?delete_type=teacher&email=<?php echo $teacher_email; ?>">
                                <button 
                                    id="showButton" 
                                    type="button" 
                                    style="float:right;" 
                                    class="btn btn-outline-danger" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Delete">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </a>
                            <a href="approve.php?user_type=teacher&email=<?php echo $teacher_email; ?>">
                                <button 
                                    id="showButton" 
                                    type="button" 
                                    style="float:right;" 
                                    class="btn btn-outline-success" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Delete">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </button>
                            </a>
                          </td>
                        </tr>
                <?php
                            }
                ?>
                      </tbody>
                    </table>
                </div> 
            </div>
        </div>
    </div>
    <!--Please, place all your div/box/anything inside the above SECTION-->
<?php
    require_once('inc/footer.php');
?>