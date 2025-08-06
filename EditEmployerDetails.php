<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
    
if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    // Fetch existing data for editing
    $sql = "SELECT * FROM employers_details WHERE ID = '$id' AND DEPT_ID = '$dept'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Populate the form with existing data
        $First_Name = $row['FIRST_NAME'];
        $Last_Name = $row['LAST_NAME'];
        $Designation = $row['DESIGNATION'];
        $Type_of_Industry = $row['TYPE_OF_INDUSTRY'];
        $Company = $row['COMPANY'];
        $Location = $row['LOCATION'];
        $Email_ID = $row['EMAIL_ID'];
        $Phone_Number = $row['PHONE'];
        $type = $row['TYPE_INDIAN_FOREIGN'];
    } else {
        echo "<script>alert('Record not found.');</script>";
        echo '<script>window.location.href = "EmployerDetails.php";</script>';
    }
}

if (isset($_POST['submit'])) {
    $First_Name = $_POST['First_Name'];
    $Last_Name = $_POST['Last_Name'];
    $Designation = $_POST['Designation'];
    $Type_of_Industry = $_POST['Type_of_Industry'];
    $Company = $_POST['Company'];
    $Location = $_POST['Location'];
    $Email_ID = $_POST['Email_ID'];
    $Phone_Number = $_POST['Phone_Number'];
    $type = $_POST['type'];

    // Update existing data
    $query = "UPDATE employers_details SET 
                FIRST_NAME = '$First_Name',
                LAST_NAME = '$Last_Name',
                DESIGNATION = '$Designation',
                TYPE_OF_INDUSTRY = '$Type_of_Industry',
                COMPANY = '$Company',
                LOCATION = '$Location',
                EMAIL_ID = '$Email_ID',
                PHONE = '$Phone_Number',
                TYPE_INDIAN_FOREIGN = '$type'
              WHERE ID = '$id' AND DEPT_ID = '$dept'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Updated.')</script>";
        echo '<script>window.location.href = "EmployerDetails.php";</script>';
    } else {
        echo "<script>alert('Error updating data.')</script>";
    }
}

?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Edit Employer Details</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
            <input type="text" name="year" value="<?php echo $A_YEAR ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
            <input type="text" name="dpt_id" value="<?php echo $dept ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>First Name</b></label>
            <input type="text" name="First_Name" class="form-control" value="<?php echo $First_Name ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Last Name</b></label>
            <input type="text" name="Last_Name" class="form-control" value="<?php echo $Last_Name ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Designation</b></label>
            <input type="text" name="Designation" class="form-control" value="<?php echo $Designation ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Type of Industry</b></label>
            <input type="text" name="Type_of_Industry" class="form-control" value="<?php echo $Type_of_Industry ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Company</b></label>
            <input type="text" name="Company" class="form-control" value="<?php echo $Company ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Location</b></label>
            <input type="text" name="Location" class="form-control" value="<?php echo $Location ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Email ID</b></label>
            <input type="email" name="Email_ID" class="form-control" value="<?php echo $Email_ID ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Phone Number</b></label>
            <input type="number" name="Phone_Number" class="form-control" value="<?php echo $Phone_Number ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Type (Indian/Foreign)</b></label>
            <select name="type" class="form-control" style="margin-top: 0;">
                <option value="Indian" <?php echo ($type == 'Indian') ? 'selected' : ''; ?>>Indian</option>
                <option value="Foreign" <?php echo ($type == 'Foreign') ? 'selected' : ''; ?>>Foreign</option>
            </select>
        </div>

        <input type="submit" class="submit" value="Update" name="submit">
    </form>
</div>

<?php
require "footer.php";
?>
