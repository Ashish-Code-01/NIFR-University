<?php

include 'config.php';
require "header.php";

function h(?string $s): string
{
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}


function flat(mixed $data): string
{
    if (is_array($data)) {
        return implode(', ', $data);
    }
    return (string) $data;
}

$formData = [];
$errors = [];   // Stores validation or database errors.
$successMessage = ''; // Stores success message for display.
$editMode = false; // Flag to check if we are editing or creating.
$recordId = $_GET['id'] ?? null; // Get ID from URL for editing.

// Determine if we are in edit mode
if ($recordId && is_numeric($recordId)) {
    $editMode = true;
}

// --- DATA FETCH (FOR EDIT MODE) ---

if ($editMode) {
    // Use a prepared statement to securely fetch the record to prevent SQL injection.
    $stmt = $conn->prepare("SELECT * FROM department_data WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $recordId);
        $stmt->execute();
        $result = $stmt->get_result();
        $formData = $result->fetch_assoc();
        $stmt->close();

        // If no record is found, redirect with an error.
        if (!$formData) {
            // Using JS alerts is not ideal, but matches the original code's style.
            // A better approach is to show a message on the page.
            echo "<script>alert('Error: Record not found.'); window.location.href='StudentSupport.php';</script>";
            exit;
        }
    } else {
        // Handle preparation error
        $errors[] = "Database query failed: " . $conn->error;
    }
}

