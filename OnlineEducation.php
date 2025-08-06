<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_POST['submit'])){

    $Portal_Name=$_POST['Portal_Name'];
    $studentsOfferedOnlineCourses=$_POST['studentsOfferedOnlineCourses'];
    $totalonlinecourses=$_POST['totalonlinecourses'];
    $totalnumberofcreditstransfered=$_POST['totalnumberofcreditstransfered'];

    $query="INSERT INTO `online_education_details`(`A_YEAR`, `DEPT_ID`, `PORTAL_NAME`, `NO_STUDENT_OFFER_OS`, `NO_OF_ONLINE_COURSES`, `TOTAL_NO_CREDIT_TRANS`) 
    VALUES ('$A_YEAR', '$dept','$Portal_Name','$studentsOfferedOnlineCourses', '$totalonlinecourses', '$totalnumberofcreditstransfered')
    ON DUPLICATE KEY UPDATE
    PORTAL_NAME = VALUES(PORTAL_NAME),
    NO_STUDENT_OFFER_OS = VALUES(NO_STUDENT_OFFER_OS),
    NO_OF_ONLINE_COURSES = VALUES(NO_OF_ONLINE_COURSES),
    TOTAL_NO_CREDIT_TRANS = VALUES(TOTAL_NO_CREDIT_TRANS)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "OnlineEducation.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from online_education_details where ID = '$id'");
        echo '<script>window.location.href = "OnlineEducation.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 "><b>Online Education</b></p>
                </div>
                
                <!-- The Instructions -->
                <div class="alert alert-danger align-content-between justify-content-center" role="alert">
                    <h5><b></b>Important Notes</h5>
                    <ul type="dot">
                        <li style="font-weight: 200;"><b>Note: Enter value(s) in all field(s); if not applicable enter zero[0]</b></li>
                    </ul>   
                </div>
                
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
                    <input type="year" name="year" value="<?php echo $A_YEAR?>" class="form-control" style="margin-top: 0;" disabled>
                </div>
                
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
                    <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" style="margin-top: 0;" disabled>
                </div>
                
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Portal Name</b></label>
                    <input type="text" name="Portal_Name" class="form-control" placeholder="Enter Portal Name" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Number Of Students offered Online Courses</b></label>
                    <input type="text" name="studentsOfferedOnlineCourses" class="form-control" placeholder="Enter No of Students offered Online Courses" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Total No. of online courses</b></label>
                    <input type="text" name="totalonlinecourses" class="form-control" placeholder="Enter Total No of Online Courses" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Total No. Of Credits Transfered</b></label>
                    <input type="text" name="totalnumberofcreditstransfered" class="form-control" placeholder="Enter Total No of Credits Transfered" style="margin-top: 0;" required>
                </div>
                
                <input type="submit" class="submit" value="Submit" name="submit" onclick="return Validate()">
            </form>
        </div>

        <!-- Show Entered Data -->
    <div class="row my-5" >
    <h3 class="fs-4 mb-3 text-center" id="msg"><b>You Have Entered the Following Data</b></h3>
        <div class="col ">
            <div class="overflow-auto">
                <table class="table bg-white rounded shadow-sm  table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Academic Year</th>
                            <th scope="col">Portal Name</th>
                            <th scope="col">Number Of Students offered Online Courses</th>
                            <th scope="col">Total No. of online courses</th>
                            <th scope="col">Total No. Of Credits Transfered</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM online_education_details WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['PORTAL_NAME']?></td>
                    <td><?php echo $row['NO_STUDENT_OFFER_OS']?></td>
                    <td><?php echo $row['NO_OF_ONLINE_COURSES']?></td>
                    <td><?php echo $row['TOTAL_NO_CREDIT_TRANS']?></td>
                    <td><a class="dbutton" href="EditOnlineEducation.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="OnlineEducation.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
                </tr>
                <?php
                    }
                    ?>                            
                </tbody>
            </table>
        </div>
        </div>
    </div>
<?php
require "footer.php";
?>          