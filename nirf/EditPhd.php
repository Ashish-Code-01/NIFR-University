<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

// Check if the edit action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = $_GET['ID'];
    $query = "SELECT * FROM phd_details WHERE ID = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Pre-fill data for the edit form
        $A_YEAR = $row['A_YEAR'];
        $Male_Students_FT = $row['FULL_TIME_MALE_STUDENTS'];
        $Female_Students_FT = $row['FULL_TIME_FEMALE_STUDENTS'];
        $Male_Students_PT = $row['PART_TIME_MALE_STUDENTS'];
        $Female_Students_PT = $row['PART_TIME_FEMALE_STUDENTS'];
        $Male_Students_AWD_FT = $row['PHD_AWARDED_MALE_STUDENTS_FULL'];
        $Female_Students_AWD_FT = $row['PHD_AWARDED_FEMALE_STUDENTS_FULL'];
        $Male_Students_AWD_PT = $row['PHD_AWARDED_MALE_STUDENTS_PART'];
        $Female_Students_AWD_PT = $row['PHD_AWARDED_FEMALE_STUDENTS_PART'];
    } else {
        echo "<script>alert('Invalid record ID');</script>";
        echo '<script>window.location.href = "phd.php";</script>';
    }
}

// Handle form submission for updating the record
if (isset($_POST['update'])) {
    $Male_Students_FT = $_POST['Male_Students_FT'];
    $Female_Students_FT = $_POST['Female_Students_FT'];
    $Male_Students_PT = $_POST['Male_Students_PT'];
    $Female_Students_PT = $_POST['Female_Students_PT'];
    $Male_Students_AWD_FT = $_POST['Male_Students_AWD_FT'];
    $Female_Students_AWD_FT = $_POST['Female_Students_AWD_FT'];
    $Male_Students_AWD_PT = $_POST['Male_Students_AWD_PT'];
    $Female_Students_AWD_PT = $_POST['Female_Students_AWD_PT'];

    $query = "UPDATE phd_details 
              SET FULL_TIME_MALE_STUDENTS = '$Male_Students_FT', 
                  FULL_TIME_FEMALE_STUDENTS = '$Female_Students_FT', 
                  PART_TIME_MALE_STUDENTS = '$Male_Students_PT', 
                  PART_TIME_FEMALE_STUDENTS = '$Female_Students_PT', 
                  PHD_AWARDED_MALE_STUDENTS_FULL = '$Male_Students_AWD_FT', 
                  PHD_AWARDED_FEMALE_STUDENTS_FULL = '$Female_Students_AWD_FT', 
                  PHD_AWARDED_MALE_STUDENTS_PART = '$Male_Students_AWD_PT', 
                  PHD_AWARDED_FEMALE_STUDENTS_PART = '$Female_Students_AWD_PT'
              WHERE ID = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Record updated successfully');</script>";
        echo '<script>window.location.href = "phd.php";</script>';
    } else {
        echo "<script>alert('Error updating record');</script>";
    }
}
?>
<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4"><b>Edit PHD Details</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
            <input type="text" name="year" value="<?php echo $A_YEAR; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
            <input type="text" name="dpt_id" value="<?php echo $dept; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>No. of Male Students (FULL TIME)</b></label>
            <input type="text" name="Male_Students_FT" value="<?php echo $Male_Students_FT; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>No. of Female Students (FULL TIME)</b></label>
            <input type="text" name="Female_Students_FT" value="<?php echo $Female_Students_FT; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>No. of Male Students (PART TIME)</b></label>
            <input type="text" name="Male_Students_PT" value="<?php echo $Male_Students_PT; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>No. of Female Students (PART TIME)</b></label>
            <input type="text" name="Female_Students_PT" value="<?php echo $Female_Students_PT; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>No. of Male Students awarded Ph.D. (FULL TIME)</b></label>
            <input type="text" name="Male_Students_AWD_FT" value="<?php echo $Male_Students_AWD_FT; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>No. of Female Students awarded Ph.D. (FULL TIME)</b></label>
            <input type="text" name="Female_Students_AWD_FT" value="<?php echo $Female_Students_AWD_FT; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>No. of Male Students awarded Ph.D. (PART TIME)</b></label>
            <input type="text" name="Male_Students_AWD_PT" value="<?php echo $Male_Students_AWD_PT; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>No. of Female Students awarded Ph.D. (PART TIME)</b></label>
            <input type="text" name="Female_Students_AWD_PT" value="<?php echo $Female_Students_AWD_PT; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <input type="submit" class="submit" value="Update" name="update">
        
    </form>
</div>

<?php
require "footer.php";
?>
