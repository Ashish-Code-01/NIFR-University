<?php
include 'config.php';
require "header.php";

$total_marks = 0;
$breakdown = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calculate_marks'])) {
    $nep_count = isset($_POST['nep_initiatives']) ? count($_POST['nep_initiatives']) : 0;
    $ped_count = isset($_POST['pedagogical']) ? count($_POST['pedagogical']) : 0;
    $assess_count = isset($_POST['assessments']) ? count($_POST['assessments']) : 0;
    $moocs = isset($_POST['moocs']) ? (int) $_POST['moocs'] : 0;
    $econtent = isset($_POST['econtent']) ? (float) $_POST['econtent'] : 0;
    $result_days = isset($_POST['result_days']) ? (int) $_POST['result_days'] : 0;

    // Caps
    $nep_score = min($nep_count, 30);
    $ped_score = min($ped_count, 20);
    $assess_score = min($assess_count, 20);
    $mooc_score = min($moocs * 2, 10);
    $econtent_score = min($econtent, 15);
    $result_score = ($result_days <= 30) ? 5 : (($result_days <= 45) ? 3 : 0);

    $total_marks = $nep_score + $ped_score + $assess_score + $mooc_score + $econtent_score + $result_score;

    $breakdown = [
        "NEP Initiatives: $nep_score",
        "Pedagogical Approaches: $ped_score",
        "Assessments: $assess_score",
        "MOOCs: $mooc_score",
        "E-Content: $econtent_score",
        "Result Declaration: $result_score"
    ];

    // Optional: Save results to DB
    $query = "INSERT INTO NEPMarks
(nep_count, ped_count, assess_count, moocs, econtent, nep_score, ped_score, assess_score, mooc_score, econtent_score, result_days, result_score, total_marks)
VALUES (
    '$nep_count',
    '$ped_count',
    '$assess_count',
    '$moocs',
    '$econtent',
    '$nep_score',
    '$ped_score',
    '$assess_score',
    '$mooc_score',
    '$econtent_score',
    '$result_days',
    '$result_score',
    '$total_marks'
)
ON DUPLICATE KEY UPDATE
    nep_count = VALUES(nep_count),
    ped_count = VALUES(ped_count),
    assess_count = VALUES(assess_count),
    moocs = VALUES(moocs),
    econtent = VALUES(econtent),
    nep_score = VALUES(nep_score),
    ped_score = VALUES(ped_score),
    assess_score = VALUES(assess_score),
    mooc_score = VALUES(mooc_score),
    econtent_score = VALUES(econtent_score),
    result_days = VALUES(result_days),
    result_score = VALUES(result_score),
    total_marks = VALUES(total_marks)";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "Departmental_Governance.php";</script>';
    } else {
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}
?>

