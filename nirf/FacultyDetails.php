<?php
include 'config.php';
require "header.php";
    
$dept = $_SESSION['dept_id'];

if (isset($_POST['submit'])){

    $Faculty_Name=$_POST['Faculty_Name'];
    $gender=$_POST['gender'];
    $designation=$_POST['designation'];
    $DOB=$_POST['DOB'];
    $Age=$_POST['Age'];
    $qualification=$_POST['qualification'];
    $experience=$_POST['experience'];
    $pan_number=$_POST['pan_number'];
    $Associated=$_POST['Associated'];
    $Teaching=$_POST['Teaching'];
    $Industrial=$_POST['Industrial'];
    $Date_of_joining=$_POST['Date_of_joining'];
    $latest_joining=$_POST['latest_joining'];
    $Association_Type=$_POST['Association_Type'];
    $EmailID_of_Faculty=$_POST['EmailID_of_Faculty'];
    $Mobile_Number_of_Faculty=$_POST['Mobile_Number_of_Faculty'];
    $Name_of_Award=$_POST['Name_of_Award'];
    $Level_of_Award=$_POST['Level_of_Award'];
    $Name_of_Award_Agency=$_POST['Name_of_Award_Agency'];
    $Address_of_Award_Agency=$_POST['Address_of_Award_Agency'];
    $Year_of_Received_Award=$_POST['Year_of_Received_Award'];
    $EmailID_of_Agency=$_POST['EmailID_of_Agency'];
    $Contact_of_Agency=$_POST['Contact_of_Agency'];

    $query="INSERT INTO `faculty_details`(`A_YEAR`, `DEPT_ID`, `FACULTY_NAME`, `GENDER`, `DESIGNATION`, `DOB`, `AGE`, `QUALIF`, `EXPERIENCE`, `PAN_NUM`, `FACULTY_ASSO_IN_PREV_YEAR`, `FACULTY_EXP_TEACHING`, `FACULTY_EXP_INDUSTRIAL`, `JOINING_INSTITUTE_DATE`, `LATEST_DATE`, `ASSOC_TYPE`, `EMAIL_ID`, `MOBILE_NUM`, `NAME_OF_AWARD`, `LEVEL_OF_AWARD`, `NAME_OF_AWARD_AGENCY`, `ADD_OF_AWARD_AGENCY`, `YEAR_OF_RECEIVED_AWARD`, `EMAIL_OF_AGENCY`, `CONTACT_OF_AGENCY`) 
    VALUES ('$A_YEAR', '$dept','$Faculty_Name','$gender','$designation', '$DOB', '$Age','$qualification','$experience','$pan_number', '$Associated', '$Teaching', '$Industrial','$Date_of_joining','$latest_joining','$Association_Type', '$EmailID_of_Faculty', '$Mobile_Number_of_Faculty','$Name_of_Award','$Level_of_Award','$Name_of_Award_Agency', '$Address_of_Award_Agency', '$Year_of_Received_Award','$EmailID_of_Agency','$Contact_of_Agency')
    ON DUPLICATE KEY UPDATE
    FACULTY_NAME = VALUES(FACULTY_NAME),
    GENDER = VALUES(GENDER),
    DESIGNATION = VALUES(DESIGNATION),
    DOB = VALUES(DOB),
    AGE = VALUES(AGE),
    QUALIF = VALUES(QUALIF),
    EXPERIENCE = VALUES(EXPERIENCE),
    PAN_NUM = VALUES(PAN_NUM),
    FACULTY_ASSO_IN_PREV_YEAR = VALUES(FACULTY_ASSO_IN_PREV_YEAR),
    FACULTY_EXP_TEACHING = VALUES(FACULTY_EXP_TEACHING),
    FACULTY_EXP_INDUSTRIAL = VALUES(FACULTY_EXP_INDUSTRIAL),
    JOINING_INSTITUTE_DATE = VALUES(JOINING_INSTITUTE_DATE),
    LATEST_DATE = VALUES(LATEST_DATE),
    ASSOC_TYPE = VALUES(ASSOC_TYPE),
    EMAIL_ID = VALUES(EMAIL_ID),
    MOBILE_NUM = VALUES(MOBILE_NUM),
    NAME_OF_AWARD = VALUES(NAME_OF_AWARD),
    LEVEL_OF_AWARD = VALUES(LEVEL_OF_AWARD),
    NAME_OF_AWARD_AGENCY = VALUES(NAME_OF_AWARD_AGENCY),
    ADD_OF_AWARD_AGENCY = VALUES(ADD_OF_AWARD_AGENCY),
    YEAR_OF_RECEIVED_AWARD = VALUES(YEAR_OF_RECEIVED_AWARD),
    EMAIL_OF_AGENCY = VALUES(EMAIL_OF_AGENCY),
    CONTACT_OF_AGENCY = VALUES(CONTACT_OF_AGENCY)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "FacultyDetails.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}  

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from faculty_details where ID = '$id'");
        echo '<script>window.location.href = "FacultyDetails.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 ">Faculty Details</p>
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
                        Faculty Name
                    </label>
                    <input type="text" name="Faculty_Name" class="form-control" placeholder="Enter Name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Gender
                    </label>
                    <select name="gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="other">other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" >
                        Designation
                    </label>
                    <select name="designation" class="form-control">
                        <option value="PROFESSOR">PROFESSOR</option>
                        <option value="ASSOCIATE PROFESSOR">ASSOCIATE PROFESSOR</option>
                        <option value="ASSISTANT PROFESSOR">ASSISTANT PROFESSOR</option>
                        <option value="ADJUNCT PROFESSOR">ADJUNCT PROFESSOR</option>
                        <option value="CHAIR PROFESSOR">CHAIR PROFESSOR</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Date of Birth
                    </label>
                    <input type="date" name="DOB" class="form-control" placeholder="Enter DOB" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Age
                    </label>
                    <input type="number" name="Age" class="form-control" placeholder="Enter Age" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Qualification
                    </label>
                    <input type="text" name="qualification" class="form-control" placeholder="Enter Highest Qualification" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Experience
                    </label>
                    <input type="text" name="experience" class="form-control" placeholder="Enter Experience(in months)" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        PAN Number
                    </label>
                    <input type="text" name="pan_number" class="form-control" placeholder="Enter PAN Number" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    Whether faculty is associated with the institute in previous academic year(2022-2023)?
                    </label>
                    <select name="Associated" class="form-control">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Facuty Experience in the relevent subject Area(Teaching & Industrial)- 31 July-2023
                    </label>
                    <input type="text" name="Teaching" class="form-control" placeholder="Enter teaching exerience (in Months)" required>
                    <input type="text" name="Industrial" class="form-control" placeholder="Enter Industrial exerience (in Months)" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    Currently working with institution?
                    </label>
                    <p><span class="small" style="margin-left: -0.8rem;">Date of joining the institute</p>
                    <input type="date" name="Date_of_joining" class="form-control" placeholder="Date of Joining the institute" required>
                    <p><span class="small" style="margin-left: -0.8rem;">Date of latest joining</p>
                    <input type="date" name="latest_joining" class="form-control" placeholder="Latest Joining" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    Association Type
                    </label>
                    <select name="Association_Type" class="form-control">
                        <option value="REGULAR">REGULAR</option>
                        <option value="CONTRACTUAL">CONTRACTUAL</option>
                        <option value="VISITING">VISITING</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Email ID of Faculty(Official Email ID)
                    </label>
                    <input type="email" name="EmailID_of_Faculty" class="form-control" placeholder="Enter Email ID" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                       Mobile Number of Faculty
                    </label>
                    <input type="number" name="Mobile_Number_of_Faculty" class="form-control" placeholder="Enter Mobile number" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                       Name of Award
                    </label>
                    <input type="text" name="Name_of_Award" class="form-control" placeholder="Enter Name of Award" >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    Level of Award
                    </label>
                    <select name="Level_of_Award" class="form-control">
                        <option value="">Select an option</option>
                        <option value="NATIONAL">NATIONAL</option>
                        <option value="INTERNATIONAL">INTERNATIONAL</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                       Name of Award Agency
                    </label>
                    <input type="text" name="Name_of_Award_Agency" class="form-control" placeholder="Enter Name of Award Agency" >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                       Address of Award Agency
                    </label>
                    <input type="text" name="Address_of_Award_Agency" class="form-control" placeholder="Enter Address of Award Agency" >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                       Year of Received Award
                    </label>
                    <input type="date" name="Year_of_Received_Award" class="form-control" placeholder="Enter Year of Received Award" >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Email ID of Agency
                    </label>
                    <input type="email" name="EmailID_of_Agency" class="form-control" placeholder="Enter Agency Email ID" >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                       Contact of Agency
                    </label>
                    <input number="text" name="Contact_of_Agency" class="form-control" placeholder="Enter Mobile number" >
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
                            <th scope="col">Faculty Name</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Age</th>
                            <th scope="col">Qualification</th>
                            <th scope="col">Experience</th>
                            <th scope="col">PAN Number</th>
                            <th scope="col">Associated in previous academic year?</th>
                            <th scope="col">Facuty Experience in Teaching</th>
                            <th scope="col">Facuty Experience in Industrial</th>
                            <th scope="col">Date of joining the institute</th>
                            <th scope="col">Date of latest joining</th>
                            <th scope="col">Association Type</th>
                            <th scope="col">Official Email ID of Faculty</th>
                            <th scope="col">Mobile Number of Faculty</th>
                            <th scope="col">Name of Award</th>
                            <th scope="col">Level of Award</th>
                            <th scope="col">Name of Award Agency</th>
                            <th scope="col">Address of Award Agency</th>
                            <th scope="col">Year of Received Award</th>
                            <th scope="col">Email ID of Agency</th>
                            <th scope="col">Contact of Agency</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM faculty_details WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['FACULTY_NAME']?></td>
                    <td><?php echo $row['GENDER']?></td>
                    <td><?php echo $row['DESIGNATION']?></td>
                    <td><?php echo $row['DOB']?></td>
                    <td><?php echo $row['AGE']?></td>
                    <td><?php echo $row['QUALIF']?></td>
                    <td><?php echo $row['EXPERIENCE']?></td>
                    <td><?php echo $row['PAN_NUM']?></td>
                    <td><?php echo $row['FACULTY_ASSO_IN_PREV_YEAR']?></td>
                    <td><?php echo $row['FACULTY_EXP_TEACHING']?></td>
                    <td><?php echo $row['FACULTY_EXP_INDUSTRIAL']?></td>
                    <td><?php echo $row['JOINING_INSTITUTE_DATE']?></td>
                    <td><?php echo $row['LATEST_DATE']?></td>
                    <td><?php echo $row['ASSOC_TYPE']?></td>
                    <td><?php echo $row['EMAIL_ID']?></td>
                    <td><?php echo $row['MOBILE_NUM']?></td>
                    <td><?php echo $row['NAME_OF_AWARD']?></td>
                    <td><?php echo $row['LEVEL_OF_AWARD']?></td>
                    <td><?php echo $row['NAME_OF_AWARD_AGENCY']?></td>
                    <td><?php echo $row['ADD_OF_AWARD_AGENCY']?></td>
                    <td><?php echo $row['YEAR_OF_RECEIVED_AWARD']?></td>
                    <td><?php echo $row['EMAIL_OF_AGENCY']?></td>
                    <td><?php echo $row['CONTACT_OF_AGENCY']?></td>
                    <td><a class="dbutton" href="FacultyDetails.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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





