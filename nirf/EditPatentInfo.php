<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    // Fetch the existing record
    $result = mysqli_query($conn, "SELECT * FROM patent_info WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($result);
    
    if (!$row) {
        echo "<script>alert('Record not found.')</script>";
        echo '<script>window.location.href = "PatentInfo.php";</script>';
        exit;
    }
}

if (isset($_POST['submit'])) {
    $Patent_Filed_1st_Year = $_POST['Patent_Filed_1st_Year'];
    $Patent_Published_1st_Year = $_POST['Patent_Published_1st_Year'];
    $Patent_Granted_1st_Year = $_POST['Patent_Granted_1st_Year'];
    $Total_Amount_Granted = $_POST['Total_Amount_Granted'];

    $query = "UPDATE `patent_info` SET 
        NO_OF_PATENT_FILLED_1_YEAR = '$Patent_Filed_1st_Year',
        NO_OF_PATENT_PUBLISHED_1_YEAR = '$Patent_Published_1st_Year',
        NO_OF_PATENT_GRANTED_1_YEAR = '$Patent_Granted_1st_Year',
        TOTAL_AMT_GRANTED = '$Total_Amount_Granted'
    WHERE ID = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Updated.')</script>";
        echo '<script>window.location.href = "PatentInfo.php";</script>';
    } else {
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 " style="margin-bottom: 6px;"><b>Edit Patent Info</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
            <input type="text" name="year1" value="<?php echo $row['A_YEAR']; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>
        
        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
            <input type="text" name="dpt_id" value="<?php echo $dept; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>                
        
        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>No of Patent Filed in <?php echo $row['A_YEAR']; ?></b></label>
            <input type="number" name="Patent_Filed_1st_Year" value="<?php echo $row['NO_OF_PATENT_FILLED_1_YEAR']; ?>" class="form-control" placeholder="Enter the No of Patent Filed in <?php echo $row['A_YEAR']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>No of Patent Published in <?php echo $row['A_YEAR']; ?></b></label>
            <input type="number" name="Patent_Published_1st_Year" value="<?php echo $row['NO_OF_PATENT_PUBLISHED_1_YEAR']; ?>" class="form-control" placeholder="Enter the No of Patent Published in <?php echo $row['A_YEAR']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>No of Patent Granted in <?php echo $row['A_YEAR']; ?></b></label>   
            <input type="number" name="Patent_Granted_1st_Year" value="<?php echo $row['NO_OF_PATENT_GRANTED_1_YEAR']; ?>" class="form-control" placeholder="Enter the No of Patent Granted in <?php echo $row['A_YEAR']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total Amount Granted (INR)</b></label>
            <input type="number" name="Total_Amount_Granted" value="<?php echo $row['TOTAL_AMT_GRANTED']; ?>" class="form-control" placeholder="Enter the Total Amount Granted (INR)" style="margin-top: 0;" required>
        </div>

        <input type="submit" class="submit" value="Update" name="submit">
    </form>
</div>

<?php
require "footer.php";
?>