<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">

            <div class="card shadow-lg">
                <div class="card-header text-center text-xl">
                    <h4 class="mb-0">NEP Initiatives & Academic Activities - Marks Calculator</h4>
                </div>
                <div class="card-body p-4">

                    <?php if (!empty($breakdown)): ?>
                        <div class="alert alert-success">
                            <h5>Total Marks: <?= $total_marks ?> / 100</h5>
                            <ul>
                                <?php foreach ($breakdown as $line): ?>
                                    <li><?= htmlspecialchars($line) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php elseif (isset($_GET['success'])): ?>
                        <div class="alert alert-success">Data saved successfully.</div>
                    <?php endif; ?>

                    <form method="post">
                        <!-- NEP Initiatives -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2 fs-5">1. NEP Initiatives and Professional Activities
                                adopted by the department (Max. marks 30)</label>
                            <div class="row">
                                <?php
                                $nep_items = [
                                    "Multidisciplinary Curriculum/Major-Minor combinations for the UG Programme with CO-PO, PEOs (LOCF with flexible curricular structures)",
                                    "Research Projects and Publication Output at PG Programme/ Fourth Year UG -honours with Research",
                                    "Subject-specific Skills and Hands-on-Training Courses",
                                    "Open Electives from other faculty",
                                    "Value and Life Skills Education including Curriculum on Gender Equity, Indian Constitution, Environmental Education, Universal Human Values, Industry 4.0, etc.",
                                    "Generic and Subject-Specific IKS",
                                    "100 % Adoption of Assignment, Accumulation, Storage, and Transfer of Credits in ABC",
                                    "Community Engagement/ Field Projects/ Social Entrepreneurship and any specific Output thereof",
                                    "Joint Degree Programme",
                                    "Dual and Integrated Degree Programme",
                                    "Twinning Degree Programme",
                                    "Activities related to Bharatiya Bhasha Sanvardhan- encouragement for teaching in Indian and local language mediums, Textbooks, and content in Indian languages",
                                    "Entrepreneurship, Cocurricular, and Extension Activities as part of the Curriculum",
                                    "OJT/ Internship/ IPT ",
                                    "Apprenticeship Embedded Degree Programme ",
                                    "Multiple Entry-Multiple Exit (ME-ME)",
                                    "Professor/ Associate or Assistant Professor of Practice 18. Involvement of Artists and Field Professionals in Applied/ Visual/ Performing/ Fine Art Education",
                                    "Accommodation for Guru-Shishya Parampara and traditional learning (For Sanskrit University)",
                                    "NBA accreditation of Professional Programmes- 100% or partial, Accreditation for 6 or 3 years",
                                    "Compliance of Regulations/ Guidelines/ Standards/ Frameworks/Laws of Regulatory Bodies- PCI/ CoA/ BCI/ NCTE/ AICTE/ UGC/ Distance Education Bureau etc",
                                    "Any other Innovative NEP Initiative/ Professional Activity"

                                ];
                                foreach ($nep_items as $i => $label) {
                                    echo '<div class="col-md-6" ><div class="form-check mb-3">';
                                    echo '<input class="form-check-input mt-2" type="checkbox" name="nep_initiatives[]" value="' . htmlspecialchars($label) . '" id="nep' . $i . '">';
                                    echo '<label class="form-check-label fw-normal ms-2" for="nep' . $i . '">' . htmlspecialchars($label) . '</label>';
                                    echo '</div></div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Pedagogical Approaches -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2 fs-5">2. Teaching-Learning Pedagogical Approaches (Max
                                20
                                marks)</label>
                            <div class="row">
                                <?php
                                $ped_items = [
                                    "Blended Learning",
                                    "Research-based Learning /Teaching",
                                    "Problem-based Learning /Teaching",
                                    "Project-based Learning /Teaching",
                                    "Situational Learning (Action Research Project)",
                                    "Experiential /Practical Teaching Strategies",
                                    "Skill-based teaching/ Learning",
                                    "Exceptional Teaching Strategies",
                                    "Designing Learning Experiences",
                                    "Use of Technology in Teaching and Learning (LMS, Interactive Smart Board, Flipped Classroom, etc)",
                                    "Use of AI Tools for Personalised Learning Models and Inclusive Practices that cater to diverse learning styles and backgrounds",
                                    "Use of Specific Tools for Special Education/ Physically Challenged Learners",
                                    "Remedial Coaching Pedagogy",
                                    "Scholarly Learner-Centric Activities Beyond Classroom",
                                    "Finishing School Pedagogy",
                                    "Field/ Industrial visits, Study Tours",
                                    "Case Studies for Management Program",
                                    "Moot Court in Law",
                                    "Multisensory learning",
                                    "Gamification of Learning",
                                    "Art Integrated Learning",
                                    "Language-neutral content and delivery to enable students to learn in their native language with the use of real-time translation services",
                                    "Any other Innovative Pedagogical Approach"

                                ];
                                foreach ($ped_items as $i => $label) {
                                    echo '<div class="col-md-6"><div class="form-check mb-3">';
                                    echo '<input class="form-check-input" type="checkbox" name="pedagogical[]" value="' . htmlspecialchars($label) . '" id="ped' . $i . '">';
                                    echo '<label class="form-check-label fw-normal ms-2" for="ped' . $i . '">' . htmlspecialchars($label) . '</label>';
                                    echo '</div></div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Assessments -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2 fs-5">3. Student-Centric Assessments (Max 20
                                marks)</label>
                            <div class="row">
                                <?php
                                $assess_items = [
                                    "Assessment Rubrics",
                                    "Class Room Assessment Techniques",
                                    "Solving Exercises/ Tutorials",
                                    "Assessment of Problem-solving ability, Computational thinking",
                                    "Seminar/ Presentations, Viva-voce/ Oral Examination",
                                    "Group Tasks/Group Discussions/ Fishbowl Technique",
                                    "Weekly/ Interim Quiz Tests",
                                    "Open book examination",
                                    "Surprise Tests",
                                    "Portfolios and / E-Portfolios",
                                    "Classroom Response Systems",
                                    "Assessment of different skill levels including demonstration of Skills/ performance Demonstrations",
                                    "Assessment of Field Projects/ OJT/Internship",
                                    "Learning Outcome Attainment",
                                    "Competency Assessment",
                                    "Development of Question Bank",
                                    "Assessments powered by AIML for evaluation of skills and knowledge",
                                    "Digitization of Assessment Process",
                                    "Any other Assessment activity/ approach"

                                ];
                                foreach ($assess_items as $i => $label) {
                                    echo '<div class="col-md-6"><div class="form-check mb-3" style="margin-bottom: 0;">';
                                    echo '<input  class="form-check-input" type="checkbox" name="assessments[]" value="' . htmlspecialchars($label) . '" id="assess' . $i . '">';

                                    echo '<label class="form-check-label fw-normal ms-2" for="assess' . $i . '">' . htmlspecialchars($label) . '</label>';
                                    echo '</div></div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- MOOC Courses -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2 fs-5">4. MOOC Courses (Max 10 marks, 2 marks
                                each)</label>
                            <input type="number" name="moocs" class="form-control" min="0">
                        </div>

                        <!-- E-Content -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2 fs-5">5. E-Content Development Credits (Max 15
                                marks)</label>
                            <input type="number" step="0.1" name="econtent" class="form-control" min="0">
                        </div>

                        <!-- Result Declaration -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2 fs-5">6. Days taken for Result Declaration</label>
                            <input type="number" name="result_days" class="form-control" min="0">
                        </div>

                        <button type="submit" name="calculate_marks" class="btn btn-primary">Calculate & Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Show Entered Data -->
