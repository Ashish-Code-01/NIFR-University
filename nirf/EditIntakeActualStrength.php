<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
error_reporting(0);

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $query = "SELECT * FROM intake_actual_strength WHERE ID = '$id'";
    $result = mysqli_query($conn, $query);
    $intake_detail = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    $p_name = $_POST['p_name'];
    $query = "SELECT `PROGRAM_CODE` FROM `program_master` WHERE `PROGRAM_NAME` = '$p_name'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $p_code = $row['PROGRAM_CODE'];

            // Your other variables...
            $Student_Intake = $_POST['Add_Total_Student_Intake'];
            $Male_Students = $_POST['Total_number_of_Male_Students'];
            $Female_Students = $_POST['Total_number_of_Female_Students'];
            $Male_Students_within_state = $_POST['Total_number_of_Male_Students_within_state'];
            $Female_Students_within_state = $_POST['Total_number_of_Female_Students_within_state'];
            $Male_Students_outside_state = $_POST['Male_Students_outside_state'];
            $Female_Students_outside_state = $_POST['Female_Students_outside_state'];
            $Male_Students_outside_country = $_POST['Male_Students_outside_country'];
            $Female_Students_outside_country = $_POST['Female_Students_outside_country'];
            $Male_Students_Economic_Backward = $_POST['Male_Students_Economic_Backward'];
            $Female_Students_Economic_Backward = $_POST['Female_Students_Economic_Backward'];
            $Male_Students_Social_Backward = $_POST['Male_Students_Social_Backward'];
            $Female_Student_Social_Backward = $_POST['Female_Student_Social_Backward'];
            $Male_Students_Receiving_scholarship_from_Government = $_POST['Male_Students_Receiving_scholarship_from_Government'];
            $Female_Students_Receiving_scholarship_from_Government = $_POST['Female_Students_Receiving_scholarship_from_Government'];
            $Male_Students_Receiving_scholarship_from_Institution = $_POST['Male_Students_Receiving_scholarship_from_Institution'];
            $Female_Students_Receiving_scholarship_from_Institution = $_POST['Female_Students_Receiving_scholarship_from_Institution'];
            $Male_Students_Receiving_scholarship_from_private_Bodies = $_POST['Male_Students_Receiving_scholarship_from_private_Bodies'];
            $Female_Students_Receiving_scholarship_from_private_Bodies = $_POST['Female_Students_Receiving_scholarship_from_private_Bodies'];

            $update_query = "UPDATE `intake_actual_strength` SET 
                `A_YEAR` = '$A_YEAR', 
                `DEPT_ID` = '$dept', 
                `PROGRAM_CODE` = '$p_code', 
                `PROGRAM_NAME` = '$p_name', 
                `NO_STUDENT_INTAKE` = '$Student_Intake', 
                `NO_MALE_STUDENT` = '$Male_Students', 
                `NO_FEMALE_STUDENT` = '$Female_Students', 
                `NO_STUDENT_WITHIN_STATE_MALE` = '$Male_Students_within_state', 
                `NO_STUDENT_WITHIN_STATE_FEMALE` = '$Female_Students_within_state', 
                `NO_STUDENT_OUTSIDE_STATE_MALE` = '$Male_Students_outside_state', 
                `NO_STUDENT_OUTSIDE_STATE_FEMALE` = '$Female_Students_outside_state', 
                `NO_STUDENT_OUTSIDE_COUNTRY_MALE` = '$Male_Students_outside_country', 
                `NO_STUDENT_OUTSIDE_COUNTRY_FEMALE` = '$Female_Students_outside_country', 
                `NO_STUDENT_ECONOMIC_BACKWARD_MALE` = '$Male_Students_Economic_Backward', 
                `NO_STUDENT_ECONOMIC_BACKWARD_FEMALE` = '$Female_Students_Economic_Backward', 
                `NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE` = '$Male_Students_Social_Backward', 
                `NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE` = '$Female_Student_Social_Backward', 
                `NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE` = '$Male_Students_Receiving_scholarship_from_Government', 
                `NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE` = '$Female_Students_Receiving_scholarship_from_Government', 
                `NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE` = '$Male_Students_Receiving_scholarship_from_Institution', 
                `NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE` = '$Female_Students_Receiving_scholarship_from_Institution', 
                `NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE` = '$Male_Students_Receiving_scholarship_from_private_Bodies', 
                `NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE` = '$Female_Students_Receiving_scholarship_from_private_Bodies' 
            WHERE ID = '$id'";

            if (mysqli_query($conn, $update_query)) {
                echo "<script>alert('Data Updated.')</script>";
                echo '<script>window.location.href = "IntakeActualStrength.php";</script>';
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
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Edit Intake & Actual Strength</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Academic Year</label>
            <input type="text" name="year" value="<?php echo $A_YEAR; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Department ID</label>
            <input type="text" name="dpt_id" value="<?php echo $dept; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Program Name</label>
            <select name="p_name" class="form-control" style="margin-top: 0;">
                <?php 
                $sql = "SELECT * FROM `program_master`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['PROGRAM_NAME'] == $intake_detail['PROGRAM_NAME']) {
                        echo '<option selected value="' . $row['PROGRAM_NAME'] . '">' . $row['PROGRAM_NAME'] . '</option>';
                    } else {
                        echo '<option value="' . $row['PROGRAM_NAME'] . '">' . $row['PROGRAM_NAME'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total Number of Students Intake</label>
            <input type="number" name="Add_Total_Student_Intake" value="<?php echo $intake_detail['NO_STUDENT_INTAKE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students</label>
            <input type="number" name="Total_number_of_Male_Students" value="<?php echo $intake_detail['NO_MALE_STUDENT']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students</label>
            <input type="number" name="Total_number_of_Female_Students" value="<?php echo $intake_detail['NO_FEMALE_STUDENT']; ?>" class="form-control" style="margin-top: 0 ;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students within state</label>
            <input type="number" name="Total_number_of_Male_Students_within_state" value="<?php echo $intake_detail['NO_STUDENT_WITHIN_STATE_MALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students within state</label>
            <input type="number" name="Total_number_of_Female_Students_within_state" value="<?php echo $intake_detail['NO_STUDENT_WITHIN_STATE_FEMALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students outside state</label>
            <input type="number" name="Male_Students_outside_state" value="<?php echo $intake_detail['NO_STUDENT_OUTSIDE_STATE_MALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students outside state</label>
            <input type="number" name="Female_Students_outside_state" value="<?php echo $intake_detail['NO_STUDENT_OUTSIDE_STATE_FEMALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students outside country</label>
            <input type="number" name="Male_Students_outside_country" value="<?php echo $intake_detail['NO_STUDENT_OUTSIDE_COUNTRY_MALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students outside country</label>
            <input type="number" name="Female_Students_outside_country" value="<?php echo $intake_detail['NO_STUDENT_OUTSIDE_COUNTRY_FEMALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students Economically Backward</label>
            <input type="number" name="Male_Students_Economic_Backward" value="<?php echo $intake_detail['NO_STUDENT_ECONOMIC_BACKWARD_MALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students Economically Backward</label>
            <input type="number" name="Female_Students_Economic_Backward" value="<?php echo $intake_detail['NO_STUDENT_ECONOMIC_BACKWARD_FEMALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students Social Backward(SC/ST/OBC)</label>
            <input type="number" name="Male_Students_Social_Backward" value="<?php echo $intake_detail['NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students Social Backward(SC/ST/OBC)</label>
            <input type="number" name="Female_Student_Social_Backward" value="<?php echo $intake_detail['NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students Receiving scholarship from Government</label>
            <input type="number" name="Male_Students_Receiving_scholarship_from_Government" value="<?php echo $intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students Receiving scholarship from Government</label>
            <input type="number" name="Female_Students_Receiving_scholarship_from_Government" value="<?php echo $intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students Receiving scholarship from Institution</label>
            <input type="number" name="Male_Students_Receiving_scholarship_from_Institution" value="<?php echo $intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students Receiving scholarship from Institution</label>
            <input type="number" name="Female_Students_Receiving_scholarship_from_Institution" value="<?php echo $intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students Receiving scholarship from private Bodies</label>
            <input type="number" name="Male_Students_Receiving_scholarship_from_private_Bodies" value="<?php echo $intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students Receiving scholarship from private Bodies</label>
            <input type="number" name="Female_Students_Receiving_scholarship_from_private_Bodies" value="<?php echo $intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE']; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <input type="submit" class="submit" value="Update" name="submit">
    </form>
</div>

<?php
require "footer.php";
?>