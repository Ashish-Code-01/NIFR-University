<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $query = "SELECT * FROM exec_dev WHERE ID = '$id'";
    $result = mysqli_query($conn, $query);
    $exec_dev = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    $Executive_Programs = $_POST['Executive_Programs'];
    $Total_Participants = $_POST['Total_Participants'];
    $Total_Income = $_POST['Total_Income'];

    $query = "UPDATE exec_dev SET 
        NO_OF_EXEC_PROGRAMS = '$Executive_Programs',
        TOTAL_PARTICIPANTS = '$Total_Participants',
        TOTAL_INCOME = '$Total_Income'
    WHERE ID = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Updated.')</script>";
        echo '<script>window.location.href = "ExecutiveDevelopment.php";</script>';
    } else {
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Edit Executive Development</b></p>
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
            <label class="form-label" style="margin-bottom: 6px;"><b>Number of Executive Programs</b></label>
            <input type="number" name="Executive_Programs" class="form-control" value="<?php echo $exec_dev['NO_OF_EXEC_PROGRAMS']; ?>" placeholder="Enter Count" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total Participants</b></label>
            <input type="number" name="Total_Participants" class="form-control" value="<?php echo $exec_dev['TOTAL_PARTICIPANTS']; ?>" placeholder="Enter count" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total Income</b></label>
            <input type="number" name="Total_Income" class="form-control" value="<?php echo $exec_dev['TOTAL_INCOME']; ?>" placeholder="Enter count" style="margin-top: 0;" required>
        </div>

        <input type="submit" class="submit" value="Update" name="submit">
    </form>
</div>

<?php
require "footer.php";
?>