<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
    
if (isset($_POST['submit'])) {
    $p_name = $_POST['p_name'];

    // Fetch PROGRAM_CODE from program_master based on PROGRAM_NAME
    $select_query = "SELECT `PROGRAM_CODE` FROM `program_master` WHERE `PROGRAM_NAME` = '$p_name'";
    $result = mysqli_query($conn, $select_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $p_code = $row['PROGRAM_CODE'];

            // Your other variables...
            $Roll_No = $_POST['Roll_No'];
            $Student_Name = $_POST['Student_Name'];
            $Company_Name = $_POST['Company_Name'];
            $Designation = $_POST['Designation'];
            $Salary = $_POST['Salary'];
            $Job_Order = $_POST['Job_Order'];

            // Your INSERT query
            $query = "INSERT INTO `salary_details`(`A_YEAR`, `DEPT_ID`, `PROGRAM_CODE`, `PROGRAM_NAME`, `ROLL_NO`, `STUDENT_NAME`, `COMPANY_NAME`, `DESIGNATION`, `SALARY`,`JOB_ORDER`) 
            VALUES ('$A_YEAR', '$dept', '$p_code', '$p_name', '$Roll_No', '$Student_Name', '$Company_Name', '$Designation', '$Salary', '$Job_Order')
            ON DUPLICATE KEY UPDATE
            PROGRAM_CODE = VALUES(PROGRAM_CODE),
            PROGRAM_NAME = VALUES(PROGRAM_NAME),
            ROLL_NO = VALUES(ROLL_NO),
            STUDENT_NAME = VALUES(STUDENT_NAME),
            COMPANY_NAME = VALUES(COMPANY_NAME),
            DESIGNATION = VALUES(DESIGNATION),
            SALARY = VALUES(SALARY),
            JOB_ORDER = VALUES(JOB_ORDER)";

            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Data Entered.')</script>";
                echo '<script>window.location.href = "SalaryDetails.php";</script>';
            } else {
                echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
            }
        } else {
            echo "No matching PROGRAM_CODE found for PROGRAM_NAME: $p_name";
        }
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
}


if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from salary_details where ID = '$id'");
        echo '<script>window.location.href = "SalaryDetails.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 ">Salary Details (Employers)</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        Academic Year
                    </label>
                    <input type="year" name="year" value="<?php echo $A_YEAR?>" class="form-control" disabled>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">
                        Department ID
                    </label>
                    <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" disabled>
                </div>                
                
                <div class="mb-3">
                    <label class="form-label">
                        Program Name
                    </label>
                    <select name="p_name" class="form-control">
                    <?php 
                    $sql = "SELECT * FROM `program_master`";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['PROGRAM_NAME'] == $p_name) {
                            echo '<option selected value="' . $row['PROGRAM_NAME'] . '">' . $row['PROGRAM_NAME'] . '</option>';
                        } else {
                            echo '<option value="' . $row['PROGRAM_NAME'] . '">' . $row['PROGRAM_NAME'] . '</option>';
                        }
                    }
                    ?>
                    </select>
                </div>     

                <div class="mb-3">
                    <label class="form-label">
                        Roll No
                    </label>
                    <input type="number" name="Roll_No" class="form-control" placeholder="Enter the Roll No" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Student Name
                    </label>
                    <input type="text" name="Student_Name" class="form-control" placeholder="Enter the Student Name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Company Name
                    </label>
                    <input type="text" name="Company_Name" class="form-control" placeholder="Enter the Comapny Name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Designation 
                    </label>
                    <input type="text" name="Designation" class="form-control" placeholder="Enter your Designation"required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Salary
                    </label>
                    <input type="number" name="Salary" class="form-control" placeholder="Enter your Salary" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Job Order(Optional)
                    </label>
                    <input type="text" name="Job_Order" class="form-control" placeholder="Enter your Job Order Url">
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
                            <th scope="col">Program Name</th>
                            <th scope="col">Roll No</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Job Order(Optional)</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM salary_details WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['PROGRAM_NAME']?></td>
                    <td><?php echo $row['ROLL_NO']?></td>
                    <td><?php echo $row['STUDENT_NAME']?></td>
                    <td><?php echo $row['COMPANY_NAME']?></td>
                    <td><?php echo $row['DESIGNATION']?></td>
                    <td><?php echo $row['SALARY']?></td>
                    <td><?php echo $row['JOB_ORDER']?></td>
                    <td><a class="dbutton" href="SalaryDetails.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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
       