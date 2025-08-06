<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
    
if (isset($_POST['submit'])){

    $Title=$_POST['Title'];
    $First_Name=$_POST['First_Name'];
    $Last_Name=$_POST['Last_Name'];
    $Job_Title=$_POST['Job_Title'];
    $Institution=$_POST['Institution'];
    $Department=$_POST['Department'];
    $Location=$_POST['Location'];
    $Email=$_POST['Email'];
    $Phone=$_POST['Phone'];
    $Type=$_POST['Type'];

    $query="INSERT INTO `academic_peers`(`A_YEAR`, `DEPT_ID`, `TITLE`, `FIRST_NAME`, `LAST_NAME`, `JOB_TITLE`, `INSTITUTION`, `DEPARTMENT`, `LOCATION`, `EMAIL_ID`, `PHONE`, `TY_PE`) 
    VALUES ('$A_YEAR', '$dept','$Title','$First_Name','$Last_Name', '$Job_Title',  '$Institution', '$Department', '$Location', '$Email', '$Phone', '$Type')
    ON DUPLICATE KEY UPDATE
    TITLE = VALUES(TITLE),
    FIRST_NAME = VALUES(FIRST_NAME),
    LAST_NAME = VALUES(LAST_NAME),
    JOB_TITLE = VALUES(JOB_TITLE),
    INSTITUTION = VALUES(INSTITUTION),
    DEPARTMENT = VALUES(DEPARTMENT),
    LOCATION = VALUES(LOCATION),
    EMAIL_ID = VALUES(EMAIL_ID),
    PHONE = VALUES(PHONE),
    TY_PE = VALUES(TY_PE)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "AcademicPeers.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from academic_peers where ID = '$id'");
        echo '<script>window.location.href = "AcademicPeers.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 "><b>Academic Peers</b></p>
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
                    <label class="form-label" style="margin-bottom: 6px;"><b>Title (Salutation)</b></label>
                    <input type="text" name="Title" class="form-control" placeholder="Enter Title [ Dr. (Mr.), Dr. (Mrs.) ]" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>First Name</b></label>
                    <input type="text" name="First_Name" pattern="[A-Za-z]+" class="form-control" placeholder="Enter First Name" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Last Name</b></label>
                    <input type="text" name="Last_Name" pattern="[A-Za-z]+" class="form-control" placeholder="Enter Last Name" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Job Title</b></label>
                    <input type="text" name="Job_Title" class="form-control" placeholder="Enter Job Title" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Institution</b></label>
                    <input type="text" name="Institution" class="form-control" placeholder="Enter Institution" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Department</b></label>
                    <input type="text" name="Department" class="form-control" placeholder="Enter Department" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Location</b></label>
                    <input type="text" name="Location" class="form-control" placeholder="Enter Location" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Email</b></label>
                    <input type="email" name="Email" class="form-control" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" placeholder="Enter Email" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Phone</b></label>
                    <input type="number" name="Phone" class="form-control" placeholder="Enter Phone" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Type</b></label>
                    <select name="Type" class="form-control" style="margin-top: 0;">
                        <option value="INDIAN">INDIAN</option>
                        <option value="FOREIGN">FOREIGN</option>
                    </select>
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
                            <th scope="col">Title</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Job Title</th>
                            <th scope="col">Institution</th>
                            <th scope="col">Department</th>
                            <th scope="col">Location</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Type</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM academic_peers WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['TITLE']?></td>
                    <td><?php echo $row['FIRST_NAME']?></td>
                    <td><?php echo $row['LAST_NAME']?></td>
                    <td><?php echo $row['JOB_TITLE']?></td>
                    <td><?php echo $row['INSTITUTION']?></td>
                    <td><?php echo $row['DEPARTMENT']?></td>
                    <td><?php echo $row['LOCATION']?></td>
                    <td><?php echo $row['EMAIL_ID']?></td>
                    <td><?php echo $row['PHONE']?></td>
                    <td><?php echo $row['TY_PE']?></td>
                    <td><a class="dbutton" href="EditAcademicPeers.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="AcademicPeers.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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