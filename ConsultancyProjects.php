<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
    
if (isset($_POST['submit'])){

    $tot_no_of_consultancy_projects=$_POST['tot_no_of_consultancy_projects'];
    $tot_no_of_clients=$_POST['tot_no_of_clients'];
    $tot_amount_recieved=$_POST['tot_amount_recieved'];

    $query="INSERT INTO `consultancy_projects`(`A_YEAR`, `DEPT_ID`, `TOTAL_NO_OF_CP`, `TOTAL_NO_OF_CLIENT`, `TOTAL_AMT_RECEIVED`) 
    VALUES ('$A_YEAR', '$dept','$tot_no_of_consultancy_projects','$tot_no_of_clients','$tot_amount_recieved')
    ON DUPLICATE KEY UPDATE
    TOTAL_NO_OF_CP = VALUES(TOTAL_NO_OF_CP),
    TOTAL_NO_OF_CLIENT = VALUES(TOTAL_NO_OF_CLIENT),
    TOTAL_AMT_RECEIVED = VALUES(TOTAL_AMT_RECEIVED)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "ConsultancyProjects.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from consultancy_projects where ID = '$id'");
        echo '<script>window.location.href = "ConsultancyProjects.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 "><b>Consultancy Projects</b></p>
                </div>
                
                <!-- The Instructions -->
                <div class="alert alert-danger align-content-between justify-content-center" role="alert">
                    <h5><b>Important Notes:</b></h5>
                    <ul type="dot">
                        <li style="font-weight:200;"><b>Please make sure that the amount mentioned in various years is actually the amount received during that year and not sanctioned budget of the project</b></li>
                        <li style="font-weight:200;"><b>Self-Sponsored Consultancy projects(Institute / Society) should not be counted and entered</b></li>
                        <li style="font-weight:200;"><b>Enter value(s) in all field(s); if not applicable enter zero[0]</b></li>
                        <li style="font-weight:200;"><b>Sponsored Research& Consultancy projects from well known established companies are to be entered</b></li>
                        <li style="font-weight:200;"><b>Consultancy other than your institution should only be entered and consultancy of any sister institution shall not be entered</b></li>
                    </ul>   
                </div>
                
                <div class="mb-3">
                        <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
                        <input type="text" name="year" value="<?php echo $A_YEAR?>" class="form-control" style="margin-top: 0;" disabled>
                    </div> 
                    <div class="mb-3">
                        <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
                        <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" style="margin-top: 0;" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="margin-bottom: 6px;"><b>Total number of consultancy projects</b></label>
                        <input type="number" name="tot_no_of_consultancy_projects" class="form-control" placeholder="Enter the number of consultancy projects done in the academic year" style="margin-top: 0;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="margin-bottom: 6px;"><b>Total number of Clients for the consultancy projects</b></label>
                        <input type="number" name="tot_no_of_clients" class="form-control" placeholder="Enter the number of clients recieved for the consultancy projects done in the academic year" style="margin-top: 0;" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" style="margin-bottom: 6px;"><b>Total amount recieved through the consultancy projects</b></label>
                        <input type="number" name="tot_amount_recieved" class="form-control" placeholder="amount recieved to the department from consultancy projects done in the academic year" style="margin-top: 0;" required>
                    </div>
                    
                <input type="submit" class="submit" value="Submit" name="submit" onclick="return Validate()">
            </form>
        </div>

         <!-- Show Entered Data -->
    <div class="row my-5" >
    <h3 class="fs-4 mb-3 text-center" id="msg"><b></b>You Have Entered the Following Data</h3>
        <div class="col ">
            <div class="overflow-auto">
                <table class="table bg-white rounded shadow-sm  table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Academic Year</th>
                            <th scope="col">Total number of consultancy projects</th>
                            <th scope="col">Total number of Clients for the consultancy projects</th>
                            <th scope="col">Total amount recieved through the consultancy projects</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM consultancy_projects WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['TOTAL_NO_OF_CP']?></td>
                    <td><?php echo $row['TOTAL_NO_OF_CLIENT']?></td>
                    <td><?php echo $row['TOTAL_AMT_RECEIVED']?></td>
                    <td><a class="dbutton" href="EditConsultancyProjects.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="ConsultancyProjects.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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





