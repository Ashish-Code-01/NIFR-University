<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

// Fetch record data to edit
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $result = mysqli_query($conn, "SELECT * FROM academic_peers WHERE ID = '$id' AND DEPT_ID = '$dept'");
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<script>alert('Invalid Record.'); window.location.href = 'AcademicPeers.php';</script>";
        exit();
    }
}

// Update the edited record
if (isset($_POST['update'])) {
    $id = $_POST['ID'];
    $Title = $_POST['Title'];
    $First_Name = $_POST['First_Name'];
    $Last_Name = $_POST['Last_Name'];
    $Job_Title = $_POST['Job_Title'];
    $Institution = $_POST['Institution'];
    $Department = $_POST['Department'];
    $Location = $_POST['Location'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $Type = $_POST['Type'];

    $updateQuery = "UPDATE academic_peers SET 
        TITLE = '$Title',
        FIRST_NAME = '$First_Name',
        LAST_NAME = '$Last_Name',
        JOB_TITLE = '$Job_Title',
        INSTITUTION = '$Institution',
        DEPARTMENT = '$Department',
        LOCATION = '$Location',
        EMAIL_ID = '$Email',
        PHONE = '$Phone',
        TY_PE = '$Type'
        WHERE ID = '$id' AND DEPT_ID = '$dept'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Record Updated Successfully.'); window.location.href = 'AcademicPeers.php';</script>";
    } else {
        echo "<script>alert('Error Updating Record.');</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">

        <div class="mb-3">
            <p class="text-center fs-4"><b>Edit Academic Peer</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Title</b></label>
            <input type="text" name="Title" class="form-control" value="<?php echo $row['TITLE']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>First Name</b></label>
            <input type="text" name="First_Name" class="form-control" value="<?php echo $row['FIRST_NAME']; ?>" style="margin-top: 0;" pattern="[A-Za-z]+" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Last Name</b></label>
            <input type="text" name="Last_Name" class="form-control" value="<?php echo $row['LAST_NAME']; ?>" style="margin-top: 0;" pattern="[A-Za-z]+" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Job Title</b></label>
            <input type="text" name="Job_Title" class="form-control" value="<?php echo $row['JOB_TITLE']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Institution</b></label>
            <input type="text" name="Institution" class="form-control" value="<?php echo $row['INSTITUTION']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Department</b></label>
            <input type="text" name="Department" class="form-control" value="<?php echo $row['DEPARTMENT']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Location</b></label>
            <input type="text" name="Location" class="form-control" value="<?php echo $row['LOCATION']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Email</b></label>
            <input type="email" name="Email" class="form-control" value="<?php echo $row['EMAIL_ID']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Phone</b></label>
            <input type="text" name="Phone" class="form-control" value="<?php echo $row['PHONE']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Type</b></label>
            <select name="Type" class="form-control" style="margin-top: 0;">
                <option value="INDIAN" <?php if ($row['TY_PE'] == 'INDIAN') echo 'selected'; ?>>INDIAN</option>
                <option value="FOREIGN" <?php if ($row['TY_PE'] == 'FOREIGN') echo 'selected'; ?>>FOREIGN</option>
            </select>
        </div>

        <input type="submit" class="submit" value="Update" name="update">
    </form>
</div>

<?php
require "footer.php";
?>
