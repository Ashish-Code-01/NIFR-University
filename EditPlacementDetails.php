<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_GET['ID'])) {
    $record_id = $_GET['ID'];

    // Fetch existing data for the given ID
    $query = "SELECT * FROM placement_details WHERE ID = '$record_id' AND DEPT_ID = '$dept'";
    $result = mysqli_query($conn, $query);
    $record = mysqli_fetch_assoc($result);

    if (!$record) {
        echo "<script>alert('Record not found');</script>";
        echo '<script>window.location.href = "PlacementDetails.php";</script>';
        exit;
    }
}

if (isset($_POST['update'])) {
    // Gather updated input data
    $p_name = $_POST['p_name'];
    $total_students = $_POST['total_students'];
    $students_lateral_entry = $_POST['students_lateral_entry'];
    $students_graduated = $_POST['students_graduated'];
    $students_placed = $_POST['students_placed'];
    $students_higher_studies = $_POST['students_higher_studies'];

    // Update query
    $update_query = "UPDATE placement_details SET 
        PROGRAM_NAME = '$p_name', 
        TOTAL_NO_OF_STUDENT = '$total_students',
        NUM_OF_STUDENTS_ADMITTED_LATERAL_ENTRY = '$students_lateral_entry',
        TOTAL_NUM_OF_STUDENTS_GRADUATED = '$students_graduated',
        TOTAL_NUM_OF_STUDENTS_PLACED = '$students_placed',
        NUM_OF_STUDENTS_IN_HIGHER_STUDIES = '$students_higher_studies'
        WHERE ID = '$record_id' AND DEPT_ID = '$dept'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Record updated successfully');</script>";
        echo '<script>window.location.href = "PlacementDetails.php";</script>';
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<div class="div">
    <form method="POST" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4"><b>Edit Placement Details</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Program Name</label>
            <select name="p_name" class="form-control" required>
                <?php
                $sql = "SELECT * FROM program_master";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['PROGRAM_NAME'] == $record['PROGRAM_NAME']) {
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
            <input type="number" name="total_students" value="<?php echo htmlspecialchars($record['TOTAL_NO_OF_STUDENT']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">No. of Students Admitted through Lateral Entry</label>
            <input type="number" name="students_lateral_entry" value="<?php echo htmlspecialchars($record['NUM_OF_STUDENTS_ADMITTED_LATERAL_ENTRY']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">No. of Students Graduated</label>
            <input type="number" name="students_graduated" value="<?php echo htmlspecialchars($record['TOTAL_NUM_OF_STUDENTS_GRADUATED']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">No. of Students Placed</label>
            <input type="number" name="students_placed" value="<?php echo htmlspecialchars($record['TOTAL_NUM_OF_STUDENTS_PLACED']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">No. of Students in Higher Studies</label>
            <input type="number" name="students_higher_studies" value="<?php echo htmlspecialchars($record['NUM_OF_STUDENTS_IN_HIGHER_STUDIES']); ?>" class="form-control" required>
        </div>

        <div class="text-center">
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
