<?php
include 'config.php';
require "header.php";


if (isset($_POST['submit'])) {

    // --- FIX: Retrieving all variables that are actually in the form ---
    $department_name = mysqli_real_escape_string($conn, $_POST['department_name']);
    $year_of_establishment = mysqli_real_escape_string($conn, $_POST['year_of_establishment']);
    $hod_name = mysqli_real_escape_string($conn, $_POST['hod_name']);
    $hod_email = mysqli_real_escape_string($conn, $_POST['hod_email']);
    $hod_mobile = mysqli_real_escape_string($conn, $_POST['hod_mobile']);
    $iqac_coordinator_name = mysqli_real_escape_string($conn, $_POST['iqac_coordinator_name']);
    $iqac_coordinator_email = mysqli_real_escape_string($conn, $_POST['iqac_coordinator_email']);
    $iqac_coordinator_mobile = mysqli_real_escape_string($conn, $_POST['iqac_coordinator_mobile']);
    $sanctioned_teaching_faculty = mysqli_real_escape_string($conn, $_POST['sanctioned_teaching_faculty']);
    $permanent_professors = mysqli_real_escape_string($conn, $_POST['permanent_professors']);
    $permanent_associate_professors = mysqli_real_escape_string($conn, $_POST['permanent_associate_professors']);
    $permanent_assistant_professors = mysqli_real_escape_string($conn, $_POST['permanent_assistant_professors']); // This was missing
    $contract_teachers = mysqli_real_escape_string($conn, $_POST['contract_teachers']);
    $programmes_offered = mysqli_real_escape_string($conn, $_POST['programmes_offered']);
    $executive_development_programs = mysqli_real_escape_string($conn, $_POST['executive_development_programs']);
    $areas_of_research = mysqli_real_escape_string($conn, $_POST['areas_of_research']);
    $class_1 = mysqli_real_escape_string($conn, $_POST['class_1']);
    $class_2 = mysqli_real_escape_string($conn, $_POST['class_2']);
    $class_3 = mysqli_real_escape_string($conn, $_POST['class_3']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);


    $query = "INSERT INTO `Brief_Details_of_the_Department` ( `DEPARTMENT_NAME`, `YEAR_OF_ESTABLISHMENT`, `HOD_NAME`, `HOD_EMAIL`, `HOD_MOBILE`, 
        `IQAC_COORDINATOR_NAME`, `IQAC_COORDINATOR_EMAIL`, `IQAC_COORDINATOR_MOBILE`, 
        `SANCTIONED_TEACHING_FACULTY`, `PERMANENT_PROFESSORS`, `PERMANENT_ASSOCIATE_PROFESSORS`, 
        `PERMANENT_ASSISTANT_PROFESSORS`, `CONTRACT_TEACHERS`, `PROGRAMMES_OFFERED`, 
        `EXECUTIVE_DEVELOPMENT_PROGRAMS`, `AREAS_OF_RESEARCH`,`CLASS_1`,`CLASS_2`,`ClASS_3`,`TYPE`
    ) VALUES ( '$department_name', '$year_of_establishment', '$hod_name', '$hod_email', '$hod_mobile',
        '$iqac_coordinator_name', '$iqac_coordinator_email', '$iqac_coordinator_mobile',
        '$sanctioned_teaching_faculty', '$permanent_professors', '$permanent_associate_professors',
        '$permanent_assistant_professors', '$contract_teachers', '$programmes_offered',
        '$executive_development_programs', '$areas_of_research', '$class_1', '$class_2', '$class_3','$type'
    )
    ON DUPLICATE KEY UPDATE
        DEPARTMENT_NAME = VALUES(DEPARTMENT_NAME), YEAR_OF_ESTABLISHMENT = VALUES(YEAR_OF_ESTABLISHMENT),
        HOD_NAME = VALUES(HOD_NAME), HOD_EMAIL = VALUES(HOD_EMAIL), HOD_MOBILE = VALUES(HOD_MOBILE),
        IQAC_COORDINATOR_NAME = VALUES(IQAC_COORDINATOR_NAME), IQAC_COORDINATOR_EMAIL = VALUES(IQAC_COORDINATOR_EMAIL),
        IQAC_COORDINATOR_MOBILE = VALUES(IQAC_COORDINATOR_MOBILE), SANCTIONED_TEACHING_FACULTY = VALUES(SANCTIONED_TEACHING_FACULTY),
        PERMANENT_PROFESSORS = VALUES(PERMANENT_PROFESSORS), PERMANENT_ASSOCIATE_PROFESSORS = VALUES(PERMANENT_ASSOCIATE_PROFESSORS),
        PERMANENT_ASSISTANT_PROFESSORS = VALUES(PERMANENT_ASSISTANT_PROFESSORS), CONTRACT_TEACHERS = VALUES(CONTRACT_TEACHERS),
        PROGRAMMES_OFFERED = VALUES(PROGRAMMES_OFFERED), EXECUTIVE_DEVELOPMENT_PROGRAMS = VALUES(EXECUTIVE_DEVELOPMENT_PROGRAMS),
        AREAS_OF_RESEARCH = VALUES(AREAS_OF_RESEARCH), CLASS_1 = VALUES(CLASS_1),CLASS_2 = VALUES(CLASS_2),CLASS_3 = VALUES(CLASS_3)";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Entered.')</script>";
        // --- FIX: Redirect to the current page to see the changes. ---
        echo '<script>window.location.href = "' . basename($_SERVER['PHP_SELF']) . '";</script>';
    } else {
        // For debugging, it can be helpful to see the actual error: echo mysqli_error($conn);
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'delete') {
        $id = $_GET['ID'];
        // --- FIX: Deleting from the correct table. ---
        // This assumes the table has a primary key column named 'ID'. If not, this logic needs adjustment.
        $sql = mysqli_query($conn, "DELETE FROM `Brief_Details_of_the_Department` WHERE ID = '$id'");
        // --- FIX: Redirect to the current page after delete. ---
        echo '<script>window.location.href = "' . basename($_SERVER['PHP_SELF']) . '";</script>';
    }
}
?>
<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4"><b>Brief Details of the Department / Institution/ School/ Centre/ Sub-campus/
                    Model or Conducted/ Constituent College of University</b></p>
        </div>
        <div class="mb-3">
            <label for="form-label" style="margin-bottom: 6px">Name of the Department/Institution</label>
            <input type=" text" id="department_name" name="department_name" required>
        </div>
        <div class="mb-3">
            <label for="form-lable" style="margin: bottom 6px;">Year of Establishment</label>
            <input type="number" id="year_established" name="year_of_establishment" min="1800"
                max="<?php echo date("Y"); ?>" required>
        </div>
        <hr>
        <h2>Head of Department (HoD)/Director Details</h2>
        <div class="mb-3">
            <label for="form-lable">Name</label>
            <input type="text" id="hod_name" name="hod_name" required>
        </div>
        <div class="mb-3">
            <label for="form-lable">Email</label>
            <input type="email" id="hod_email" name="hod_email" required>
        </div>
        <div class="mb-3">
            <label for="form-lable">Mobile Number</label>
            <input type="tel" id="hod_mobile" name="hod_mobile" pattern="[0-9]{10}"
                title="Enter a 10-digit mobile number">
        </div>
        <hr>
        <h2>IQAC Coordinator Details</h2>
        <div class="mb-3">
            <label for="form-lable">Name</label>
            <input type="text" id="iqac_name" name="iqac_coordinator_name" required>
        </div>
        <div class="mb-3">
            <label for="form-lable">Email</label>
            <input type="email" id="iqac_email" name="iqac_coordinator_email" required>
        </div>
        <div class="mb-3">
            <label for="form-lable">Mobile Number</label>
            <input type="tel" id="iqac_mobile" name="iqac_coordinator_mobile" pattern="[0-9]{10}"
                title="Enter a 10-digit mobile number">
        </div>
        <hr>
        <h2>Faculty Details</h2>
        <div class="mb-3">
            <label for="form-label">Sanctioned Teaching Faculty</label>
            <input type="number" id="sanctioned_faculty" name="sanctioned_teaching_faculty" min="0" required>
        </div>
        <div class="form-group">
            <label>Number of Permanent Faculties</label>
            <div class="mb-3">
                <div>
                    <label for="form-label" style="font-weight:normal;">Professors</label>
                    <input type="number" id="professors" name="permanent_professors" min="0" value="0" required>
                </div>
                <div>
                    <label for="form-label" style="font-weight:normal;">Associate Professors</label>
                    <input type="number" id="assoc_professors" name="permanent_associate_professors" min="0" value="0"
                        required>
                </div>
                <div>
                    <label for="form-label" style="font-weight:normal;">Assistant Professors</label>
                    <input type="number" id="asst_professors" name="permanent_assistant_professors" min="0" value="0"
                        required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="contract_teachers">No. of Ad hoc/Contract Teachers</label>
            <input type="number" id="contract_teachers" name="contract_teachers" min="0" required>
        </div>
        <hr>
        <h2>Academic & Research Details</h2>
        <div class="mb-3">
            <label for="form-label">Certificate/Diploma/UG/PG Programmes Offered (with intake)</label>
            <textarea id="programs_offered" name="programmes_offered"
                placeholder="e.g., B.Sc. Computer Science (Intake: 120), M.A. History (Intake: 60)"></textarea>
        </div>
        <div class="mb-3">
            <label for="form-label">Number of Executive Development Programs</label>
            <input type="number" id="edp_count" name="executive_development_programs" min="0" required>
        </div>
        <div class="mb-3">
            <label for="form-label">Areas of Research</label>
            <textarea id="research_areas" name="areas_of_research"
                placeholder="e.g., Artificial Intelligence, Machine Learning, Indian History, Quantum Physics"></textarea>
        </div>
        <div class="form-group">
            <label>Strength of Non-teaching Employee </label>
            <div class="mb-3">
                <div>
                    <label for="form-label" style="font-weight:normal;">Class I</label>
                    <input type="number" id="Non_teaching_Employee_Class_1" name="class_1" min="0" value="0" required>
                </div>
                <div>
                    <label for="form-label" style="font-weight:normal;">Class II</label>
                    <input type="number" id="Non_teaching_Employee_Class_2" name="class_2" min="0" value="0" required>
                </div>
                <div>
                    <label for="form-label" style="font-weight:normal;">Class III</label>
                    <input type="number" id="Non_teaching_Employee_Class_3" name="class_3" min="0" value="0" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Category</b></label>
            <select name="type" style="margin-top: 0%;">
                <option value="Indian">select</option>
                <option value="Indian">Sciences and Technology</option>
                <option value="Foreign">Commerce and Management</option>
                <option value="Foreign">Languages, Humanities, and Social Sciences</option>
                <option value="Foreign">Interdisciplinary</option>
                <option value="Foreign">Centre of Studies, Centre of Excellence, Chairs, Sub-campus, Constituent or
                    Conducted/ Model Colleges </option>
        </div>
        <input type="submit" class="submit" value="Submit" name="submit">
    </form>
