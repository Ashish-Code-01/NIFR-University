<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
    
if (isset($_POST['submit'])){

    $Male_Students_FT=$_POST['Male_Students_FT'];
    $Female_Students_FT=$_POST['Female_Students_FT'];
    $Male_Students_PT=$_POST['Male_Students_PT'];
    $Female_Students_PT=$_POST['Male_Students_PT'];
    $Male_Students_AWD_FT=$_POST['Male_Students_AWD_FT'];
    $Female_Students_AWD_FT=$_POST['Female_Students_AWD_FT'];
    $Male_Students_AWD_PT=$_POST['Male_Students_AWD_PT'];
    $Female_Students_AWD_PT=$_POST['Female_Students_AWD_PT'];

    $query="INSERT INTO `phd_details`(`A_YEAR`, `DEPT_ID`, `FULL_TIME_MALE_STUDENTS`, `FULL_TIME_FEMALE_STUDENTS`, `PART_TIME_MALE_STUDENTS`, `PART_TIME_FEMALE_STUDENTS`, `PHD_AWARDED_MALE_STUDENTS_FULL`, `PHD_AWARDED_FEMALE_STUDENTS_FULL`, `PHD_AWARDED_MALE_STUDENTS_PART`,`PHD_AWARDED_FEMALE_STUDENTS_PART`) 
    VALUES ('$A_YEAR', '$dept','$Male_Students_FT','$Female_Students_FT','$Male_Students_PT', '$Female_Students_PT', '$Male_Students_AWD_FT', '$Female_Students_AWD_FT', '$Male_Students_AWD_PT', '$Female_Students_AWD_PT')
    ON DUPLICATE KEY UPDATE
    FULL_TIME_MALE_STUDENTS = VALUES(FULL_TIME_MALE_STUDENTS),
    FULL_TIME_FEMALE_STUDENTS = VALUES(FULL_TIME_FEMALE_STUDENTS),
    PART_TIME_MALE_STUDENTS = VALUES(PART_TIME_MALE_STUDENTS),
    PART_TIME_FEMALE_STUDENTS = VALUES(PART_TIME_FEMALE_STUDENTS),
    PHD_AWARDED_MALE_STUDENTS_FULL = VALUES(PHD_AWARDED_MALE_STUDENTS_FULL),
    PHD_AWARDED_FEMALE_STUDENTS_FULL = VALUES(PHD_AWARDED_FEMALE_STUDENTS_FULL),
    PHD_AWARDED_MALE_STUDENTS_PART = VALUES(PHD_AWARDED_MALE_STUDENTS_PART),
    PHD_AWARDED_FEMALE_STUDENTS_PART = VALUES(PHD_AWARDED_FEMALE_STUDENTS_PART)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "phd.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from phd_details where ID = '$id'");
        echo '<script>window.location.href = "phd.php";</script>';
    }
}
?>
        <div class="div" >
            <form class="fw-bold" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 "><b>PHD Details</b> </p>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
                    <input type="text" name="year" value="<?php echo $A_YEAR?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3" >
                    <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
                    <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>No. of Male Students (FULL TIME)</b></label>
                    <input type="text" name="Male_Students_FT" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3" >
                    <label class="form-label" style="margin-bottom: 6px;"><b>No. of Female Students (FULL TIME)</b></label>
                    <input type="text" name="Female_Students_FT" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>No. of Male Students (PART TIME)</b></label>
                    <input type="text" name="Male_Students_PT" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>No. of Female Students (PART TIME)</b></label>
                    <input type="text" name="Male_Students_PT" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3" >
                    <label class="form-label" style="margin-bottom: 6px;"><b>No. of Male Students awarded Ph.D. (FULL TIME)</b></label>
                    <input type="text" name="Male_Students_AWD_FT" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>No. of Female Students awarded Ph.D. (FULL TIME)</b></label>
                    <input type="text" name="Female_Students_AWD_FT" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>No. of Male Students awarded Ph.D. (PART TIME)</b></label>
                    <input type="text" name="Male_Students_AWD_PT" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>No. of Female Students awarded Ph.D. (PART TIME)</b></label>
                    <input type="text" name="Female_Students_AWD_PT" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <input type="submit" class="submit" value="Submit" name="submit" onclick="return Validate()">
            </form>
        </div>
        
    <!-- Show Entered Data -->
    <div class="row my-5" >
    <h3 class="fs-4 mb-3 text-center" id="msg">You Have Entered the Following Data</h3>
        <div class="col ">
            <div class="overflow-auto">
                <table class="table bg-white rounded shadow-sm  table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Academic Year</th>
                            <th scope="col">No. of Male Students (FULL TIME)</th>
                            <th scope="col">No. of Female Students (FULL TIME)</th>
                            <th scope="col">No. of Male Students (PART TIME)</th>
                            <th scope="col">No. of Female Students (PART TIME)</th>
                            <th scope="col">No. of Male Students awarded Ph.D. (FULL TIME)</th>
                            <th scope="col">No. of Female Students awarded Ph.D. (FULL TIME)</th>
                            <th scope="col">No. of Male Students awarded Ph.D. (PART TIME)</th>
                            <th scope="col"> No. of Female Students awarded Ph.D. (PART TIME)</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM phd_details WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['FULL_TIME_MALE_STUDENTS']?></td>
                    <td><?php echo $row['FULL_TIME_FEMALE_STUDENTS']?></td>
                    <td><?php echo $row['PART_TIME_MALE_STUDENTS']?></td>
                    <td><?php echo $row['PART_TIME_FEMALE_STUDENTS']?></td>
                    <td><?php echo $row['PHD_AWARDED_MALE_STUDENTS_FULL']?></td>
                    <td><?php echo $row['PHD_AWARDED_FEMALE_STUDENTS_FULL']?></td>
                    <td><?php echo $row['PHD_AWARDED_MALE_STUDENTS_PART']?></td>
                    <td><?php echo $row['PHD_AWARDED_FEMALE_STUDENTS_PART']?></td>
                    <td><a class="dbutton" href="EditPhd.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="phd.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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
