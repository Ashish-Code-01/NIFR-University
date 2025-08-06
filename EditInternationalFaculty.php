<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    // Fetch the existing record
    $result = mysqli_query($conn, "SELECT * FROM inter_faculty WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($result);
    
    if (!$row) {
        echo "<script>alert('Record not found.')</script>";
        echo '<script>window.location.href = "InternationalFaculty.php";</script>';
        exit;
    }
}

if (isset($_POST['submit'])) {
    $Male_Faculty_Inbound = $_POST['Male_Faculty_Inbound'];
    $Female_Faculty_Inbound = $_POST['Female_Faculty_Inbound'];
    $Male_Faculty_Outbound = $_POST['Male_Faculty_Outbound'];
    $Female_Faculty_Outbound = $_POST['Female_Faculty_Outbound'];

    $query = "UPDATE `inter_faculty` SET 
        TOTAL_NO_INBOUND_FAC_MALE = '$Male_Faculty_Inbound',
        TOTAL_NO_INBOUND_FAC_FEMALE = '$Female_Faculty_Inbound',
        TOTAL_NO_OUTBOUND_FAC_MALE = '$Male_Faculty_Outbound',
        TOTAL_NO_OUTBOUND_FAC_FEMALE = '$Female_Faculty_Outbound'
    WHERE ID = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Updated.')</script>";
        echo '<script>window.location.href = "InternationalFaculty.php";</script>';
    } else {
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 ">Edit International Faculty</p>
        </div>
        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
            <input type="text" name="year" value="<?php echo $row['A_YEAR']; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Dept ID</b></label>
            <input type="text" name="dpt_id" value="<?php echo $dept; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total MALE Faculty Inbound</b></label>
            <input type="number" name="Male_Faculty_Inbound" value="<?php echo $row['TOTAL_NO_INBOUND_FAC_MALE']; ?>" class="form-control" placeholder="Enter Total Male Faculty Inbound" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total FEMALE Faculty Inbound</b></label>
            <input type="number" name="Female_Faculty_Inbound" value="<?php echo $row['TOTAL_NO_INBOUND_FAC_FEMALE']; ?>" class="form-control" placeholder="Enter Total Female Faculty Inbound" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total MALE Faculty Outbound</b></label>
            <input type="number" name="Male_Faculty_Outbound" value="<?php echo $row['TOTAL_NO_OUTBOUND_FAC_MALE']; ?>" class="form-control" placeholder="Enter Total Male Faculty Outbound" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total FEMALE Faculty Outbound</b></label>
            <input type="number" name="Female_Faculty_Outbound" value="<?php echo $row['TOTAL_NO_OUTBOUND_FAC_FEMALE']; ?>" class="form-control" placeholder="Enter Total Female Faculty Outbound" style="margin-top: 0;" required>
        </div>

        <input type="submit" class="submit" value="Update" name="submit">
    </form>
</div>

<?php
require "footer.php";
?>