</div>

<!-- Show Entered Data -->
<div class="row my-5">
    <h3 class="fs-4 mb-3 text-center" id="msg"><b>You Have Entered the Following Data</b></h3>
    <div class="col ">
        <div class="overflow-auto " style="margin:7px">
            <table class="table bg-white rounded shadow-sm  table-hover ">
                <thead>
                    <tr>
                        <th scope="col">Name of the Department/Institution</th>
                        <th scope="col">Year of Establishment</th>
                        <th scope="col">Head of Department Name</th>
                        <th scope="col">Head of Department Email</th>
                        <th scope="col">Head of Department Mobile Number</th>
                        <th scope="col">IQAC Coordinator Name</th>
                        <th scope="col">IQAC Coordinator Email</th>
                        <th scope="col">IQAC Coordinator Phone Number</th>
                        <th scope="col">Sanctioned Teaching Faculty</th>
                        <th scope="col">Number of Permanent Professors</th>
                        <th scope="col">Number of Permanent Associate Professors</th>
                        <th scope="col">Number of Permanent Assistant Professors</th>
                        <th scope="col">No. of Ad hoc/Contract Teachers</th>
                        <th scope="col">Certificate/Diploma/UG/PG Programmes Offered (with intake)</th>
                        <th scope="col">Number of Executive Development Programs</th>
                        <th scope="col">Areas of Research</th>
                        <th scope="col">Non-teaching Employee Class I</th>
                        <th scope="col">Non-teaching Employee Class II</th>
                        <th scope="col">Non-teaching Employee Class II</th>
                        <th scope="col">Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $Record = mysqli_query($conn, "SELECT * FROM employers_details WHERE DEPT_ID = $dept");
                    while ($row = mysqli_fetch_array($Record)) {
                        ?>
                        <tr>
                            <td><?php echo $row['department_name'] ?></td>
                            <td><?php echo $row['year_of_establishment'] ?></td>
                            <td><?php echo $row['hod_name'] ?></td>
                            <td><?php echo $row['hod_email'] ?></td>
                            <td><?php echo $row['hod_mobile'] ?></td>
                            <td><?php echo $row['iqac_coordinator_name'] ?></td>
                            <td><?php echo $row['iqac_coordinator_email'] ?></td>
                            <td><?php echo $row['iqac_coordinator_mobile'] ?></td>
                            <td><?php echo $row['sanctioned_teaching_faculty'] ?></td>
                            <td><?php echo $row['permanent_professors'] ?></td>
                            <td><?php echo $row['permanent_associate_professors'] ?></td>
                            <td><?php echo $row['permanent_assistant_professors'] ?></td>
                            <td><?php echo $row['contract_teachers'] ?></td>
                            <td><?php echo $row['programmes_offered'] ?></td>
                            <td><?php echo $row['executive_development_programs'] ?></td>
                            <td><?php echo $row['class_1'] ?></td>
                            <td><?php echo $row['class_2'] ?></td>
                            <td><?php echo $row['class_3'] ?></td>
                            <td><?php echo $row['type'] ?></td>
                            <td><a class="dbutton"
                                    href="EditEmployerDetails.php?action=edit&ID=<?php echo $row['ID'] ?>">Edit</a></td>
                            <td><a class="dbutton"
                                    href="EmployerDetails.php?action=delete&ID=<?php echo $row['ID'] ?>">Delete</a></td>
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