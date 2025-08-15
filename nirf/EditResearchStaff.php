<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    // Fetch the existing record
    $result = mysqli_query($conn, "SELECT * FROM research_staff WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($result);
    
    if (!$row) {
        echo "<script>alert('Record not found.')</script>";
        echo '<script>window.location.href = "ResearchStaff.php";</script>';
        exit;
    }
}

if (isset($_POST['submit'])) {
    $Research_staff_male = $_POST['Research_staff_male'];
    $Research_Staff_Female = $_POST['Research_Staff_Female'];
    $Agency_sponsoring = $_POST['Agency_sponsoring'];
    $Amount_received = $_POST['Amount_received'];

    $query = "UPDATE `research_staff` SET 
        TOTAL_NUM_OF_RESEARCH_STAFF_MALE = '$Research_staff_male',
        TOTAL_NUM_OF_RESEARCH_STAFF_FEMALE = '$Research_Staff_Female',
        AGENCY_SPONSORING = '$Agency_sponsoring',
        AMOUNT_RECEIVED = '$Amount_received'
    WHERE ID = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Updated.')</script>";
        echo '<script>window.location.href = "ResearchStaff.php";</script>';
    } else {
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Edit Research Staff</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
            <input type="text" name="year" value="<?php echo $row['A_YEAR']; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
            <input type="text" name="dpt_id" value="<?php echo $dept; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total Number of Research Staff (Male)</b></label>
            <input type="number" name="Research_staff_male" value="<?php echo $row['TOTAL_NUM_OF_RESEARCH_STAFF_MALE']; ?>" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total Number Of Research Staff (Female)</b></label>
            <input type="number" name="Research_Staff_Female" value="<?php echo $row['TOTAL_NUM_OF_RESEARCH_STAFF_FEMALE']; ?>" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Agency Sponsoring</b></label>
            <input type="text" name="Agency_sponsoring" value="<?php echo $row['AGENCY_SPONSORING']; ?>" class="form-control" placeholder="Enter Agency Sponsoring" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Amount Received</b></label>
            <input type="number" name="Amount_received" value="<?php echo $row['AMOUNT_RECEIVED']; ?>" class="form-control" placeholder="Enter Amount" style="margin-top: 0;" required>
        </div>

        <input type="submit" class="submit" value="Update" name="submit">
    </form>
</div>

<?php
require "footer.php";
?>