<div class="row my-5">
    <h3 class="fs-4 mb-3 text-center" id="msg"><b>NEP Initiatives Data Entered</b></h3>
    <div class="col">
        <div class="overflow-auto">
            <table class="table table-bordered table-striped bg-white rounded shadow-sm">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NEP Initiatives</th>
                        <th scope="col">Pedagogical Approaches</th>
                        <th scope="col">Assessments</th>
                        <th scope="col">MOOCs</th>
                        <th scope="col">E-Content</th>
                        <th scope="col">Result Days</th>
                        <th scope="col">Total Marks</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $Record = mysqli_query($conn, "SELECT * FROM NEPMarks");
                    while ($row = mysqli_fetch_array($Record)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['nep_count']} ({$row['nep_score']})</td>";
                        echo "<td>{$row['ped_count']} ({$row['ped_score']})</td>";
                        echo "<td>{$row['assess_count']} ({$row['assess_score']})</td>";
                        echo "<td>{$row['moocs']} ({$row['mooc_score']})</td>";
                        echo "<td>{$row['econtent']} ({$row['econtent_score']})</td>";
                        echo "<td>{$row['result_days']} ({$row['result_score']})</td>";
                        echo "<td>{$row['total_marks']}</td>";
                        echo "<td><a class='btn btn-sm btn-warning' href='NEPInitiatives.php?action=edit&ID={$row['id']}'>Edit</a></td>";
                        echo "<td><a class='btn btn-sm btn-danger' href='NEPInitiatives.php?action=delete&ID={$row['id']}' onclick=\"return confirm('Delete this record?');\">Delete</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>