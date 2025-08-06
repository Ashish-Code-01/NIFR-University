<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $query = "SELECT * FROM sponsored_project_details WHERE ID = '$id'";
    $result = mysqli_query($conn, $query);
    $sponsored_project = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    $tot_no_of_sponsored_projects = $_POST['tot_no_of_sponsored_projects'];
    $tot_no_of_sponsored_projects_from_agencies = $_POST['tot_no_of_sponsored_projects_from_agencies'];
    $tot_amount_recieved_from_sponsored_projects_agencies = $_POST['tot_amount_recieved_from_sponsored_projects_agencies'];
    $tot_no_of_sponsored_projects_from_industries = $_POST['tot_no_of_sponsored_projects_from_industries'];
    $tot_amount_recieved_from_sponsored_projects_industries = $_POST['tot_amount_recieved_from_sponsored_projects_industries'];

    $query = "UPDATE sponsored_project_details SET 
        TOTAL_SPONSORED_PROJECTS = '$tot_no_of_sponsored_projects',
        TOTAL_SPONSORED_PROJECTS_AGENCIES = '$tot_no_of_sponsored_projects_from_agencies',
        TOTAL_AMT_RECEIVED_AGENCIES = '$tot_amount_recieved_from_sponsored_projects_agencies',
        TOTAL_PROJECTS_SPONSORED_INDUSTRIES = '$tot_no_of_sponsored_projects_from_industries',
        TOTAL_AMT_RECEIVED_INDUSTRIES = '$tot_amount_recieved_from_sponsored_projects_industries'
    WHERE ID = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Updated.')</script>";
        echo '<script>window.location.href = "SponsoredProjectDetails.php";</script>';
    } else {
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Edit Sponsored Project Details</b></p>
        </div>

        <div class="alert alert-danger align-content-between justify-content-center" role="alert">
            <h5><b>Important Notes</b></h5>
            <ul type="dot">
                <li style="font-weight: 200;"><b>Please make sure that the amount mentioned in various years is actually the amount received during that year and not the sanctioned budget of the project</b></li>
                <li style="font-weight: 200;"><b>Fellowship / Scholarship amount received should not be included in research funding</b></li>
                <li style="font-weight: 200;"><b>Under process / consideration projects should not be included in data provided</b></li>
                <li style="font-weight: 200;"><b>Self-funded ( Institute / Society) funded projects should not be included</b></li>
                <li style="font-weight: 200;"><b>Enter value(s) in all field(s); if not applicable enter zero[0]</b></li>
                <li style="font-weight: 200;"><b>Sponsored Research & Consultancy projects from well-known established companies are to be entered</b></li>
                <li style="font-weight: 200;"><b>Research funding coming from recognized government agencies / foundations and established companies should only be entered</b></li>
            </ul>   
        </div>

        <div class="d-flex justify-content-center">
            <div class="p-2 flex-fill bd-highlight ml-2">
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
                    <input type="text" name="year" value="<?php echo $A_YEAR; ?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
                    <input type="text" name="dpt_id" value="<?php echo $dept; ?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Total number of Sponsored Projects in all</b></label>
                    <input type="number" name="tot_no_of_sponsored_projects" class="form-control" value="<?php echo $sponsored_project['TOTAL_SPONSORED_PROJECTS']; ?>" placeholder="Enter the total number of sponsored projects received in the academic year" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Total number of Sponsored Projects from agencies</b></label>
                    <input type="number" name="tot_no_of_sponsored_projects_from_agencies" class="form-control" value="<?php echo $sponsored_project['TOTAL_SPONSORED_PROJECTS_AGENCIES']; ?>" placeholder="Enter the number of sponsored projects received from agencies in the academic year" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Total amount received through the sponsored projects received from agencies (INR)</b></label>
                    <input type="number" name="tot_amount_recieved_from_sponsored_projects_agencies" class="form-control" value="<?php echo $sponsored_project['TOTAL_AMT_RECEIVED_AGENCIES']; ?>" placeholder="Amount received to the department from sponsored projects from the agencies in academic year" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Total number of Sponsored Projects from industries</b></label>
                    <input type="number" name="tot_no_of_sponsored_projects_from_industries" class="form-control" value="<?php echo $sponsored_project['TOTAL_PROJECTS_SPONSORED_INDUSTRIES']; ?>" placeholder="Number of Sponsored Projects from industries" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Total amount received through the sponsored projects received from industries (INR)</b></label>
                    <input type="number" name="tot_amount_recieved_from_sponsored_projects_industries" class="form-control" value="<?php echo $sponsored_project['TOTAL_AMT_RECEIVED_INDUSTRIES']; ?>" placeholder="Amount received to the department from sponsored projects from the industries in academic year" style="margin-top: 0;" required>
                </div>
            </div>
        </div>

        <input type="submit" class="submit" value="Update" name="submit">
    </form>
</div>

<?php
require "footer.php";
?>