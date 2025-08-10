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
    $query = "INSERT INTO `NEPMarks`
(`nep_count`, `ped_count`, `assess_count`, `moocs`, `econtent`, `nep_score`, `ped_score`, `assess_score`, `mooc_score`, `econtent_score`, `result_days`, `result_score`, `total_marks`)
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
        echo '<script>window.location.href = "EmployerDetails.php";</script>';
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
                    <label class="form-label fw-bold mb-2">1. NEP Initiatives (Max 30 marks)</label>
                    <div class="row">
                        <?php
                        $nep_items = [
                            "Multidisciplinary Curriculum",
                            "Research Projects at PG/UG Honours",
                            "Subject-specific Skills Training",
                            "Open Electives",
                            "Value and Life Skills Education",
                            "Generic and Subject-Specific IKS",
                            "100% Adoption of ABC Credit Transfer",
                            "Community Engagement / Field Projects",
                            "Joint Degree Programme",
                            "Dual and Integrated Degree Programme",
                            "Twinning Degree Programme",
                            "Bharatiya Bhasha Sanvardhan Activities",
                            "Entrepreneurship & Extension Activities",
                            "OJT / Internship / IPT",
                            "Apprenticeship Embedded Degree",
                            "Multiple Entry-Multiple Exit",
                            "Professor/Associate of Practice",
                            "Involvement of Artists & Professionals",
                            "Guru-Shishya Parampara",
                            "NBA Accreditation",
                            "Compliance with Regulatory Bodies",
                            "Any other Innovative NEP Initiative"
                        ];
                        foreach ($nep_items as $i => $label) {
                            echo '<div class="col-md-6"><div class="form-check mb-3">';
                            echo '<input class="form-check-input mt-2" type="checkbox" name="nep_initiatives[]" value="' . htmlspecialchars($label) . '" id="nep' . $i . '">';


                            echo '<label class="form-check-label" for="nep' . $i . '">' . htmlspecialchars($label) . '</label>';
                            echo '</div></div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Pedagogical Approaches -->
                <div class="mb-4">
                    <label class="form-label fw-bold mb-2">2. Teaching-Learning Pedagogical Approaches (Max 20 marks)</label>
                    <div class="row">
                        <?php
                        $ped_items = [
                            "Blended Learning",
                            "Research-based Learning",
                            "Problem-based Learning",
                            "Project-based Learning",
                            "Situational Learning",
                            "Experiential Teaching Strategies",
                            "Skill-based Learning",
                            "Exceptional Teaching Strategies",
                            "Designing Learning Experiences",
                            "Use of Technology",
                            "Use of AI Tools",
                            "Special Education Tools",
                            "Remedial Coaching",
                            "Learner-Centric Activities",
                            "Finishing School Pedagogy",
                            "Field/Industrial Visits",
                            "Case Studies for Management",
                            "Moot Court in Law",
                            "Multisensory Learning",
                            "Gamification of Learning",
                            "Art Integrated Learning",
                            "Language-neutral Content",
                            "Any other Innovative Approach"
                        ];
                        foreach ($ped_items as $i => $label) {
                            echo '<div class="col-md-6"><div class="form-check mb-3">';
                            echo '<input class="form-check-input" type="checkbox" name="pedagogical[]" value="' . htmlspecialchars($label) . '" id="ped' . $i . '">';
                            echo '<label class="form-check-label" for="ped' . $i . '">' . htmlspecialchars($label) . '</label>';
                            echo '</div></div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Assessments -->
                <div class="mb-4">
                    <label class="form-label fw-bold mb-2">3. Student-Centric Assessments (Max 20 marks)</label>
                    <div class="row">
                        <?php
                        $assess_items = [
                            "Assessment Rubrics",
                            "Classroom Assessment Techniques",
                            "Solving Exercises/Tutorials",
                            "Problem-Solving Ability Assessment",
                            "Seminar/Presentations/Viva",
                            "Group Tasks/Discussions",
                            "Weekly Quiz Tests",
                            "Open Book Exams",
                            "Surprise Tests",
                            "Portfolios/E-Portfolios",
                            "Classroom Response Systems",
                            "Skills Demonstration",
                            "Assessment of Field Projects",
                            "Learning Outcome Attainment",
                            "Competency Assessment",
                            "Question Bank Development",
                            "AI/ML Powered Assessments",
                            "Digitization of Assessment Process",
                            "Other Assessment Approaches"
                        ];
                        foreach ($assess_items as $i => $label) {
                            echo '<div class="col-md-6"><div class="form-check mb-3" style="margin-bottom: 0;">';
                            echo '<input  class="form-check-input" type="checkbox" name="assessments[]" value="' . htmlspecialchars($label) . '" id="assess' . $i . '">';

                            echo '<label class="form-check-label" for="assess' . $i . '">' . htmlspecialchars($label) . '</label>';
                            echo '</div></div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- MOOC Courses -->
                <div class="mb-4">
                    <label class="form-label fw-bold mb-2">4. MOOC Courses (Max 10 marks, 2 marks each)</label>
                    <input type="number" name="moocs" class="form-control" min="0">
                </div>

                <!-- E-Content -->
                <div class="mb-4">
                    <label class="form-label fw-bold mb-2">5. E-Content Development Credits (Max 15 marks)</label>
                    <input type="number" step="0.1" name="econtent" class="form-control" min="0">
                </div>

                <!-- Result Declaration -->
                <div class="mb-4">
                    <label class="form-label fw-bold">6. Days taken for Result Declaration</label>
                    <input type="number" name="result_days" class="form-control" min="0">
                </div>

                <button type="submit" name="calculate_marks" class="btn btn-primary">Calculate & Save</button>
</div>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>

<?php require "footer.php"; ?>