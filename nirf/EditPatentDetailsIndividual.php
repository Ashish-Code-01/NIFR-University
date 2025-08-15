<?php
include 'config.php';
require "header.php";

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    // Fetch existing data for the given ID
    $result = mysqli_query($conn, "SELECT * FROM patent_details WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<script>alert('Invalid Record ID'); window.location.href = 'PatentDetailsIndividual.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No Record Selected'); window.location.href = 'PatentDetailsIndividual.php';</script>";
    exit;
}

// Update logic
if (isset($_POST['update'])) {
    $patent_application_number = $_POST['patent_application_number'];
    $status_of_patent = $_POST['status_of_patent'];
    $Inventors_name = $_POST['Inventors_name'];
    $Title_of_the_patent = $_POST['Title_of_the_patent'];
    $Applicant_Name = $_POST['Applicant_Name'];
    $Patent_Filed = $_POST['Patent_Filed'];
    $Patent_published_date = $_POST['Patent_published_date'];
    $Patent_granted_date = $_POST['Patent_granted_date'];
    $Patent_publication_number = $_POST['Patent_publication_number'];
    $Assignee_Name = $_POST['Assignee_Name'];
    $URL = $_POST['URL'];

    $update_query = "UPDATE `patent_details` 
                     SET 
                         PATENT_APPLICATION_NO = '$patent_application_number',
                         STATUS_OF_PATENT = '$status_of_patent',
                         INVENTOR_NAME = '$Inventors_name',
                         TITLE_OF_PATENT = '$Title_of_the_patent',
                         APPLICANT_NAME = '$Applicant_Name',
                         PATENT_FILED_DATE = '$Patent_Filed',
                         PATENT_PUBLISHED_DATE = '$Patent_published_date',
                         PATENT_GRANTED_DATE = '$Patent_granted_date',
                         PATENT_PUBLICATION_NUMBER = '$Patent_publication_number',
                         ASIGNEES_NAME = '$Assignee_Name',
                         URL = '$URL'
                     WHERE ID = '$id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Record Updated Successfully'); window.location.href = 'PatentDetailsIndividual.php';</script>";
    } else {
        echo "<script>alert('Update Failed: Contact Admin');</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4"><b>Edit Patent Details</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Patent Application Number</b></label>
            <input type="text" name="patent_application_number" class="form-control" value="<?php echo $row['PATENT_APPLICATION_NO']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Status of Patent</b></label>
            <select name="status_of_patent" class="form-control">
                <option value="FILED" <?php if ($row['STATUS_OF_PATENT'] == 'FILED') echo 'selected'; ?>>FILED</option>
                <option value="GRANTED" <?php if ($row['STATUS_OF_PATENT'] == 'GRANTED') echo 'selected'; ?>>GRANTED</option>
                <option value="PUBLISHED" <?php if ($row['STATUS_OF_PATENT'] == 'PUBLISHED') echo 'selected'; ?>>PUBLISHED</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Inventor's Name</b></label>
            <input type="text" name="Inventors_name" class="form-control" value="<?php echo $row['INVENTOR_NAME']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Title of the Patent</b></label>
            <input type="text" name="Title_of_the_patent" class="form-control" value="<?php echo $row['TITLE_OF_PATENT']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Applicant Name</b></label>
            <input type="text" name="Applicant_Name" class="form-control" value="<?php echo $row['APPLICANT_NAME']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Patent Filed Date</b></label>
            <input type="date" name="Patent_Filed" class="form-control" value="<?php echo $row['PATENT_FILED_DATE']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Patent Published Date</b></label>
            <input type="date" name="Patent_published_date" class="form-control" value="<?php echo $row['PATENT_PUBLISHED_DATE']; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Patent Granted Date</b></label>
            <input type="date" name="Patent_granted_date" class="form-control" value="<?php echo $row['PATENT_GRANTED_DATE']; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Patent Publication Number</b></label>
            <input type="number" name="Patent_publication_number" class="form-control" value="<?php echo $row['PATENT_PUBLICATION_NUMBER']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Assignee's Name</b></label>
            <input type="text" name="Assignee_Name" class="form-control" value="<?php echo $row['ASIGNEES_NAME']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>URL</b></label>
            <input type="text" name="URL" class="form-control" value="<?php echo $row['URL']; ?>" required>
        </div>

        <input type="submit" class="submit" value="Update" name="update">
    </form>
</div>

<?php
require "footer.php";
?>
