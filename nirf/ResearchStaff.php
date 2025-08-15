<?php
include 'config.php';
require "header.php";
    
$dept = $_SESSION['dept_id'];

if (isset($_POST['submit'])){

    $Research_staff_male=$_POST['Research_staff_male'];
    $Research_Staff_Female=$_POST['Research_Staff_Female'];
    $Agency_sponsoring=$_POST['Agency_sponsoring'];
    $Amount_received=$_POST['Amount_received'];

    $query="INSERT INTO `research_staff`(`A_YEAR`, `DEPT_ID`, `TOTAL_NUM_OF_RESEARCH_STAFF_MALE`, `TOTAL_NUM_OF_RESEARCH_STAFF_FEMALE`, `AGENCY_SPONSORING`, `AMOUNT_RECEIVED`) 
    VALUES ('$A_YEAR', '$dept','$Research_staff_male','$Research_Staff_Female','$Agency_sponsoring', '$Amount_received')
    ON DUPLICATE KEY UPDATE
    TOTAL_NUM_OF_RESEARCH_STAFF_MALE = VALUES(TOTAL_NUM_OF_RESEARCH_STAFF_MALE),
    TOTAL_NUM_OF_RESEARCH_STAFF_FEMALE = VALUES(TOTAL_NUM_OF_RESEARCH_STAFF_FEMALE),
    AGENCY_SPONSORING = VALUES(AGENCY_SPONSORING),
    AMOUNT_RECEIVED = VALUES(AMOUNT_RECEIVED)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "ResearchStaff.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from research_staff where ID = '$id'");
        echo '<script>window.location.href = "ResearchStaff.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 "><b>Research Staff</b></p>
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
                    <label class="form-label" style="margin-bottom: 6px;"><b>Total Number of Research Staff (Male)</b></label>
                    <input type= number name="Research_staff_male" class="form-control" placeholder="Enter Count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Total Number Of Research Staff (Female)</b></label>
                    <input type= number name="Research_Staff_Female" class="form-control" placeholder="Enter count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Agency Sponsoring</b></label>
                    <input type= number name="Agency_sponsoring" class="form-control" placeholder="Enter count" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Amount Received</b></label>
                    <input type= number name="Amount_received" class="form-control" placeholder="Enter Amount" style="margin-top: 0;" required>
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
                            <th scope="col">Total Number of Research Staff (Male)</th>
                            <th scope="col">Total Number Of Research Staff (Female)</th>
                            <th scope="col">Agency Sponsoring</th>
                            <th scope="col">Amount Received</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM research_staff WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                   
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['TOTAL_NUM_OF_RESEARCH_STAFF_MALE']?></td>
                    <td><?php echo $row['TOTAL_NUM_OF_RESEARCH_STAFF_FEMALE']?></td>
                    <td><?php echo $row['AGENCY_SPONSORING']?></td>
                    <td><?php echo $row['AMOUNT_RECEIVED']?></td>
                    <td><a class="dbutton" href="EditResearchStaff.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="ResearchStaff.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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

