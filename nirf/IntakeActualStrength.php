<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_POST['submit'])){
    $p_name = $_POST['p_name'];
    $query = "SELECT `PROGRAM_CODE` FROM `program_master` WHERE `PROGRAM_NAME` = '$p_name'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $p_code = $row['PROGRAM_CODE'];

            // Your other variables... 
            $Student_Intake=$_POST['Add_Total_Student_Intake'];
            $Male_Students=$_POST['Total_number_of_Male_Students'];
            $Female_Students=$_POST['Total_number_of_Female_Students'];
            $Male_Students_within_state=$_POST['Total_number_of_Male_Students_within_state'];
            $Female_Students_within_state=$_POST['Total_number_of_Female_Students_within_state'];
            $Male_Students_outside_state=$_POST['Male_Students_outside_state'];
            $Female_Students_outside_state=$_POST['Female_Students_outside_state'];
            $Male_Students_outside_country=$_POST['Male_Students_outside_country'];
            $Female_Students_outside_country=$_POST['Female_Students_outside_country'];
            $Male_Students_Economic_Backward=$_POST['Male_Students_Economic_Backward'];
            $Female_Students_Economic_Backward=$_POST['Female_Students_Economic_Backward'];
            $Male_Students_Social_Backward=$_POST['Male_Students_Social_Backward'];
            $Female_Student_Social_Backward=$_POST['Female_Student_Social_Backward'];
            $Male_Students_Receiving_scholarship_from_Government=$_POST['Male_Students_Receiving_scholarship_from_Government'];
            $Female_Students_Receiving_scholarship_from_Government=$_POST['Female_Students_Receiving_scholarship_from_Government'];
            $Male_Students_Receiving_scholarship_from_Institution=$_POST['Male_Students_Receiving_scholarship_from_Institution'];
            $Female_Students_Receiving_scholarship_from_Institution=$_POST['Female_Students_Receiving_scholarship_from_Institution'];
            $Male_Students_Receiving_scholarship_from_private_Bodies=$_POST['Male_Students_Receiving_scholarship_from_private_Bodies'];
            $Female_Students_Receiving_scholarship_from_private_Bodies=$_POST['Female_Students_Receiving_scholarship_from_private_Bodies'];
    

            $insert_query = "INSERT INTO `intake_actual_strength`(`A_YEAR`, `DEPT_ID`, `PROGRAM_CODE`, `PROGRAM_NAME`, `NO_STUDENT_INTAKE`, `NO_MALE_STUDENT`, `NO_FEMALE_STUDENT`, `NO_STUDENT_WITHIN_STATE_MALE`, `NO_STUDENT_WITHIN_STATE_FEMALE`, `NO_STUDENT_OUTSIDE_STATE_MALE`, `NO_STUDENT_OUTSIDE_STATE_FEMALE`, `NO_STUDENT_OUTSIDE_COUNTRY_MALE`, `NO_STUDENT_OUTSIDE_COUNTRY_FEMALE`, `NO_STUDENT_ECONOMIC_BACKWARD_MALE`,`NO_STUDENT_ECONOMIC_BACKWARD_FEMALE`, `NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE`, `NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE`) 
            VALUES ('$A_YEAR', '$dept', '$p_code', '$p_name', '$Student_Intake','$Male_Students','$Female_Students','$Male_Students_within_state','$Female_Students_within_state', '$Male_Students_outside_state', '$Female_Students_outside_state', '$Male_Students_outside_country', '$Female_Students_outside_country', '$Male_Students_Economic_Backward', '$Female_Students_Economic_Backward', '$Male_Students_Social_Backward', '$Female_Student_Social_Backward', '$Male_Students_Receiving_scholarship_from_Government', '$Female_Students_Receiving_scholarship_from_Government', '$Male_Students_Receiving_scholarship_from_Institution', '$Female_Students_Receiving_scholarship_from_Institution', '$Male_Students_Receiving_scholarship_from_private_Bodies', '$Female_Students_Receiving_scholarship_from_private_Bodies')
            ON DUPLICATE KEY UPDATE 
            A_YEAR = VALUES(A_YEAR), 
            DEPT_ID = VALUES(DEPT_ID), 
            NO_STUDENT_INTAKE = VALUES(NO_STUDENT_INTAKE), 
            NO_MALE_STUDENT = VALUES(NO_MALE_STUDENT), 
            NO_FEMALE_STUDENT = VALUES(NO_FEMALE_STUDENT),
            NO_STUDENT_WITHIN_STATE_MALE = VALUES(NO_STUDENT_WITHIN_STATE_MALE),
            NO_STUDENT_WITHIN_STATE_FEMALE = VALUES(NO_STUDENT_WITHIN_STATE_FEMALE),
            NO_STUDENT_OUTSIDE_STATE_MALE = VALUES(NO_STUDENT_OUTSIDE_STATE_MALE),
            NO_STUDENT_OUTSIDE_STATE_FEMALE = VALUES(NO_STUDENT_OUTSIDE_STATE_FEMALE),
            NO_STUDENT_OUTSIDE_COUNTRY_MALE = VALUES(NO_STUDENT_OUTSIDE_COUNTRY_MALE),
            NO_STUDENT_OUTSIDE_COUNTRY_FEMALE = VALUES(NO_STUDENT_OUTSIDE_COUNTRY_FEMALE),
            NO_STUDENT_ECONOMIC_BACKWARD_MALE = VALUES(NO_STUDENT_ECONOMIC_BACKWARD_MALE),
            NO_STUDENT_ECONOMIC_BACKWARD_FEMALE = VALUES(NO_STUDENT_ECONOMIC_BACKWARD_FEMALE),
            NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE = VALUES(NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE),
            NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE = VALUES(NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE)";

            if(mysqli_query($conn, $insert_query)){
                echo "<script>alert('Data Entered.')</script>";
                echo '<script>window.location.href = "IntakeActualStrength.php";</script>';
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
        $sql = mysqli_query($conn, "delete from intake_actual_strength where ID = '$id'");
        echo '<script>window.location.href = "IntakeActualStrength.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 ">Intake and Actual Strength </p>
                </div>
                <!-- The Instructions -->
                <div class="alert alert-danger align-content-between justify-content-center" role="alert">
                    <h5>Important Notes:</h5>
                    <ul type="dot">
                        <li style="font-weight:200;">Sanctioned Approved intake of 1st year to be entered</li>
                        <li style="font-weight:200;">Enter value(s) in all field(s);if not applicable enter zero[0]</li>
                        <li style="font-weight:200;">Students counted under socially challenged shall not be counted in economically backward and vice versa</li>
                        <li style="font-weight:200;">Students whose parental income is less than taxable slab shall be considered under economically backward</li>
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
                        Total Number of Students Intake
                    </label>
                    <input type="number" name="Add_Total_Student_Intake" placeholder="Enter Total Student Intake" class="form-control" required>
                </div>   
                <div class="mb-3">
                    <label class="form-label">
                        Total MALE Students 
                    </label>
                    <input type="number" name="Total_number_of_Male_Students" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total FEMALE Students 
                    </label>
                    <input type="number" name="Total_number_of_Female_Students" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total MALE Students within state
                    </label>
                    <input type="number" name="Total_number_of_Male_Students_within_state" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total FEMALE Students within state
                    </label>
                    <input type="number" name="Total_number_of_Female_Students_within_state" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total MALE Students outside state
                    </label>
                    <input type="number" name="Male_Students_outside_state" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total FEMALE Students outside state
                    </label>
                    <input type="number" name="Female_Students_outside_state" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total MALE Students outside country
                    </label>
                    <input type="number" name="Male_Students_outside_country" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total FEMALE Students outside country
                    </label>
                    <input type="number" name="Female_Students_outside_country" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total MALE Students Economically Backward
                    </label>
                    <input type="number" name="Male_Students_Economic_Backward" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total FEMALE Students Economically Backward
                    </label>
                    <input type="number" name="Female_Students_Economic_Backward" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total MALE Students Social Backward(SC/ST/OBC)
                    </label>
                    <input type="number" name="Male_Students_Social_Backward" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total FEMALE Students Social Backward(SC/ST/OBC)
                    </label>
                    <input type="number" name="Female_Student_Social_Backward" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total MALE Students Receiving scholarship from Government
                    </label>
                    <input type="number" name="Male_Students_Receiving_scholarship_from_Government" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total FEMALE Students Receiving scholarship from Government
                    </label>
                    <input type="number" name="Female_Students_Receiving_scholarship_from_Government" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total MALE Students Receiving scholarship from Institution
                    </label>
                    <input type="number" name="Male_Students_Receiving_scholarship_from_Institution" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total FEMALE Students Receiving scholarship from Institution
                    </label>
                    <input type="number" name="Female_Students_Receiving_scholarship_from_Institution" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total MALE Students Receiving scholarship from private Bodies
                    </label>
                    <input type="number" name="Male_Students_Receiving_scholarship_from_private_Bodies" placeholder="Enter Count" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Total FEMALE Students Receiving scholarship from private Bodies
                    </label>
                    <input type="number" name="Female_Students_Receiving_scholarship_from_private_Bodies" placeholder="Enter Count" class="form-control" required>
                </div>
                
                <button type="submit" class="submit" name="submit" onclick="return Validate()">Submit</button>
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
                            <th scope="col">Program Code</th>
                            <th scope="col">Program Name</th>
                            <th scope="col">Number of Students Intake</th>
                            <th scope="col">MALE Students</th>
                            <th scope="col">FEMALE Students</th>
                            <th scope="col">MALE Students within state</th>
                            <th scope="col">FEMALE Students within state</th>
                            <th scope="col">MALE Students outside state</th>
                            <th scope="col">FEMALE Students outside state</th>
                            <th scope="col">MALE Students outside country</th>
                            <th scope="col">FEMALE Students outside country</th>
                            <th scope="col">MALE Students Economic Backward</th>
                            <th scope="col">FEMALE Students Economic Backward</th>
                            <th scope="col">MALE Students Social Backward(SC/ST/OBC)</th>
                            <th scope="col">FEMALE Students Social Backward(SC/ST/OBC)</th>
                            <th scope="col">MALE Students Receiving scholarship from Government</th>
                            <th scope="col">FEMALE Students Receiving scholarship from Government</th>
                            <th scope="col">MALE Students Receiving scholarship from Institution</th>
                            <th scope="col">FEMALE Students Receiving scholarship from Institution</th>
                            <th scope="col">MALE Students Receiving scholarship from private Bodies</th>
                            <th scope="col">FEMALE Students Receiving scholarship from private Bodies</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM intake_actual_strength WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['PROGRAM_CODE']?></td>
                    <td><?php echo $row['PROGRAM_NAME']?></td>
                    <td><?php echo $row['NO_STUDENT_INTAKE']?></td>
                    <td><?php echo $row['NO_MALE_STUDENT']?></td>
                    <td><?php echo $row['NO_FEMALE_STUDENT']?></td>
                    <td><?php echo $row['NO_STUDENT_WITHIN_STATE_MALE']?></td>
                    <td><?php echo $row['NO_STUDENT_WITHIN_STATE_FEMALE']?></td>
                    <td><?php echo $row['NO_STUDENT_OUTSIDE_STATE_MALE']?></td>
                    <td><?php echo $row['NO_STUDENT_OUTSIDE_STATE_FEMALE']?></td>
                    <td><?php echo $row['NO_STUDENT_OUTSIDE_COUNTRY_MALE']?></td>
                    <td><?php echo $row['NO_STUDENT_OUTSIDE_COUNTRY_FEMALE']?></td>
                    <td><?php echo $row['NO_STUDENT_ECONOMIC_BACKWARD_MALE']?></td>
                    <td><?php echo $row['NO_STUDENT_ECONOMIC_BACKWARD_FEMALE']?></td>
                    <td><?php echo $row['NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE']?></td>
                    <td><?php echo $row['NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE']?></td>
                    <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE']?></td>
                    <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE']?></td>
                    <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE']?></td>
                    <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE']?></td>
                    <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE']?></td>
                    <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE']?></td>
                    <td><a class="dbutton" href="IntakeActualStrength.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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