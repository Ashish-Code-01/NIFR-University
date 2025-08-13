<?php
include 'config.php';
require "header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Simple sanitization for scalar fields
    $permanent_faculty_phd = (int) $_POST['permanent_faculty_phd'];
    $adhoc_faculty_phd = (int) $_POST['adhoc_faculty_phd'];
    $phd_awarded_count = (int) $_POST['phd_awarded_count'];
    $phd_awardee_names = mysqli_real_escape_string($conn, $_POST['phd_awardee_names']);
    $other_recognitions = mysqli_real_escape_string($conn, $_POST['other_recognitions']);
    $infra_funding = (float) $_POST['infra_funding'];
    $startups_registered = (int) $_POST['startups_registered'];
    $startups_incubated = (int) $_POST['startups_incubated'];
    $startup_names = mysqli_real_escape_string($conn, $_POST['startup_names']);
    $patents_filed = (int) $_POST['patents_filed'];
    $patents_published = (int) $_POST['patents_published'];
    $patents_granted = (int) $_POST['patents_granted'];
    $copyrights_granted = (int) $_POST['copyrights_granted'];
    $designs_granted = (int) $_POST['designs_granted'];
    $tot_count = (int) $_POST['tot_count'];
    $desc_initiative = mysqli_real_escape_string($conn, $_POST['desc_initiative']);
    $desc_impact = mysqli_real_escape_string($conn, $_POST['desc_impact']);
    $desc_collaboration = mysqli_real_escape_string($conn, $_POST['desc_collaboration']);
    $desc_plan = mysqli_real_escape_string($conn, $_POST['desc_plan']);
    $desc_recognition = mysqli_real_escape_string($conn, $_POST['desc_recognition']);

    // Arrays (dynamic sections) saved as JSON for now
    $awards = mysqli_real_escape_string($conn, json_encode($_POST['award_names'] ?? []));
    $projects = mysqli_real_escape_string($conn, json_encode($_POST['project_titles'] ?? []));
    $trainings = mysqli_real_escape_string($conn, json_encode($_POST['training_names'] ?? []));
    $publications = mysqli_real_escape_string($conn, json_encode($_POST['pub_titles'] ?? []));
    $bibliometrics = mysqli_real_escape_string($conn, json_encode($_POST['bib_teacher_names'] ?? []));
    $books = mysqli_real_escape_string($conn, json_encode($_POST['book_titles'] ?? []));
    $recognitions = mysqli_real_escape_string($conn, json_encode($_POST['recognitions'] ?? []));

    // ==== MARK CALCULATION ====
    $total_marks = 0;
    $breakdown = [];

    // Faculty with PhD (example: 1 mark each)
    $marks_faculty_phd = $permanent_faculty_phd + $adhoc_faculty_phd;
    $total_marks += $marks_faculty_phd;
    $breakdown[] = "Faculty with PhD: {$marks_faculty_phd} marks";

    // Recognitions: 2.5 marks each, max 5
    $recognitions_count = count($_POST['recognitions'] ?? []);
    $marks_recognitions = min($recognitions_count * 2.5, 5);
    $total_marks += $marks_recognitions;
    $breakdown[] = "Recognitions: {$marks_recognitions} marks";

    // Infra funding: 2 marks per 25 lakhs, max 10
    $marks_infra = min(floor($infra_funding / 25) * 2, 10);
    $total_marks += $marks_infra;
    $breakdown[] = "Infrastructure funding: {$marks_infra} marks";

    // Consultancy: 1 mark per 1 lakh
    $marks_consultancy = 0;
    if (!empty($_POST['project_types'])) {
        foreach ($_POST['project_types'] as $i => $type) {
            if (strtolower(trim($type)) === 'consultancy') {
                $amount = isset($_POST['project_amounts'][$i]) ? (float) $_POST['project_amounts'][$i] : 0;
                $marks_consultancy += $amount;
            }
        }
    }
    $total_marks += $marks_consultancy;
    $breakdown[] = "Consultancy projects: {$marks_consultancy} marks";

    // Startups (example: 2 marks per incubated)
    $marks_startups = $startups_incubated * 2;
    $total_marks += $marks_startups;
    $breakdown[] = "Startups: {$marks_startups} marks";

    // IPR scoring (example scheme)
    $marks_ipr = ($patents_granted * 3) + ($patents_published * 1) + ($copyrights_granted * 1);
    $total_marks += $marks_ipr;
    $breakdown[] = "IPR: {$marks_ipr} marks";

    // Citations: 1 mark per 100 citations
    $marks_citations = 0;
    if (!empty($_POST['bib_citations'])) {
        $total_citations = array_sum($_POST['bib_citations']);
        $marks_citations = floor($total_citations / 100);
    }
    $total_marks += $marks_citations;
    $breakdown[] = "Citations: {$marks_citations} marks";

    // MOOCs: 3 marks each
    $marks_moocs = count($_POST['mooc_names'] ?? []) * 3;
    $total_marks += $marks_moocs;
    $breakdown[] = "MOOCs (SWAYAM, MAHASWAYAM): {$marks_moocs} marks";

    // Books: 2 marks authored, 1 mark edited/chapters/translated
    $marks_books = 0;
    if (!empty($book_types)) {
        foreach ($book_types as $type) {
            $type = strtolower(trim($type));
            if ($type === 'authored') {
                $marks_books += 2;
            } elseif (in_array($type, ['edited', 'chapter', 'translated'])) {
                $marks_books += 1;
            }
        }
    }
    $total_marks += $marks_books;
    $breakdown[] = "Books (Authored/Edited): {$marks_books} marks";

    // Cap to 300
    $total_marks = min($total_marks, 300);
    $query = "INSERT INTO faculty_output (
        permanent_faculty_phd, adhoc_faculty_phd, phd_awarded_count, phd_awardee_names,
        recognitions, other_recognitions, infra_funding, startups_registered, startups_incubated, startup_names,
        patents_filed, patents_published, patents_granted, copyrights_granted,
        designs_granted, tot_count,
        awards, projects, trainings, publications, bibliometrics, books,
        desc_initiative, desc_impact, desc_collaboration, desc_plan, desc_recognition
    ) VALUES (
        '$permanent_faculty_phd','$adhoc_faculty_phd','$phd_awarded_count','$phd_awardee_names',
        '$recognitions','$other_recognitions','$infra_funding','$startups_registered','$startups_incubated','$startup_names',
        '$patents_filed','$patents_published','$patents_granted','$copyrights_granted',
        '$designs_granted','$tot_count',
        '$awards','$projects','$trainings','$publications','$bibliometrics','$books',
        '$desc_initiative','$desc_impact','$desc_collaboration','$desc_plan','$desc_recognition'
    )";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Entered.'); window.location.href='" . basename($_SERVER['PHP_SELF']) . "';</script>";
        echo "<div class='card my-4'>";
        echo "<div class='card-header bg-success text-white'>Marks Summary</div>";
        echo "<div class='card-body'>";
        echo "<h5>Total Marks: {$total_marks} / 300</h5>";
        echo "<ul>";
        foreach ($breakdown as $line) {
            echo "<li>{$line}</li>";
        }
        echo "</ul></div></div>";
        exit;
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = (int) $_GET['ID'];
    mysqli_query($conn, "DELETE FROM faculty_output WHERE id = '$id'");
    echo "<script>window.location.href='" . basename($_SERVER['PHP_SELF']) . "';</script>";
    exit;
}
?>
<div class="div">

    <body>
        <div class="container my-5">
            <h1 class="mb-4 text-center">Faculty Output, Research & Professional Activities</h1>
            <p class="text-muted text-center mb-5">Please fill out the details for the last academic year.</p>

            <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST">

                <fieldset class="mb-5">
                    <legend class="h5">1. Faculty PhD Details</legend>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="permanent_faculty_phd" class="form-label">Number of Permanent Faculties with
                                Ph.D</label>
                            <input type="number" class="form-control" id="permanent_faculty_phd"
                                name="permanent_faculty_phd" min="0" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="adhoc_faculty_phd" class="form-label">Number of Ad-hoc/Contract Teachers with
                                PhD</label>
                            <input type="number" class="form-control" id="adhoc_faculty_phd" name="adhoc_faculty_phd"
                                min="0" required>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-5">
                    <legend class="h5">2. Awards, Recognitions, and Fellowships</legend>
                    <div id="awards_container">
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addAward()">+ Add
                        Award/Fellowship</button>
                </fieldset>

                <fieldset class="mb-5">
                    <legend class="h5">3. PhDs Awarded</legend>
                    <div class="form-group">
                        <label for="phd_awarded_count" class="form-label">Number of Ph.D’s awarded at the Department
                            during
                            the last year</label>
                        <input type="number" class="form-control" id="phd_awarded_count" name="phd_awarded_count"
                            min="0">
                    </div>
                    <div class="form-group">
                        <label for="phd_awardee_names" class="form-label">Names of Ph.D Awardees
                            (comma-separated)</label>
                        <textarea class="form-control" id="phd_awardee_names" name="phd_awardee_names"
                            rows="3"></textarea>
                    </div>
                </fieldset>

                <fieldset class="mb-5">
                    <legend class="h5">4. Research & Consultancy Projects</legend>
                    <div id="projects_container">
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addProject()">+ Add Project</button>
                </fieldset>

                <fieldset class="mb-5">
                    <legend class="h5">5. Corporate Training Programs</legend>
                    <div id="training_container">
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addTraining()">+ Add Training
                        Program</button>
                </fieldset>

                <fieldset class="mb-5">
                    <legend class="h5">6. Recognitions & Infrastructure Development</legend>
                    <div class="form-group">
                        <label class="form-label">Department Recognitions by Government Agencies (UGC-SAP, DST-FIST,
                            etc.)</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="recognitions[]" value="UGC-SAP"
                                id="rec_ugc_sap">
                            <label class="form-check-label" for="rec_ugc_sap">UGC-SAP</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="recognitions[]" value="UGC-CAS"
                                id="rec_ugc_cas">
                            <label class="form-check-label" for="rec_ugc_cas">UGC-CAS</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="recognitions[]" value="DST-FIST"
                                id="rec_dst_fist">
                            <label class="form-check-label" for="rec_dst_fist">DST-FIST</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="recognitions[]" value="DBT"
                                id="rec_dbt">
                            <label class="form-check-label" for="rec_dbt">DBT</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="recognitions[]" value="ICSSR"
                                id="rec_icssr">
                            <label class="form-check-label" for="rec_icssr">ICSSR</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="other_recognitions" class="form-label">Any Other Recognitions
                            (comma-separated)</label>
                        <input type="text" class="form-control" id="other_recognitions" name="other_recognitions">
                    </div>
                    <div class="form-group">
                        <label for="infra_funding" class="form-label">Total Funding Received for Infrastructure
                            Development
                            (in INR Lakhs)</label>
                        <input type="number" step="0.01" class="form-control" id="infra_funding" name="infra_funding"
                            min="0">
                    </div>
                </fieldset>

                <fieldset class="mb-5">
                    <legend class="h5">7. Start-ups & Intellectual Property Rights (IPR)</legend>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="startups_registered" class="form-label">Number of start-ups registered</label>
                            <input type="number" class="form-control" id="startups_registered"
                                name="startups_registered" min="0">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="startups_incubated" class="form-label">Number of start-ups incubated
                                successfully</label>
                            <input type="number" class="form-control" id="startups_incubated" name="startups_incubated"
                                min="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="startup_names" class="form-label">Names of the Start-ups (comma-separated)</label>
                        <textarea class="form-control" id="startup_names" name="startup_names" rows="3"></textarea>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-md-4 form-group"><label for="patents_filed" class="form-label">Patents
                                Filed</label><input type="number" class="form-control" id="patents_filed"
                                name="patents_filed" min="0"></div>
                        <div class="col-md-4 form-group"><label for="patents_published" class="form-label">Patents
                                Published</label><input type="number" class="form-control" id="patents_published"
                                name="patents_published" min="0"></div>
                        <div class="col-md-4 form-group"><label for="patents_granted" class="form-label">Patents/IPR
                                Granted</label><input type="number" class="form-control" id="patents_granted"
                                name="patents_granted" min="0"></div>
                        <div class="col-md-4 form-group"><label for="copyrights_granted" class="form-label">Copyrights
                                Published/Granted</label><input type="number" class="form-control"
                                id="copyrights_granted" name="copyrights_granted" min="0"></div>
                        <div class="col-md-4 form-group"><label for="designs_granted" class="form-label">Designs
                                Published/Granted</label><input type="number" class="form-control" id="designs_granted"
                                name="designs_granted" min="0"></div>
                        <div class="col-md-4 form-group"><label for="tot_count" class="form-label">No. of Transfer of
                                Technology (ToT)</label><input type="number" class="form-control" id="tot_count"
                                name="tot_count" min="0"></div>
                    </div>
                </fieldset>

                <fieldset class="mb-5">
                    <legend class="h5">8. Research Publications (Journals & Conferences)</legend>
                    <div id="publications_container">
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addPublication()">+ Add
                        Publication</button>
                </fieldset>

                <fieldset class="mb-5">
                    <legend class="h5">9. Bibliometrics & h-index (Per Teacher)</legend>
                    <div id="bibliometrics_container">
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addBibliometric()">+ Add Teacher
                        Data</button>
                </fieldset>

                <fieldset class="mb-5">
                    <legend class="h5">10. Books, Chapters, and MOOCs</legend>
                    <div id="books_container">
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addBook()">+ Add
                        Book/Chapter/MOOC</button>
                </fieldset>

                <fieldset class="mb-5">
                    <legend class="h5">11. Descriptive Summaries & Future Plans</legend>
                    <div class="form-group">
                        <label for="desc_initiative" class="form-label">Major research or innovation initiative</label>
                        <textarea class="form-control" id="desc_initiative" name="desc_initiative" rows="6"
                            maxlength="1000" oninput="updateCounter(this, 'counter1')"></textarea>
                        <div id="counter1" class="char-counter">1000 characters remaining</div>
                    </div>
                    <div class="form-group">
                        <label for="desc_impact" class="form-label">Measurable impact of the initiative</label>
                        <textarea class="form-control" id="desc_impact" name="desc_impact" rows="6" maxlength="1000"
                            oninput="updateCounter(this, 'counter2')"></textarea>
                        <div id="counter2" class="char-counter">1000 characters remaining</div>
                    </div>
                    <div class="form-group">
                        <label for="desc_collaboration" class="form-label">Industry collaboration models</label>
                        <textarea class="form-control" id="desc_collaboration" name="desc_collaboration" rows="6"
                            maxlength="1000" oninput="updateCounter(this, 'counter3')"></textarea>
                        <div id="counter3" class="char-counter">1000 characters remaining</div>
                    </div>
                    <div class="form-group">
                        <label for="desc_plan" class="form-label">Plan to sustain and scale the initiative (next 2
                            years)</label>
                        <textarea class="form-control" id="desc_plan" name="desc_plan" rows="6" maxlength="1000"
                            oninput="updateCounter(this, 'counter4')"></textarea>
                        <div id="counter4" class="char-counter">1000 characters remaining</div>
                    </div>
                    <div class="form-group">
                        <label for="desc_recognition" class="form-label">Why should your department be recognized for
                            Excellence in Research & Innovation?</label>
                        <textarea class="form-control" id="desc_recognition" name="desc_recognition" rows="8"
                            maxlength="2000" oninput="updateCounter(this, 'counter5')"></textarea>
                        <div id="counter5" class="char-counter">2000 characters remaining</div>
                    </div>
                </fieldset>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                </div>
            </form>
        </div>

        <!-- Show Entered Data -->
        <div class="row my-5">
            <h3 class="fs-4 mb-3 text-center" id="msg"><b>Faculty Output Data Entered</b></h3>
            <div class="col">
                <div class="overflow-auto">
                    <table class="table table-bordered table-striped bg-white rounded shadow-sm">
                        <thead class="table-light font-weight-bold">
                            <tr>
                                <th scope="col">Faculty PhD (Permanent)</th>
                                <th scope="col">Faculty PhD (Ad-hoc)</th>
                                <th scope="col">PhDs Awarded</th>
                                <th scope="col">Awards/Fellowships</th>
                                <th scope="col">Recognitions</th>
                                <th scope="col">Infra Funding (Lakhs)</th>
                                <th scope="col">Startups Registered</th>
                                <th scope="col">Startups Incubated</th>
                                <th scope="col">Patents Filed</th>
                                <th scope="col">Patents Published</th>
                                <th scope="col">Patents Granted</th>
                                <th scope="col">Copyrights Granted</th>
                                <th scope="col">Designs Granted</th>
                                <th scope="col">ToT Count</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM faculty_output");
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>{$row['permanent_faculty_phd']}</td>";
                                echo "<td>{$row['adhoc_faculty_phd']}</td>";
                                echo "<td>{$row['phd_awarded_count']}</td>";
                                echo "<td>";
                                $awards = json_decode($row['awards'], true);
                                if ($awards && is_array($awards)) {
                                    foreach ($awards as $award) {
                                        echo htmlspecialchars($award) . "<br>";
                                    }
                                }
                                echo "</td>";
                                echo "<td>";
                                $recognitions = json_decode($row['recognitions'], true);
                                if ($recognitions && is_array($recognitions)) {
                                    foreach ($recognitions as $rec) {
                                        echo htmlspecialchars($rec) . "<br>";
                                    }
                                }
                                echo "</td>";
                                echo "<td>{$row['infra_funding']}</td>";
                                echo "<td>{$row['startups_registered']}</td>";
                                echo "<td>{$row['startups_incubated']}</td>";
                                echo "<td>{$row['patents_filed']}</td>";
                                echo "<td>{$row['patents_published']}</td>";
                                echo "<td>{$row['patents_granted']}</td>";
                                echo "<td>{$row['copyrights_granted']}</td>";
                                echo "<td>{$row['designs_granted']}</td>";
                                echo "<td>{$row['tot_count']}</td>";
                                echo "<td>
                            <a class='btn btn-sm btn-warning' href='FacultyOutput.php?action=edit&ID={$row['id']}'>Edit</a>
                            <a class='btn btn-sm btn-danger' href='FacultyOutput.php?action=delete&ID={$row['id']}' onclick=\"return confirm('Delete this record?');\">Delete</a>
                        </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function addEntry(containerId, htmlContent) {
                const container = document.getElementById(containerId);
                const newEntry = document.createElement('div');
                newEntry.className = 'dynamic-entry';
                newEntry.innerHTML = htmlContent;
                container.appendChild(newEntry);
            }

            function removeEntry(button) {
                button.closest('.dynamic-entry').remove();
            }

            function addAward() {
                const html = `
            <h5>New Award/Fellowship Entry</h5>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Full Name(s) of Recipient(s)</label>
                    <input type="text" class="form-control" name="award_names[]">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Level</label>
                    <select class="form-select" name="award_levels[]">
                        <option value="State">State</option>
                        <option value="National">National</option>
                        <option value="International">International</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Name of Award/Fellowship</label>
                <input type="text" class="form-control" name="award_titles[]">
            </div>
            <div class="row">
                 <div class="col-md-6 form-group">
                    <label class="form-label">Issuing Agency</label>
                    <input type="text" class="form-control" name="award_agencies[]">
                </div>
                <div class="col-md-4 form-group">
                    <label class="form-label">Date of Award</label>
                    <input type="date" class="form-control" name="award_dates[]">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-btn" onclick="removeEntry(this)">Remove</button>
                </div>
            </div>`;
                addEntry('awards_container', html);
            }

            function addProject() {
                const html = `
            <h5>New Project Entry</h5>
             <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Project Type</label>
                    <select class="form-select" name="project_types[]">
                        <option value="Govt-Sponsored">Government Sponsored Research</option>
                        <option value="Non-Govt-Sponsored">Non-Government Sponsored Research</option>
                        <option value="Consultancy">Consultancy</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Project Title</label>
                    <input type="text" class="form-control" name="project_titles[]">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Sponsoring/Consulting Agency</label>
                <input type="text" class="form-control" name="project_agencies[]">
            </div>
            <div class="form-group">
                <label class="form-label">Investigator/Consultant Name(s)</label>
                <textarea class="form-control" name="project_investigators[]" rows="2"></textarea>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="project_start_dates[]">
                </div>
                 <div class="col-md-4 form-group">
                    <label class="form-label">End Date</label>
                    <input type="date" class="form-control" name="project_end_dates[]">
                </div>
                 <div class="col-md-4 form-group">
                    <label class="form-label">Amount Sanctioned (INR Lakhs)</label>
                    <input type="number" step="0.01" class="form-control" name="project_amounts[]">
                </div>
            </div>
             <button type="button" class="btn btn-danger" onclick="removeEntry(this)">Remove</button>
            `;
                addEntry('projects_container', html);
            }

            function addTraining() {
                const html = `
            <h5>New Corporate Training Program</h5>
            <div class="form-group">
                <label class="form-label">Name of the Training Programme</label>
                <input type="text" class="form-control" name="training_names[]">
            </div>
            <div class="form-group">
                <label class="form-label">Corporate Name(s)</label>
                <input type="text" class="form-control" name="training_corps[]">
            </div>
             <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Revenue Generated (INR Lakhs)</label>
                    <input type="number" step="0.01" class="form-control" name="training_revenue[]">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Number of Participants</label>
                    <input type="number" class="form-control" name="training_participants[]">
                </div>
            </div>
             <button type="button" class="btn btn-danger" onclick="removeEntry(this)">Remove</button>
        `;
                addEntry('training_container', html);
            }

            function addPublication() {
                const html = `
            <h5>New Publication Entry</h5>
            <div class="row">
                 <div class="col-md-6 form-group">
                    <label class="form-label">Publication Type</label>
                     <select class="form-select" name="pub_types[]">
                        <option value="Journal">Journal</option>
                        <option value="Conference">Conference</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Title of Paper</label>
                    <input type="text" class="form-control" name="pub_titles[]">
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6 form-group">
                    <label class="form-label">Journal/Conference Name</label>
                    <input type="text" class="form-control" name="pub_venues[]">
                </div>
                 <div class="col-md-6 form-group">
                    <label class="form-label">Supported By (Scopus, WoS, IEEE, etc.)</label>
                    <input type="text" class="form-control" name="pub_indexed[]">
                </div>
            </div>
             <div class="form-group">
                <label class="form-label">Author(s) Name(s)</label>
                <textarea class="form-control" name="pub_authors[]" rows="2"></textarea>
            </div>
             <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Month and Year of Publication</label>
                    <input type="month" class="form-control" name="pub_dates[]">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">URL (if applicable)</label>
                    <input type="url" class="form-control" name="pub_urls[]">
                </div>
            </div>
            <button type="button" class="btn btn-danger" onclick="removeEntry(this)">Remove</button>
        `;
                addEntry('publications_container', html);
            }

            function addBibliometric() {
                const html = `
            <h5>New Teacher Bibliometric Data</h5>
             <div class="row">
                <div class="col-md-4 form-group">
                    <label class="form-label">Teacher's Name</label>
                    <input type="text" class="form-control" name="bib_teacher_names[]">
                </div>
                <div class="col-md-3 form-group">
                    <label class="form-label">Cumulative Impact Factor</label>
                    <input type="number" step="0.01" class="form-control" name="bib_impact_factors[]">
                </div>
                <div class="col-md-2 form-group">
                    <label class="form-label">Total Citations</label>
                    <input type="number" class="form-control" name="bib_citations[]">
                </div>
                <div class="col-md-1 form-group">
                    <label class="form-label">h-index</label>
                    <input type="number" class="form-control" name="bib_h_indexes[]">
                </div>
                 <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-btn" onclick="removeEntry(this)">Remove</button>
                </div>
            </div>
        `;
                addEntry('bibliometrics_container', html);
            }

            function addBook() {
                const html = `
            <h5>New Book/Chapter/MOOC Entry</h5>
             <div class="form-group">
                <label class="form-label">Type</label>
                <select class="form-select" name="book_types[]">
                    <option value="Authored Book">Authored Reference Book</option>
                    <option value="Edited Book">Edited Book</option>
                    <option value="Chapter">Chapter in Edited Volume</option>
                    <option value="Translated Book">Translated Book</option>
                    <option value="MOOC">MOOC</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="book_titles[]">
            </div>
            <div class="form-group">
                <label class="form-label">Author(s)/Editor(s)/Coordinator(s) Name(s)</label>
                <textarea class="form-control" name="book_authors[]" rows="2"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Publisher / Platform (e.g., SWAYAM, NPTEL)</label>
                <input type="text" class="form-control" name="book_publishers[]">
            </div>
            <button type="button" class="btn btn-danger" onclick="removeEntry(this)">Remove</button>
        `;
                addEntry('books_container', html);
            }

            function updateCounter(textarea, counterId) {
                const maxLength = textarea.getAttribute('maxlength');
                const currentLength = textarea.value.length;
                const remaining = maxLength - currentLength;
                document.getElementById(counterId).innerText = `${remaining} characters remaining`;
            }

            // Initialize one entry for each dynamic section to start with
            window.onload = function () {
                addAward();
                addProject();
                addTraining();
                addPublication();
                addBibliometric();
                addBook();
            };
        </script>
    </body>
</div>
<?php require "footer.php"; ?>