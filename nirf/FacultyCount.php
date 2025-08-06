<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];


if (isset($_POST['submit'])){

    $male=$_POST['male_faculty'];
    $female=$_POST['female_faculty'];
    $other=$_POST['other'];

    $query="INSERT INTO `faculty_count`(`A_YEAR`, `DEPT_ID`, `NUM_OF_INTERN_MALE_FACULTY`, `NUM_OF_INTERN_FEMALE_FACULTY`, `NUM_OF_INTERN_OTHER_FACULTY`) 
    VALUES ('$A_YEAR','$dept','$male', '$female', '$other')
    ON DUPLICATE KEY UPDATE
    NUM_OF_INTERN_MALE_FACULTY = VALUES(NUM_OF_INTERN_MALE_FACULTY),
    NUM_OF_INTERN_FEMALE_FACULTY = VALUES(NUM_OF_INTERN_FEMALE_FACULTY),
    NUM_OF_INTERN_OTHER_FACULTY = VALUES(NUM_OF_INTERN_OTHER_FACULTY)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "FacultyCount.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from faculty_count where ID = '$id'");
        echo '<script>window.location.href = "FacultyCount.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 ">Faculty Count</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        Academic Year
                    </label>
                    <input type="text" name="year1" value="<?php echo $A_YEAR?>" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                       Department ID
                    </label>
                    <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total number of<b> MALE </b> International Faculty 
                    </label>
                    <input type="number" name="male_faculty" class="form-control" placeholder="Enter the number of registered international faculty members (male)" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total number of<b> Female </b> International Faculty 
                    </label>
                    <input type="number" name="female_faculty" class="form-control" placeholder="Enter the number of registered international faculty members (female)" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total number of<b> Other </b> International Faculty
                    </label>
                    <input type="Text" name="other" class="form-control" placeholder="Enter the number of registered international faculty members (Other)">
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
                            <th scope="col">Total number of<b> MALE </b> International Faculty</th>
                            <th scope="col">Total number of<b> Female </b> International Faculty </th>
                            <th scope="col">Total number of<b> Other </b> International Faculty</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM faculty_count WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['NUM_OF_INTERN_MALE_FACULTY']?></td>
                    <td><?php echo $row['NUM_OF_INTERN_FEMALE_FACULTY']?></td>
                    <td><?php echo $row['NUM_OF_INTERN_OTHER_FACULTY']?></td>
                    <td><a class="dbutton" href="FacultyCount.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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





