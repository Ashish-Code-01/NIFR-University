<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $query = "SELECT * FROM online_education_details WHERE ID = '$id'";
    $result = mysqli_query($conn, $query);
    $online_education = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    $Portal_Name = $_POST['Portal_Name'];
    $studentsOfferedOnlineCourses = $_POST['studentsOfferedOnlineCourses'];
    $totalonlinecourses = $_POST['totalonlinecourses'];
    $totalnumberofcreditstransfered = $_POST['totalnumberofcreditstransfered'];

    $query = "UPDATE online_education_details SET 
        PORTAL_NAME = '$Portal_Name',
        NO_STUDENT_OFFER_OS = '$studentsOfferedOnlineCourses',
        NO_OF_ONLINE_COURSES = '$totalonlinecourses',
        TOTAL_NO_CREDIT_TRANS = '$totalnumberofcreditstransfered'
    WHERE ID = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Updated.')</script>";
        echo '<script>window.location.href = "OnlineEducation.php";</script>';
    } else {
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Edit Online Education</b></p>
        </div>

        <div class="alert alert-danger align-content-between justify-content-center" role="alert">
            <h5><b>Important Notes</b></h5>
            <ul type="dot">
                <li style="font-weight: 200;"><b>Note: Enter value(s) in all field(s); if not applicable enter zero[0]</b></li>
            </ul>   
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
            <label class="form-label" style="margin-bottom: 6px;"><b>Portal Name</b></label>
            <input type="text" name="Portal_Name" class="form-control" value="<?php echo $online_education['PORTAL_NAME']; ?>" placeholder="Enter Portal Name" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Number Of Students offered Online Courses</b></label>
            <input type="text" name="studentsOfferedOnlineCourses" class="form-control" value="<?php echo $online_education['NO_STUDENT_OFFER_OS']; ?>" placeholder="Enter No of Students offered Online Courses" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total No. of online courses</b></label>
            <input type="text" name="totalonlinecourses" class="form-control" value="<?php echo $online_education['NO_OF_ONLINE_COURSES']; ?>" placeholder="Enter Total No of Online Courses" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total No. Of Credits Transferred</b></label>
            <input type="text" name=" totalnumberofcreditstransfered" class="form-control" value="<?php echo $online_education['TOTAL_NO_CREDIT_TRANS']; ?>" placeholder="Enter Total No of Credits Transferred" style="margin-top: 0;" required>
        </div>

        <input type="submit" class="submit" value="Update" name="submit">
    </form>
</div>

<?php
require "footer.php";
?>