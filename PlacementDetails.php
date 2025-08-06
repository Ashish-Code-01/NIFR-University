<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_POST['submit'])) {
    $p_name = $_POST['p_name'];

    // Fetch PROGRAM_CODE from program_master based on PROGRAM_NAME
    $select_query = "SELECT `PROGRAM_CODE` FROM `program_master` WHERE `PROGRAM_NAME` = '$p_name'";
    $result = mysqli_query($conn, $select_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $p_code = $row['PROGRAM_CODE'];

            // Your other variables...
            $no_of_students = $_POST['no_of_students'];
            $no_of_students_late_entry = $_POST['no_of_students_late_entry'];
            $no_of_students_graduted = $_POST['no_of_students_graduted'];
            $no_of_students_placed = $_POST['no_of_students_placed'];
            $no_of_students_higher_studies = $_POST['no_of_students_higher_studies'];

            // Your INSERT query
            $query = "INSERT INTO `placement_details`(`A_YEAR`, `DEPT_ID`, `PROGRAM_CODE`, `PROGRAM_NAME`,`TOTAL_NO_OF_STUDENT`, `NUM_OF_STUDENTS_ADMITTED_LATERAL_ENTRY`, `TOTAL_NUM_OF_STUDENTS_GRADUATED`, `TOTAL_NUM_OF_STUDENTS_PLACED`, `NUM_OF_STUDENTS_IN_HIGHER_STUDIES`) 
            VALUES ('$A_YEAR', '$dept', '$p_code', '$p_name', '$no_of_students', '$no_of_students_late_entry', '$no_of_students_graduted', '$no_of_students_placed', '$no_of_students_higher_studies')
            ON DUPLICATE KEY UPDATE
            TOTAL_NO_OF_STUDENT = VALUES(TOTAL_NO_OF_STUDENT),
            NUM_OF_STUDENTS_ADMITTED_LATERAL_ENTRY = VALUES(NUM_OF_STUDENTS_ADMITTED_LATERAL_ENTRY),
            TOTAL_NUM_OF_STUDENTS_GRADUATED = VALUES(TOTAL_NUM_OF_STUDENTS_GRADUATED),
            TOTAL_NUM_OF_STUDENTS_PLACED = VALUES(TOTAL_NUM_OF_STUDENTS_PLACED),
            NUM_OF_STUDENTS_IN_HIGHER_STUDIES = VALUES(NUM_OF_STUDENTS_IN_HIGHER_STUDIES)";

            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Data Entered.')</script>";
                echo '<script>window.location.href = "PlacementDetails.php";</script>';
            } else {
                echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
            }
        } else {
            echo "No matching PROGRAM_CODE found for PROGRAM_NAME: $p_name";
        }
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
}

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from placement_details where ID = '$id'");
        echo '<script>window.location.href = "PlacementDetails.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 "><b>Placement Details</b></p>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;">Academic Year</label>
                    <input type="text" name="year" value="<?php echo $A_YEAR?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;">Department ID</label>
                    <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;">Program Name</label>
                    <select name="p_name" class="form-control" style="margin-top: 0;">
                    <?php 
                    $sql = "SELECT * FROM `program_master`";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['PROGRAM_NAME'] == $p_name) {
                            echo '<option selected value="' . $row['PROGRAM_NAME'] . '">' . $row['PROGRAM_NAME'] . '</option>';
                        } else {
                            echo '<option value="' . $row['PROGRAM_NAME'] . '">' . $row['PROGRAM_NAME'] . '</option>';
                        }
                    }
                    ?>
                    </select>
                </div>   
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;">Total No. of Students</label>
                    <input type="text" name="no_of_students" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;">No. of Students Admitted through Lateral Entry</label>
                    <input type="text" name="no_of_students_late_entry" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;">No. of Students Graduated (PASSED)</label>
                    <input type="text" name="no_of_students_graduted" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;">No. of Students Placed</label>
                    <input type="text" name="no_of_students_placed" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;">No. of Students in Higher Studies</label>
                    <input type="text" name="no_of_students_higher_studies" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
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
                            <th scope="col">Program Name</th>
                            <th scope="col">Total No. of Students</th>
                            <th scope="col">No. of Students Admitted through Lateral Entry</th>
                            <th scope="col">No. of Students Graduated (PASSED)</th>
                            <th scope="col">No. of Students Placed</th>
                            <th scope="col">No. of Students in Higher Studies</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM placement_details WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['PROGRAM_NAME']?></td>
                    <td><?php echo $row['TOTAL_NO_OF_STUDENT']?></td>
                    <td><?php echo $row['NUM_OF_STUDENTS_ADMITTED_LATERAL_ENTRY']?></td>
                    <td><?php echo $row['TOTAL_NUM_OF_STUDENTS_GRADUATED']?></td>
                    <td><?php echo $row['TOTAL_NUM_OF_STUDENTS_PLACED']?></td>
                    <td><?php echo $row['NUM_OF_STUDENTS_IN_HIGHER_STUDIES']?></td>
                    <td><a class="dbutton" href="EditPlacementDetails.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="PlacementDetails.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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
