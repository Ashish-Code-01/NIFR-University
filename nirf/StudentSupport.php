<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $intake_capacity = $_POST['intake_capacity'];
    $enrolment = $_POST['enrolment'];
    $jrf_srfs_pdf_ra_others = $_POST['research_fellows'];
    $reserved_category_male = $_POST['reserved_male'];
    $reserved_category_female = $_POST['reserved_female'];
    $scholarship_govt = $_POST['scholarship_govt'];
    $scholarship_univ = $_POST['scholarship_univ'];
    $scholarship_private = $_POST['scholarship_private'];
    $regional_within_univ_male = $_POST['regional_within_univ_male'];
    $regional_within_univ_female = $_POST['regional_within_univ_female'];
    $regional_outside_univ_male = $_POST['regional_outside_univ_male'];
    $regional_outside_univ_female = $_POST['regional_outside_univ_female'];
    $regional_outside_state_male = $_POST['regional_outside_state_male'];
    $regional_outside_state_female = $_POST['regional_outside_state_female'];
    $regional_outside_country_male = $_POST['regional_outside_country_male'];
    $regional_outside_country_female = $_POST['regional_outside_country_female'];
    $executive_dev_students_male = $_POST['exec_students_male'];
    $executive_dev_students_female = $_POST['exec_students_female'];
    $executive_dev_fee_collected = $_POST['exec_fee'];
    $internships_ojt = $_POST['internships'];
    $final_sem_appeared = $_POST['final_sem_appeared'];
    $final_sem_passed = $_POST['final_sem_passed'];
    $placed_or_self_employed = $_POST['placed_self'];
    $qualified_competitive_exams = $_POST['qualified_exams'];
    $higher_studies_institutions = $_POST['higher_studies'];
    $student_research_activities = $_POST['research_activities'];
    $sports_awards_state = $_POST['sports_state'];
    $sports_awards_national = $_POST['sports_national'];
    $sports_awards_international = $_POST['sports_international'];
    $cultural_awards = $_POST['cultural_awards'];
    $moocs = $_POST['moocs'];
    $platform = $_POST['platform'];
    $title = $_POST['mooc_title'];
    $students = $_POST['mooc_students'];
    $credits_transferred = $_POST['mooc_credits'];
}


$query = "INSERT INTO `StudentSupport`
(`A_YEAR`, `name`, `intake_capacity`, `enrolment`, `jrf_srfs_pdf_ra_others`,
`reserved_category_male`, `reserved_category_female`, `scholarship_govt`,
`scholarship_univ`, `scholarship_private`, `regional_within_univ_male`,
`regional_within_univ_female`, `regional_outside_univ_male`, `regional_outside_univ_female`,
`regional_outside_state_male`, `regional_outside_state_female`, `regional_outside_country_male`,
`regional_outside_country_female`, `executive_dev_students_male`, `executive_dev_students_female`,
`executive_dev_fee_collected`, `internships_ojt`, `final_sem_appeared`, `final_sem_passed`,
`placed_or_self_employed`, `qualified_competitive_exams`, `higher_studies_institutions`,
`student_research_activities`, `sports_awards_state`, `sports_awards_national`,
`sports_awards_international`, `cultural_awards`, `moocs`, `platform`, `title`, `students`, `credits_transferred`)
VALUES (
'$A_YEAR', '$name', '$intake_capacity', '$enrolment', '$jrf_srfs_pdf_ra_others',
'$reserved_category_male', '$reserved_category_female', '$scholarship_govt',
'$scholarship_univ', '$scholarship_private', '$regional_within_univ_male',
'$regional_within_univ_female', '$regional_outside_univ_male', '$regional_outside_univ_female',
'$regional_outside_state_male', '$regional_outside_state_female', '$regional_outside_country_male',
'$regional_outside_country_female', '$executive_dev_students_male', '$executive_dev_students_female',
'$executive_dev_fee_collected', '$internships_ojt', '$final_sem_appeared', '$final_sem_passed',
'$placed_or_self_employed', '$qualified_competitive_exams', '$higher_studies_institutions',
'$student_research_activities', '$sports_awards_state', '$sports_awards_national',
'$sports_awards_international', '$cultural_awards', '$moocs', '$platform', '$title', '$students', '$credits_transferred'
)
ON DUPLICATE KEY UPDATE
`intake_capacity` = VALUES(`intake_capacity`),
`enrolment` = VALUES(`enrolment`),
`jrf_srfs_pdf_ra_others` = VALUES(`jrf_srfs_pdf_ra_others`),
`reserved_category_male` = VALUES(`reserved_category_male`),
`reserved_category_female` = VALUES(`reserved_category_female`),
`scholarship_univ` = VALUES(`scholarship_univ`),
`scholarship_govt` = VALUES(`scholarship_govt`),
`scholarship_private` = VALUES(`scholarship_private`),
`regional_within_univ_male` = VALUES(`regional_within_univ_male`),
`regional_within_univ_female` = VALUES(`regional_within_univ_female`),
`regional_outside_univ_male` = VALUES(`regional_outside_univ_male`),
`regional_outside_univ_female` = VALUES(`regional_outside_univ_female`),
`regional_outside_state_male` = VALUES(`regional_outside_state_male`),
`regional_outside_state_female` = VALUES(`regional_outside_state_female`),
`scholarship_univ` = VALUES(`scholarship_univ`),
`scholarship_private` = VALUES(`scholarship_private`)";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Data Entered.')</script>";
    echo '<script>window.location.href = "";</script>';
} else {
    echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
}


