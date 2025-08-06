<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
    
if (isset($_POST['submit'])){

    $Executive_Programs=$_POST['Executive_Programs'];
    $Total_Participants=$_POST['Total_Participants'];
    $Total_Income=$_POST['Total_Income'];

    $query="INSERT INTO `exec_dev`(`A_YEAR`, `DEPT_ID`, `NO_OF_EXEC_PROGRAMS`, `TOTAL_PARTICIPANTS`, `TOTAL_INCOME`) 
    VALUES ('$A_YEAR', '$dept','$Executive_Programs','$Total_Participants','$Total_Income')
    ON DUPLICATE KEY UPDATE
    NO_OF_EXEC_PROGRAMS = VALUES(NO_OF_EXEC_PROGRAMS),
    TOTAL_PARTICIPANTS = VALUES(TOTAL_PARTICIPANTS),
    TOTAL_INCOME = VALUES(TOTAL_INCOME)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "ExecutiveDevelopment.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from exec_dev where ID = '$id'");
        echo '<script>window.location.href = "ExecutiveDevelopment.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 ">Executive Development</p>
                </div>

                <!-- The Instructions -->
                <div class="alert alert-danger align-content-between justify-content-center" role="alert">
                    <h5>Important Notes:</h5>
                    <ul type="dot">
                        <li style="font-weight:200;">No bachelors programme should be counted and entered</li>
                        <li style="font-weight:200;">Amount received should not include Lodging and Boarding Charges</li>
                        <li style="font-weight:200;">The amount mentioned for various year is total amount received through executive education programmes for that particular year</li>
                        <li style="font-weight:200;">Enter value(s) in all field(s);if not applicable enter zero[0]</li>
                        <li style="font-weight:200;">Faculty Development Programms shall not be entered</li>
                    </ul>   
                </div>
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
                        Number of Executive Programs
                    </label>
                    <input type= number name="Executive_Programs" class="form-control" placeholder="Enter Count" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        Total Participants
                    </label>
                    <input type= number name="Total_Participants" class="form-control" placeholder="Enter count" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        Total Income	
                    </label>
                    <input type= number name="Total_Income" class="form-control" placeholder="Enter count" required>
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
                            <th scope="col">Number of Executive Programs</th>
                            <th scope="col">Total Participants</th>
                            <th scope="col">Total Income</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM exec_dev WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['NO_OF_EXEC_PROGRAMS']?></td>
                    <td><?php echo $row['TOTAL_PARTICIPANTS']?></td>
                    <td><?php echo $row['TOTAL_INCOME']?></td>
                    <td><a class="dbutton" href="ExecutiveDevelopment.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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

