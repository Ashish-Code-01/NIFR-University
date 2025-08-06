<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
    
if (isset($_POST['submit'])){

    $tot_no_of_sponsored_projects=$_POST['tot_no_of_sponsored_projects'];
    $tot_no_of_sponsored_projects_from_agencies=$_POST['tot_no_of_sponsored_projects_from_agencies'];
    $tot_amount_recieved_from_sponsored_projects_agencies=$_POST['tot_amount_recieved_from_sponsored_projects_agencies'];
    $tot_no_of_sponsored_projects_from_industries=$_POST['tot_no_of_sponsored_projects_from_industries'];
    $tot_amount_recieved_from_sponsored_projects_industries=$_POST['tot_amount_recieved_from_sponsored_projects_industries'];

    $query="INSERT INTO `sponsored_project_details`(`A_YEAR`, `DEPT_ID`, `TOTAL_SPONSORED_PROJECTS`, `TOTAL_SPONSORED_PROJECTS_AGENCIES`, `TOTAL_AMT_RECEIVED_AGENCIES`, `TOTAL_PROJECTS_SPONSORED_INDUSTRIES`, `TOTAL_AMT_RECEIVED_INDUSTRIES`) 
    VALUES ('$A_YEAR', '$dept','$tot_no_of_sponsored_projects','$tot_no_of_sponsored_projects_from_agencies','$tot_amount_recieved_from_sponsored_projects_agencies', '$tot_no_of_sponsored_projects_from_industries', '$tot_amount_recieved_from_sponsored_projects_industries')
    ON DUPLICATE KEY UPDATE
    TOTAL_SPONSORED_PROJECTS = VALUES(TOTAL_SPONSORED_PROJECTS),
    TOTAL_SPONSORED_PROJECTS_AGENCIES = VALUES(TOTAL_SPONSORED_PROJECTS_AGENCIES),
    TOTAL_AMT_RECEIVED_AGENCIES = VALUES(TOTAL_AMT_RECEIVED_AGENCIES),
    TOTAL_PROJECTS_SPONSORED_INDUSTRIES = VALUES(TOTAL_PROJECTS_SPONSORED_INDUSTRIES),
    TOTAL_AMT_RECEIVED_INDUSTRIES = VALUES(TOTAL_AMT_RECEIVED_INDUSTRIES)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "SponsoredProjectDetails.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from sponsored_project_details where ID = '$id'");
        echo '<script>window.location.href = "SponsoredProjectDetails.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 "><b>Sponsored Project Details</b></p>
                </div>
                
                <div class="alert alert-danger align-content-between justify-content-center" role="alert">
                    <h5><b>Important Notes</b></h5>
                    <ul type="dot">
                        <li style="font-weight: 200;"><b>Please make sure that the amount mentioned in various years is actually the amount received during that year and not the sanctioned budget of the project</b></li>
                        <li style="font-weight: 200;"><b>Fellowship / Scholarship amount received should not be included in research funding</b></li>
                        <li style="font-weight: 200;"><b>Under process / consideration projects should not be included in data provided</b></li>
                        <li style="font-weight: 200;"><b>Self-funded(Institute / Society) funded projects should not be included</b></li>
                        <li style="font-weight: 200;"><b>Enter value(s) in all field(s); if not applicable enter zero[0]</b></li>
                        <li style="font-weight: 200;"><b>Sponsored Research & Consultancy projects from well known established companies are to be entered</b></li>
                        <li style="font-weight: 200;"><b>Research funding comming from recognised government agencies / foundations and established companies should only be entered</b></li>
                    </ul>   
                </div>
                
                <div class="d-flex justify-content-center">
                <div class="p-2 flex-fill bd-highlight ml-2">
    
                    <div class="mb-3">
                        <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
                        <input type="text" name="year" value="<?php echo $A_YEAR?>" class="form-control" style="margin-top: 0;" disabled>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
                        <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" style="margin-top: 0;" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Total number of Sponsored Projects in all</b></label>
                        <input type="number" name="tot_no_of_sponsored_projects" class="form-control" placeholder="Enter the total number of sponsored projects recieved in the academic year" style="margin-top: 0;" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Total number of Sponsored Projects from agencies</b></label>
                        <input type="number" name="tot_no_of_sponsored_projects_from_agencies" class="form-control" placeholder="Enter the number of sponsored projects recieved from agencies in the academic year" style="margin-top: 0;" required>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label"><b>Total amount recieved through the sponsored projects recieved from agencies (INR)</b></label>
                        <input type="number" name="tot_amount_recieved_from_sponsored_projects_agencies" class="form-control" placeholder="amount recieved to the department from sponsored projects from the industries in academic year" style="margin-top: 0;" required>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label"><b>Total number of Sponsored Projects from industries</b></label>
                        <input type="number" name="tot_no_of_sponsored_projects_from_industries" class="form-control" placeholder="number of Sponsored Projects from industries" style="margin-top: 0;" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Total amount recieved through the sponsored projects recieved from industries (INR)</b></label>
                        <input type="number" name="tot_amount_recieved_from_sponsored_projects_industries" class="form-control" placeholder="amount recieved to the department from sponsored projects from the industries in academic year" style="margin-top: 0;" required>
                    </div>
                </div>
            </div>

                <input type="submit" class="submit" value="Submit" name="submit" onclick="return Validate()">
            </form>
        </div>

    <!-- Show Entered Data -->
    <div class="row my-5" >
    <h3 class="fs-4 mb-3 text-center" id="msg"><b>You Have Entered the Following Data</b></h3>
        <div class="col ">
            <div class="overflow-auto">
                <table class="table bg-white rounded shadow-sm  table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Academic Year</th>
                            <th scope="col">Total number of Sponsored Projects in all</th>
                            <th scope="col">Total number of Sponsored Projects from agencies</th>
                            <th scope="col">Total amount recieved through the sponsored projects recieved from agencies (INR)</th>
                            <th scope="col">Total number of Sponsored Projects from industries</th>
                            <th scope="col">Total amount recieved through the sponsored projects recieved from industries (INR)</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "Select * from sponsored_project_details");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['TOTAL_SPONSORED_PROJECTS']?></td>
                    <td><?php echo $row['TOTAL_SPONSORED_PROJECTS_AGENCIES']?></td>
                    <td><?php echo $row['TOTAL_AMT_RECEIVED_AGENCIES']?></td>
                    <td><?php echo $row['TOTAL_PROJECTS_SPONSORED_INDUSTRIES']?></td>
                    <td><?php echo $row['TOTAL_AMT_RECEIVED_INDUSTRIES']?></td>
                    <td><a class="dbutton" href="EditSponsoredProjectDetails.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="SponsoredProjectDetails.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
                </tr>
                <?php
                    }
                    ?>                            
                </tbody>
            </table>
        </div>
        </div>
    </div>
<?php
require "footer.php";
?>