?>


<div class="card"
    style="max-width:1200px;margin:32px auto;padding:24px 32px;border-radius:12px;box-shadow:0 2px 12px #0001;">
    <h2 class="text-center mb-3">Student Support, Achievements and Progression</h2>
    <p class="text-center text-muted mb-4">Fill program-wise data. Use <strong>Add Program</strong> to enter multiple
        programs.</p>

    <form method="post" id="mainForm">
        <div id="programsContainer"></div>
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-success" onclick="addProgram()">Add Program</button>
        </div>
        <hr class="my-4">

        <div class="card mb-4 p-3">
            <h4 class="mb-3">Conferences, Workshops, STTP and Seminars</h4>
            <div class="row g-3">
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">Industry-Acad. Innovative
                        practices</label><input type="number" class="form-control"
                        name="industry_academia_innovative_practices" min="0"></div>
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">Workshops / STTP /
                        Refresher</label><input type="number" class="form-control" name="workshops_sttp" min="0"></div>
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">National Conferences</label><input
                        type="number" class="form-control" name="national_conf" min="0"></div>
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">International
                        Conferences</label><input type="number" class="form-control" name="international_conf" min="0">
                </div>
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">Teachers invited as
                        speakers</label><input type="number" class="form-control" name="teachers_invited" min="0"></div>
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">Teachers who presented</label><input
                        type="number" class="form-control" name="teachers_presented" min="0"></div>
            </div>
        </div>

        <div class="card mb-4 p-3">
            <h4 class="mb-3">Collaborations</h4>
            <div class="row g-3">
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">Industry collaborations (Programs &
                        output)</label><input type="number" class="form-control" name="industry_collaborations" min="0">
                </div>
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">National academic
                        collaborations</label><input type="number" class="form-control"
                        name="national_academic_collaborations" min="0"></div>
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">Govt/Semi-Govt collaboration
                        projects</label><input type="number" class="form-control"
                        name="government_collaboration_projects" min="0"></div>
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">International academic
                        collaborations</label><input type="number" class="form-control"
                        name="international_academic_collaborations" min="0"></div>
                <div class="col-md-4"><label class="fw-bold" style="margin-left:0;">Outreach/Social activity
                        collaborations</label><input type="number" class="form-control"
                        name="outreach_social_collaborations" min="0"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <input type="submit" class="btn btn-primary px-5" value="Submit" name="submit" onclick="return Validate()">
        </div>
    </form>
</div>


