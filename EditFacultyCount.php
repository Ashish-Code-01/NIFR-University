<?php
include 'config.php';
require "header.php";

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    // Fetch the existing data for the record
    $query = "SELECT * FROM faculty_count WHERE ID = '$id'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $academic_year = $row['A_YEAR'];
        $male_faculty = $row['NUM_OF_INTERN_MALE_FACULTY'];
        $female_faculty = $row['NUM_OF_INTERN_FEMALE_FACULTY'];
        $other_faculty = $row['NUM_OF_INTERN_OTHER_FACULTY'];
    } else {
        echo "<script>alert('Invalid Record ID');</script>";
        echo '<script>window.location.href = "FacultyCount.php";</script>';
        exit;
    }
}

if (isset($_POST['update'])) {
    $male = $_POST['male_faculty'];
    $female = $_POST['female_faculty'];
    $other = $_POST['other'];

    // Update the record
    $update_query = "UPDATE faculty_count 
                     SET NUM_OF_INTERN_MALE_FACULTY = '$male', 
                         NUM_OF_INTERN_FEMALE_FACULTY = '$female', 
                         NUM_OF_INTERN_OTHER_FACULTY = '$other' 
                     WHERE ID = '$id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Record Updated Successfully');</script>";
        echo '<script>window.location.href = "FacultyCount.php";</script>';
    } else {
        echo "<script>alert('Error: Unable to update record.');</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4"><b>Edit Faculty Count</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
            <input type="text" name="year" value="<?php echo $academic_year; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total number of <span style="color: red;">MALE</span> International Faculty</b></label>
            <input type="number" name="male_faculty" value="<?php echo $male_faculty; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total number of <span style="color: red;">FEMALE</span> International Faculty</b></label>
            <input type="number" name="female_faculty" value="<?php echo $female_faculty; ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total number of <span style="color: red;">OTHER</span> International Faculty</b></label>
            <input type="text" name="other" value="<?php echo $other_faculty; ?>" class="form-control" style="margin-top: 0;"> 
        </div>

        <input type="submit" class="submit" value="Update" name="update">
    </form>
</div>

<?php
require "footer.php";
?>
