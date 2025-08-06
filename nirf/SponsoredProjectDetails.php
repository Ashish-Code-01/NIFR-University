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
                    <p class="text-center fs-4 ">Sponsored Project Details</p>
                </div>
                
                <div class="alert alert-danger align-content-between justify-content-center" role="alert">
                    <h5>Important Notes</h5>
                    <ul type="dot">
                        <li style="font-weight: 200;">Please make sure that the amount mentioned in various years is actually the amount received during that year and not the sanctioned budget of the project</li>
                        <li style="font-weight: 200;">Fellowship / Scholarship amount received should not be included in research funding</li>
                        <li style="font-weight: 200;">Under process / consideration projects should not be included in data provided</li>
                        <li style="font-weight: 200;">Self-funded(Institute / Society) funded projects should not be included </li>
                        <li style="font-weight: 200;">Enter value(s) in all field(s); if not applicable enter zero[0]</li>
                        <li style="font-weight: 200;">Sponsored Research & Consultancy projects from well known established companies are to be entered</li>
                        <li style="font-weight: 200;">Research funding comming from recognised government agencies / foundations and established companies should only be entered</li>
                    </ul>   
                </div>
                
                <div class="d-flex justify-content-center">

                <div class="p-2 flex-fill bd-highlight ml-2">
    
                    <div class="mb-3">
                        <label class="form-label">
                            Academic Year
                        </label>
                        <input type="text" name="year" value="<?php echo $A_YEAR?>" class="form-control" disabled>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">
                            Department ID
                        </label>
                        <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Total number of Sponsored Projects in all
                        </label>
                        <input type="number" name="tot_no_of_sponsored_projects" class="form-control" placeholder="Enter the total number of sponsored projects recieved in the academic year" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Total number of Sponsored Projects from agencies
                        </label>
                        <input type="number" name="tot_no_of_sponsored_projects_from_agencies" class="form-control" placeholder="Enter the number of sponsored projects recieved from agencies in the academic year" required>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">
                            Total amount recieved through the sponsored projects recieved from agencies (INR)
                        </label>
                        <input type="number" name="tot_amount_recieved_from_sponsored_projects_agencies" class="form-control" placeholder="amount recieved to the department from sponsored projects from the industries in academic year" required>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">
                            Total number of Sponsored Projects from industries
                        </label>
                        <input type="number" name="tot_no_of_sponsored_projects_from_industries" class="form-control" placeholder="number of Sponsored Projects from industries" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Total amount recieved through the sponsored projects recieved from industries (INR)
                        </label>
                         <input type="number" name="tot_amount_recieved_from_sponsored_projects_industries" class="form-control" placeholder="amount recieved to the department from sponsored projects from the industries in academic year" required>
                    </div>
                </div>
            </div>

                <input type="submit" class="submit" value="Submit" name="submit" onclick="return Validate()">
            </form>
        </div>

    <!-- Show Entered Data -->
    <div class="row my-5" >
    <h3 class="fs-4 mb-3 text-center" id="msg">You Have Entered the Following Data</h3>
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