<!-- Show Entered Data -->
<div class="row my-5">
    <h3 class="fs-4 mb-3 text-center" id="msg"><b>Departmental Governance Data Entered</b></h3>
    <div class="col">
        <div class="overflow-auto">
            <table class="table table-bordered table-striped bg-white rounded shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Inclusive Practices</th>
                        <th scope="col">Green Practices</th>
                        <th scope="col">Teachers in Admin</th>
                        <th scope="col">Awards Extension</th>
                        <th scope="col">Alumni Contribution</th>
                        <th scope="col">ISR Initiatives</th>
                        <th scope="col">Sponsors</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $Record = mysqli_query($conn, "SELECT * FROM department_data");
                    while ($row = mysqli_fetch_array($Record)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>" . htmlspecialchars($row['inclusive_practices']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['green_practices']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['teachers_in_admin']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['awards_extension']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['alumni_contribution']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['isr_total']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sponsors_total']) . "</td>";
                        echo "<td><a class='btn btn-sm btn-warning' href='Departmental_Governance.php?id={$row['id']}'>Edit</a></td>";
                        echo "<td><a class='btn btn-sm btn-danger' href='Departmental_Governance.php?action=delete&id={$row['id']}' onclick=\"return confirm('Delete this record?');\">Delete</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Show Student Support Data -->
<div class="row my-5">
    <h3 class="fs-4 mb-3 text-center"><b>Student Support Data Entered</b></h3>
    <div class="col">
        <div class="overflow-auto">
            <table class="table table-bordered table-striped bg-white rounded shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Program Name</th>
                        <th>Intake Capacity</th>
                        <th>Enrolment</th>
                        <th>JRF/SRF/PDF/RA/Others</th>
                        <th>Reserved Male</th>
                        <th>Reserved Female</th>
                        <th>Govt Scholarship</th>
                        <th>Univ Scholarship</th>
                        <th>Private Scholarship</th>
                        <th>Within Univ Male</th>
                        <th>Within Univ Female</th>
                        <th>Outside Univ Male</th>
                        <th>Outside Univ Female</th>
                        <th>Outside State Male</th>
                        <th>Outside State Female</th>
                        <th>Outside Country Male</th>
                        <th>Outside Country Female</th>
                        <th>Exec Dev Male</th>
                        <th>Exec Dev Female</th>
                        <th>Exec Fee</th>
                        <th>Internships/OJT</th>
                        <th>Final Sem Appeared</th>
                        <th>Final Sem Passed</th>
                        <th>Placed/Self Employed</th>
                        <th>Qualified Exams</th>
                        <th>Higher Studies</th>
                        <th>Research Activities</th>
                        <th>Sports State</th>
                        <th>Sports National</th>
                        <th>Sports International</th>
                        <th>Cultural Awards</th>
                        <th>MOOCs</th>
                        <th>Platform</th>
                        <th>MOOC Title</th>
                        <th>MOOC Students</th>
                        <th>MOOC Credits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $Record = mysqli_query($conn, "SELECT * FROM StudentSupport");
                    while ($row = mysqli_fetch_array($Record)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>{$row['intake_capacity']}</td>";
                        echo "<td>{$row['enrolment']}</td>";
                        echo "<td>{$row['jrf_srfs_pdf_ra_others']}</td>";
                        echo "<td>{$row['reserved_category_male']}</td>";
                        echo "<td>{$row['reserved_category_female']}</td>";
                        echo "<td>{$row['scholarship_govt']}</td>";
                        echo "<td>{$row['scholarship_univ']}</td>";
                        echo "<td>{$row['scholarship_private']}</td>";
                        echo "<td>{$row['regional_within_univ_male']}</td>";
                        echo "<td>{$row['regional_within_univ_female']}</td>";
                        echo "<td>{$row['regional_outside_univ_male']}</td>";
                        echo "<td>{$row['regional_outside_univ_female']}</td>";
                        echo "<td>{$row['regional_outside_state_male']}</td>";
                        echo "<td>{$row['regional_outside_state_female']}</td>";
                        echo "<td>{$row['regional_outside_country_male']}</td>";
                        echo "<td>{$row['regional_outside_country_female']}</td>";
                        echo "<td>{$row['executive_dev_students_male']}</td>";
                        echo "<td>{$row['executive_dev_students_female']}</td>";
                        echo "<td>{$row['executive_dev_fee_collected']}</td>";
                        echo "<td>{$row['internships_ojt']}</td>";
                        echo "<td>{$row['final_sem_appeared']}</td>";
                        echo "<td>{$row['final_sem_passed']}</td>";
                        echo "<td>{$row['placed_or_self_employed']}</td>";
                        echo "<td>{$row['qualified_competitive_exams']}</td>";
                        echo "<td>{$row['higher_studies_institutions']}</td>";
                        echo "<td>{$row['student_research_activities']}</td>";
                        echo "<td>{$row['sports_awards_state']}</td>";
                        echo "<td>{$row['sports_awards_national']}</td>";
                        echo "<td>{$row['sports_awards_international']}</td>";
                        echo "<td>{$row['cultural_awards']}</td>";
                        echo "<td>{$row['moocs']}</td>";
                        echo "<td>{$row['platform']}</td>";
                        echo "<td>{$row['title']}</td>";
                        echo "<td>{$row['students']}</td>";
                        echo "<td>{$row['credits_transferred']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    let programIndex = 0;

    function addProgram(prefill = {}) {
        const i = programIndex++;
        const container = document.getElementById('programsContainer');
        const div = document.createElement('div');
        div.className = 'card repeatable mb-3 p-3 position-relative';
        div.id = 'program-' + i;
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="fw-bold" style="margin-left:0;">Program Name</label>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeProgram(${i})" style="margin-left:8px">Remove</button>
            </div>
            <div class="row g-3">
                <div class="col-md-6"><label class="fw-bold" style="margin-left:0;">Intake capacity</label><input type="number" class="form-control" name="intake_capacity[]"></div>
                <div class="col-md-6"><label class="fw-bold" style="margin-left:0;">Enrolment</label><input type="number" class="form-control" name="enrolment[]"></div>
            </div>
        `;
        container.appendChild(div);
    }

    function removeProgram(i) {
        const el = document.getElementById('program-' + i);
        if (el) el.remove();
    }
    addProgram();
</script>
<?php
require "footer.php";
?>