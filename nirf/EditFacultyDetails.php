<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

// Fetch the existing data
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $result = mysqli_query($conn, "SELECT * FROM faculty_details WHERE ID = '$id' AND DEPT_ID = '$dept'");
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<script>alert('No record found!'); window.location.href='FacultyDetails.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid Request!'); window.location.href='FacultyDetails.php';</script>";
    exit();
}

// Update the data
if (isset($_POST['update'])) {
    $Faculty_Name = $_POST['Faculty_Name'];
    $gender = $_POST['gender'];
    $designation = $_POST['designation'];
    $DOB = $_POST['DOB'];
    $Age = $_POST['Age'];
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];
    $pan_number = $_POST['pan_number'];
    $Associated = $_POST['Associated'];
    $Teaching = $_POST['Teaching'];
    $Industrial = $_POST['Industrial'];
    $Date_of_joining = $_POST['Date_of_joining'];
    $latest_joining = $_POST['latest_joining'];
    $Association_Type = $_POST['Association_Type'];
    $EmailID_of_Faculty = $_POST['EmailID_of_Faculty'];
    $Mobile_Number_of_Faculty = $_POST['Mobile_Number_of_Faculty'];
    $Name_of_Award = $_POST['Name_of_Award'];
    $Level_of_Award = $_POST['Level_of_Award'];
    $Name_of_Award_Agency = $_POST['Name_of_Award_Agency'];
    $Address_of_Award_Agency = $_POST['Address_of_Award_Agency'];
    $Year_of_Received_Award = $_POST['Year_of_Received_Award'];
    $EmailID_of_Agency = $_POST['EmailID_of_Agency'];
    $Contact_of_Agency = $_POST['Contact_of_Agency'];

    $query = "UPDATE faculty_details SET 
        FACULTY_NAME = '$Faculty_Name',
        GENDER = '$gender',
        DESIGNATION = '$designation',
        DOB = '$DOB',
        AGE = '$Age',
        QUALIF = '$qualification',
        EXPERIENCE = '$experience',
        PAN_NUM = '$pan_number',
        FACULTY_ASSO_IN_PREV_YEAR = '$Associated',
        FACULTY_EXP_TEACHING = '$Teaching',
        FACULTY_EXP_INDUSTRIAL = '$Industrial',
        JOINING_INSTITUTE_DATE = '$Date_of_joining',
        LATEST_DATE = '$latest_joining',
        ASSOC_TYPE = '$Association_Type',
        EMAIL_ID = '$EmailID_of_Faculty',
        MOBILE_NUM = '$Mobile_Number_of_Faculty',
        NAME_OF_AWARD = '$Name_of_Award',
        LEVEL_OF_AWARD = '$Level_of_Award',
        NAME_OF_AWARD_AGENCY = '$Name_of_Award_Agency',
        ADD_OF_AWARD_AGENCY = '$Address_of_Award_Agency',
        YEAR_OF_RECEIVED_AWARD = '$Year_of_Received_Award',
        EMAIL_OF_AGENCY = '$EmailID_of_Agency',
        CONTACT_OF_AGENCY = '$Contact_of_Agency'
        WHERE ID = '$id' AND DEPT_ID = '$dept'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Record updated successfully!'); window.location.href='FacultyDetails.php';</script>";
    } else {
        echo "<script>alert('Update failed. Please try again!');</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Edit Faculty Details</b></p>
        </div>
        
        <!-- Input fields -->
        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Faculty Name</b></label>
            <input type="text" name="Faculty_Name" class="form-control" value="<?php echo $row['FACULTY_NAME']; ?>"  style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Gender</b></label>
            <select name="gender" class="form-control" style="margin-top: 0;">
                <option value="Male" <?php if($row['GENDER'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($row['GENDER'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="other" <?php if($row['GENDER'] == 'other') echo 'selected'; ?>>Other</option>
            </select>
        </div>

        <div class="mb-3">
    <label class="form-label" style="margin-bottom: 6px;"><b>Designation</b></label>
    <select name="designation" class="form-control" style="margin-top: 0;">
        <option value="PROFESSOR" <?php if ($row['DESIGNATION'] == 'PROFESSOR') echo 'selected'; ?>>PROFESSOR</option>
        <option value="ASSOCIATE PROFESSOR" <?php if ($row['DESIGNATION'] == 'ASSOCIATE PROFESSOR') echo 'selected'; ?>>ASSOCIATE PROFESSOR</option>
        <option value="ASSISTANT PROFESSOR" <?php if ($row['DESIGNATION'] == 'ASSISTANT PROFESSOR') echo 'selected'; ?>>ASSISTANT PROFESSOR</option>
        <option value="ADJUNCT PROFESSOR" <?php if ($row['DESIGNATION'] == 'ADJUNCT PROFESSOR') echo 'selected'; ?>>ADJUNCT PROFESSOR</option>
        <option value="CHAIR PROFESSOR" <?php if ($row['DESIGNATION'] == 'CHAIR PROFESSOR') echo 'selected'; ?>>CHAIR PROFESSOR</option>
    </select>
</div>

        <!-- Add all other fields similarly -->
        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Date of Birth</b></label>
            <input type="date" name="DOB" class="form-control" value="<?php echo $row['DOB']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Age</b></label>
            <input type="number" name="Age" class="form-control" value="<?php echo $row['AGE']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Qualification</b></label>
            <input type="text" name="qualification" class="form-control" value="<?php echo $row['QUALIF']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Experience</b></label>
                    <input type="text" name="experience" class="form-control" value="<?php echo $row['EXPERIENCE']; ?>" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>PAN Number</b></label>
                    <input type="text" name="pan_number" class="form-control" value="<?php echo $row['PAN_NUM']; ?>" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
    <label class="form-label" style="margin-bottom: 6px;">
        <b>Whether faculty is associated with the institute in previous academic year (2022-2023)?</b>
    </label>
    <select name="Associated" class="form-control" style="margin-top: 0;">
        <option value="Yes" <?php if ($row['FACULTY_ASSO_IN_PREV_YEAR'] == 'Yes') echo 'selected'; ?>>Yes</option>
        <option value="No" <?php if ($row['FACULTY_ASSO_IN_PREV_YEAR'] == 'No') echo 'selected'; ?>>No</option>
    </select>
</div>


                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Facuty Experience in the relevent subject Area(Teaching & Industrial)- 31 July-2023</b></label>
                    <input type="text" name="Teaching" class="form-control" value="<?php echo $row['FACULTY_EXP_TEACHING']; ?>" placeholder="Enter teaching exerience (in Months)" style="margin-top: 0;" required>
                    <input type="text" name="Industrial" class="form-control" value="<?php echo $row['FACULTY_EXP_INDUSTRIAL']; ?>" placeholder="Enter Industrial exerience (in Months)" style="margin-top: 0;" required>
                </div>

                <br>
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Currently working with institution?</b></label>
                    <p><span class="small" style="margin-left: -0.8rem;" ><b>Date of joining the institute</b></p>
                    <input type="date" name="Date_of_joining" class="form-control" value="<?php echo $row['JOINING_INSTITUTE_DATE']; ?>" placeholder="Date of Joining the institute" style="margin-top: 0;" required>
                    <p><span class="small" style="margin-left: -0.8rem;"><b>Date of latest joining</b></p>
                    <input type="date" name="latest_joining" class="form-control" value="<?php echo $row['LATEST_DATE']; ?>" placeholder="Latest Joining" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Association Type</b></label>
                    <select name="Association_Type" class="form-control" style="margin-top: 0;">
                        <option value="REGULAR" <?php if ($row['ASSOC_TYPE'] == 'REGULAR') echo 'selected'; ?>>REGULAR</option>
                        <option value="CONTRACTUAL" <?php if ($row['ASSOC_TYPE'] == 'CONTRACTUAL') echo 'selected'; ?>>CONTRACTUAL</option>
                        <option value="VISITING" <?php if ($row['ASSOC_TYPE'] == 'VISITING') echo 'selected'; ?>>VISITING</option>
                   </select>
                </div>


                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Email ID of Faculty(Official Email ID)</b></label>
                    <input type="email" name="EmailID_of_Faculty" class="form-control" value="<?php echo $row['EMAIL_ID']; ?>" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Mobile Number of Faculty</b></label>
                    <input type="number" name="Mobile_Number_of_Faculty" class="form-control" value="<?php echo $row['MOBILE_NUM']; ?>" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Name of Award</b></label>
                    <input type="text" name="Name_of_Award" class="form-control" value="<?php echo $row['NAME_OF_AWARD']; ?>" style="margin-top: 0;" >
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Level of Award</b></label>
                        <select name="Level_of_Award" class="form-control" style="margin-top: 0;">
                            <option value="">Select an option</option>
                            <option value="NATIONAL" <?php if ($row['LEVEL_OF_AWARD'] == 'NATIONAL') echo 'selected'; ?>>NATIONAL</option>
                            <option value="INTERNATIONAL" <?php if ($row['LEVEL_OF_AWARD'] == 'INTERNATIONAL') echo 'selected'; ?>>INTERNATIONAL</option>
                        </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Name of Award Agency</b></label>
                    <input type="text" name="Name_of_Award_Agency" class="form-control" value="<?php echo $row['NAME_OF_AWARD_AGENCY']; ?>" style="margin-top: 0;" >
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Address of Award Agency</b></label>
                    <input type="text" name="Address_of_Award_Agency" class="form-control" value="<?php echo $row['ADD_OF_AWARD_AGENCY']; ?>"  style="margin-top: 0;">
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Year of Received Award</b></label>
                    <input type="date" name="Year_of_Received_Award" class="form-control" value="<?php echo $row['YEAR_OF_RECEIVED_AWARD']; ?>"  style="margin-top: 0;">
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Email ID of Agency</b></label>
                    <input type="email" name="EmailID_of_Agency" class="form-control" value="<?php echo $row['EMAIL_OF_AGENCY']; ?>" style="margin-top: 0;">
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Contact of Agency</b></label>
                    <input number="text" name="Contact_of_Agency" class="form-control" value="<?php echo $row['CONTACT_OF_AGENCY']; ?>" style="margin-top: 0;">
                </div>

        <input type="submit" class="submit btn btn-primary" value="Update" name="update">
        <!-- <a href="FacultyDetails.php" class="btn btn-secondary">Cancel</a> -->
    </form>
</div>

<?php
require "footer.php";
?>
