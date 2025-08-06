<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $query = "SELECT * FROM consultancy_projects WHERE ID = '$id'";
    $result = mysqli_query($conn, $query);
    $consultancy_project = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    $tot_no_of_consultancy_projects = $_POST['tot_no_of_consultancy_projects'];
    $tot_no_of_clients = $_POST['tot_no_of_clients'];
    $tot_amount_recieved = $_POST['tot_amount_recieved'];

    $query = "UPDATE consultancy_projects SET 
        TOTAL_NO_OF_CP = '$tot_no_of_consultancy_projects',
        TOTAL_NO_OF_CLIENT = '$tot_no_of_clients',
        TOTAL_AMT_RECEIVED = '$tot_amount_recieved'
    WHERE ID = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Updated.')</script>";
        echo '<script>window.location.href = "ConsultancyProjects.php";</script>';
    } else {
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Edit Consultancy Projects</b></p>
        </div>

        <div class="alert alert-danger align-content-between justify-content-center" role="alert">
            <h5><b>Important Notes:</b></h5>
            <ul type="dot">
                <li style="font-weight:200;"><b>Please make sure that the amount mentioned in various years is actually the amount received during that year and not sanctioned budget of the project</b></li>
                <li style="font-weight:200;"><b>Self-Sponsored Consultancy projects (Institute / Society) should not be counted and entered</b></li>
                <li style="font-weight:200;"><b>Enter value(s) in all field(s); if not applicable enter zero[0]</b></li>
                <li style="font-weight:200;"><b>Sponsored Research & Consultancy projects from well-known established companies are to be entered</b></li>
                <li style="font-weight:200;"><b>Consultancy other than your institution should only be entered and consultancy of any sister institution shall not be entered</b></li>
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
            <label class="form-label" style="margin-bottom: 6px;"><b>Total number of consultancy projects</b></label>
            <input type="number" name="tot_no_of_consultancy_projects" class="form-control" value="<?php echo $consultancy_project['TOTAL_NO_OF_CP']; ?>" placeholder="Enter the number of consultancy projects done in the academic year" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Total number of Clients for the consultancy projects</b></label>
            <input type="number" name="tot_no_of_clients" class="form-control" value="<?php echo $consultancy_project['TOTAL_NO_OF_CLIENT']; ?>" placeholder="Enter the number of clients received for the consultancy projects done in the academic year" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class ="form-label" style="margin-bottom: 6px;"><b>Total amount received through the consultancy projects</b></label>
            <input type="number" name="tot_amount_recieved" class="form-control" value="<?php echo $consultancy_project['TOTAL_AMT_RECEIVED']; ?>" placeholder="Amount received to the department from consultancy projects done in the academic year" style="margin-top: 0;" required>
        </div>

        <input type="submit" class="submit" value="Update" name="submit">
    </form>
</div>

<?php
require "footer.php";
?>