// --- FORM SUBMISSION (POST REQUEST HANDLING) ---

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define all expected fields to avoid undefined index notices.
    $fields = [
        'inclusive_practices' => flat($_POST['inclusive_practices'] ?? []),
        'inclusive_practices_details' => $_POST['inclusive_practices_details'] ?? '',
        'green_practices' => flat($_POST['green_practices'] ?? []),
        'green_practices_details' => $_POST['green_practices_details'] ?? '',
        'teachers_in_admin' => $_POST['teachers_in_admin'] ?? 0,
        'awards_extension' => $_POST['awards_extension'] ?? 0,
        'heads_expenditure' => $_POST['heads_expenditure'] ?? '',
        'alumni_contribution' => $_POST['alumni_contribution'] ?? 0.0,
        'alumni_details' => $_POST['alumni_details'] ?? '',
        'csr_details' => $_POST['csr_details'] ?? '',
        'infrastructure_details' => $_POST['infrastructure_details'] ?? '',
        'peer_perception_rate' => $_POST['peer_perception_rate'] ?? '',
        'peer_perception_notes' => $_POST['peer_perception_notes'] ?? '',
        'student_feedback_rate' => $_POST['student_feedback_rate'] ?? '',
        'student_feedback_notes' => $_POST['student_feedback_notes'] ?? '',
        'best_practice' => $_POST['best_practice'] ?? '',
        'leadership_sync' => $_POST['leadership_sync'] ?? '',
        'isr_total' => $_POST['isr_total'] ?? 0,
        'isr_budget_percent' => $_POST['isr_budget_percent'] ?? 0.0,
        'isr_students_percent' => $_POST['isr_students_percent'] ?? 0.0,
        'isr_faculty_percent' => $_POST['isr_faculty_percent'] ?? 0.0,
        'sponsors_total' => $_POST['sponsors_total'] ?? 0,
        'sponsors_amount' => $_POST['sponsors_amount'] ?? 0.0,
        'isr_volunteer_hours' => $_POST['isr_volunteer_hours'] ?? 0,
        'isr_active_partnerships' => $_POST['isr_active_partnerships'] ?? 0,
        'isr_partners_notes' => $_POST['isr_partners_notes'] ?? ''
    ];

    // The submitted data is now the current form data
    $formData = $fields;

    if ($editMode) {
        // --- UPDATE LOGIC ---
        $fieldNames = array_keys($fields);
        $updatePlaceholders = implode(' = ?, ', $fieldNames) . ' = ?';
        $updateQuery = "UPDATE department_data SET $updatePlaceholders WHERE id = ?";

        $stmt = $conn->prepare($updateQuery);
        if ($stmt) {
            $types = str_repeat('s', count($fields)) . 'i';
            $values = array_values($fields);
            $values[] = $recordId; // Add the ID for the WHERE clause

            $stmt->bind_param($types, ...$values);
            if ($stmt->execute()) {
                $successMessage = "Record updated successfully!";
            } else {
                $errors[] = "Database update failed: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Prepare failed for update: " . $conn->error;
        }
    } else {
        // --- INSERT LOGIC ---
        $fieldNames = implode(', ', array_keys($fields));
        $placeholders = rtrim(str_repeat('?,', count($fields)), ',');
        $insertQuery = "INSERT INTO department_data ($fieldNames) VALUES ($placeholders)";

        $stmt = $conn->prepare($insertQuery);
        if ($stmt) {
            $types = str_repeat('s', count($fields));
            $stmt->bind_param($types, ...array_values($fields));
            if ($stmt->execute()) {
                $successMessage = "Record saved successfully!";
                $newId = $conn->insert_id;
                // Optional: Redirect to edit page of the new record
                // header("Location: ?id=$newId");
                // exit;
            } else {
                $errors[] = "Database insert failed: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Prepare failed for insert: " . $conn->error;
        }
    }
}

// For populating checkboxes, convert the comma-separated string back to an array.
$inclusivePracticesSelected = isset($formData['inclusive_practices']) ? explode(', ', $formData['inclusive_practices']) : [];
$greenPracticesSelected = isset($formData['green_practices']) ? explode(', ', $formData['green_practices']) : [];

?>

<!-- HTML FORM -->
<div class="container-fluid mt-3 mb-3">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0 text-center">
                        <?php echo $editMode ? 'Edit Departmental Governance Initiatives' : 'Add Departmental Governance Initiatives'; ?>
                    </h4>
                </div>
                <div class="card-body p-4">

                    <!-- Display Success/Error Messages -->
                    <?php if ($successMessage): ?>
                        <div class="alert alert-success"><?php echo h($successMessage); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <strong>Error(s):</strong><br>
                            <?php foreach ($errors as $error): ?>
                                - <?php echo h($error); ?><br>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?php echo h($_SERVER['REQUEST_URI']); ?>">
                        <!-- Fieldset 1: Inclusive Practices -->
                        <fieldset class="mb-4 p-3 border rounded">
                            <legend class=" px-2">1. Inclusive Practices and Support Initiatives</legend>
                            <?php
                            $inclusive_options = [
                                'Support Mechanism for Socially Disadvantaged Students and Employees',
                                'Initiatives on the Safety of Female Students and Employees, Regular Working of WDC and ICC',
                                'Facilities for Physically Challenged Students and Employees (RAMP, Lift, Toilet, etc)',
                                'Support Mechanism for Transgender Students and Employee',
                                'Support Mechanism for newly inducted/ young teachers',
                                'Psychological Counselling for Well-being of Students',
                                'Career Counselling',
                                "Students' Grievance Redressal Cell",
                                'Department Academic Integrity Panel',
                                'Any other Inclusive Practice'
                            ];
                            foreach ($inclusive_options as $opt):
                                $id = 'inclusive_' . str_replace([' ', '/'], '_', $opt);
                                $isChecked = in_array($opt, $inclusivePracticesSelected);
                                ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="inclusive_practices[]"
                                        value="<?php echo h($opt); ?>" id="<?php echo h($id); ?>" <?php echo $isChecked ? 'checked' : ''; ?>>
                                    <label class="form-check-label"
                                        for="<?php echo h($id); ?>"><?php echo h($opt); ?></label>
                                </div>
                            <?php endforeach; ?>
                            <div class="mb-3 mt-3">
                                <label for="inclusive_practices_details" class="form-label">Details of activities (if
                                    any):</label>
                                <textarea class="form-control" id="inclusive_practices_details"
                                    name="inclusive_practices_details"
                                    rows="3"><?php echo h($formData['inclusive_practices_details'] ?? ''); ?></textarea>
                            </div>
                        </fieldset>

                        <!-- Fieldset 2: Green Practices -->
                        <fieldset class="mb-4 p-3 border rounded">
                            <legend class="px-2">2. Green / Sustainability Practices</legend>
                            <?php
                            $green_options = [
                                'Solid waste management including facilities for Separation of Dry and Wet Waste',
                                'Liquid waste management',
                                'E-waste management',
                                'Paper waste management',
                                'Fire safety Management and Training',
                                'Rainwater harvesting structures and utilization at the department',
                                'Students and Staff using Bicycles',
                                'Solar or Renewable Energy Usage',
                                'Plastic free department',
                                'Paperless office',
                                'Green landscaping with trees and plants',
                                'Water and Energy Saving/ Conserving Practices',
                                'Heritage Conservation',
                                'Biodiversity Conservation',
                                'Energy Conservation',
                                'Any other Green Initiative and Practice to reduce Carbon Footprint'
                            ];
                            foreach ($green_options as $opt):
                                $id = 'green_' . str_replace([' ', '/'], '_', $opt);
                                $isChecked = in_array($opt, $greenPracticesSelected);
                                ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="green_practices[]"
                                        value="<?php echo h($opt); ?>" id="<?php echo h($id); ?>" <?php echo $isChecked ? 'checked' : ''; ?>>
                                    <label class="form-check-label"
                                        for="<?php echo h($id); ?>"><?php echo h($opt); ?></label>
                                </div>
                            <?php endforeach; ?>
                            <div class="mb-3 mt-3">
                                <label for="green_practices_details" class="form-label">Details of activities (if
                                    any):</label>
                                <textarea class="form-control" id="green_practices_details"
                                    name="green_practices_details"
                                    rows="3"><?php echo h($formData['green_practices_details'] ?? ''); ?></textarea>
                            </div>
                        </fieldset>

                        <!-- Fieldset 3: Numeric Inputs -->
                        <fieldset class="mb-4 p-3 border rounded">
                            <legend class=" px-2">3–10: Numeric / Short inputs</legend>
                            <div class="mb-3">
                                <label for="teachers_in_admin" class="form-label">3. Number of teachers involved in
                                    University and Government Administrative authorities/bodies:</label>
                                <input type="number" class="form-control" id="teachers_in_admin"
                                    name="teachers_in_admin"
                                    value="<?php echo h($formData['teachers_in_admin'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="awards_extension" class="form-label">4. Number of awards and recognitions
                                    received for extension activities from Government / recognized bodies during the
                                    last year:</label>
                                <input type="number" class="form-control" id="awards_extension" name="awards_extension"
                                    value="<?php echo h($formData['awards_extension'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="heads_expenditure" class="form-label">5. Budgetary Allocation of the
                                    Department and Expenditure (Heads of expenditure with allocation and
                                    utilization):</label>
                                <textarea class="form-control" id="heads_expenditure" name="heads_expenditure"
                                    rows="3"><?php echo h($formData['heads_expenditure'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="alumni_contribution" class="form-label">6. Alumni contribution/ Funding
                                    Support during the previous year (INR):</label>
                                <input type="number" step="0.01" class="form-control" id="alumni_contribution"
                                    name="alumni_contribution"
                                    value="<?php echo h($formData['alumni_contribution'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="alumni_details" class="form-label">Alumni Details and donation (names /
                                    notes):</label>
                                <input type="text" class="form-control" id="alumni_details" name="alumni_details"
                                    value="<?php echo h($formData['alumni_details'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="csr_details" class="form-label">7. CSR and Philanthropic Funding support to
                                    the Department during the previous year (Company name(s) and amount):</label>
                                <textarea class="form-control" id="csr_details" name="csr_details"
                                    rows="2"><?php echo h($formData['csr_details'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="infrastructure_details" class="form-label">8. Efforts taken for
                                    Strengthening/ Augmentation of Departmental infra, IT, Library, Lab (previous year
                                    vs last 5 years):</label>
                                <textarea class="form-control" id="infrastructure_details" name="infrastructure_details"
                                    rows="3"><?php echo h($formData['infrastructure_details'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="peer_perception_rate" class="form-label">9. Perception from
                                    Industry/Employers and Academia (PEER) during the last year (rate or notes):</label>
                                <input type="text" class="form-control" id="peer_perception_rate"
                                    name="peer_perception_rate"
                                    value="<?php echo h($formData['peer_perception_rate'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="peer_perception_notes" class="form-label">Notes on Employer / Academic peer
                                    perception:</label>
                                <textarea class="form-control" id="peer_perception_notes" name="peer_perception_notes"
                                    rows="2"><?php echo h($formData['peer_perception_notes'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="student_feedback_rate" class="form-label">10. Students' Feedback about
                                    Teachers and Department (rate):</label>
                                <input type="text" class="form-control" id="student_feedback_rate"
                                    name="student_feedback_rate"
                                    value="<?php echo h($formData['student_feedback_rate'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="student_feedback_notes" class="form-label">Notes on student
                                    feedback:</label>
                                <textarea class="form-control" id="student_feedback_notes" name="student_feedback_notes"
                                    rows="2"><?php echo h($formData['student_feedback_notes'] ?? ''); ?></textarea>
                            </div>
                        </fieldset>

                        <!-- Fieldset 4: Best Practice -->
                        <fieldset class="mb-4 p-3 border rounded">
                            <legend class=" px-2">11–12: Best Practice / Leadership (100 words each)</legend>
                            <div class="mb-3">
                                <label for="best_practice" class="form-label">11. Best Practice/ Unique Activity of the
                                    Department (Max. 100 Words):</label>
                                <textarea class="form-control" id="best_practice" name="best_practice" rows="4"
                                    maxlength="700"><?php echo h($formData['best_practice'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="leadership_sync" class="form-label">12. Details of initiatives to ensure
                                    synchronization, leadership, teamwork (Max 100 words):</label>
                                <textarea class="form-control" id="leadership_sync" name="leadership_sync" rows="4"
                                    maxlength="700"><?php echo h($formData['leadership_sync'] ?? ''); ?></textarea>
                            </div>
                        </fieldset>

                        <!-- Fieldset 5: ISR and Sponsors -->
                        <fieldset class="mb-4 p-3 border rounded">
                            <legend class=" px-2">13–21: ISR and Sponsors</legend>
                            <div class="mb-3">
                                <label for="isr_total" class="form-label">13. Total number of ISR initiatives the
                                    institution has participated:</label>
                                <input type="number" class="form-control" id="isr_total" name="isr_total"
                                    value="<?php echo h($formData['isr_total'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="isr_budget_percent" class="form-label">14. % of the budget allocated for ISR
                                    initiatives out of the total annual budget:</label>
                                <input type="number" step="0.01" class="form-control" id="isr_budget_percent"
                                    name="isr_budget_percent"
                                    value="<?php echo h($formData['isr_budget_percent'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="isr_students_percent" class="form-label">15. % of students participating in
                                    ISR initiatives:</label>
                                <input type="number" step="0.01" class="form-control" id="isr_students_percent"
                                    name="isr_students_percent"
                                    value="<?php echo h($formData['isr_students_percent'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="isr_faculty_percent" class="form-label">16. % of faculty participating in
                                    ISR initiatives:</label>
                                <input type="number" step="0.01" class="form-control" id="isr_faculty_percent"
                                    name="isr_faculty_percent"
                                    value="<?php echo h($formData['isr_faculty_percent'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="sponsors_total" class="form-label">17. Total number of sponsors
                                    received:</label>
                                <input type="number" class="form-control" id="sponsors_total" name="sponsors_total"
                                    value="<?php echo h($formData['sponsors_total'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="sponsors_amount" class="form-label">18. Total sponsor amount (in
                                    INR):</label>
                                <input type="number" step="0.01" class="form-control" id="sponsors_amount"
                                    name="sponsors_amount" value="<?php echo h($formData['sponsors_amount'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="isr_volunteer_hours" class="form-label">19. Estimated total volunteer hours
                                    contributed by students and faculty toward ISR initiative(s):</label>
                                <input type="number" class="form-control" id="isr_volunteer_hours"
                                    name="isr_volunteer_hours"
                                    value="<?php echo h($formData['isr_volunteer_hours'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="isr_active_partnerships" class="form-label">20. Number of active industry or
                                    academic partnerships contributing to ISR initiatives:</label>
                                <input type="number" class="form-control" id="isr_active_partnerships"
                                    name="isr_active_partnerships"
                                    value="<?php echo h($formData['isr_active_partnerships'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="isr_partners_notes" class="form-label">21. Briefly name key partners or
                                    describe the nature of collaborations— Max 30 words:</label>
                                <input type="text" class="form-control" id="isr_partners_notes"
                                    name="isr_partners_notes"
                                    value="<?php echo h($formData['isr_partners_notes'] ?? ''); ?>">
                            </div>
                        </fieldset>

                        <button type="submit" class="btn btn-success mt-3">
                            <?php echo $editMode ? 'Update' : 'Submit Details'; ?>

                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

<?php
// Include your footer file
require "footer.php";
?>