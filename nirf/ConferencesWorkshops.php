<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
$A_YEAR = date("Y");

// Initialize variables
$a = array_fill(1, 6, 0);
$b = array_fill(1, 5, 0);
$total_collab = 0;
$marks = 0;
$submitted = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get A section values
    for ($i = 1; $i <= 6; $i++) {
        $a[$i] = isset($_POST["a$i"]) ? intval($_POST["a$i"]) : 0;
    }
    // Get B section values
    for ($i = 1; $i <= 5; $i++) {
        $b[$i] = isset($_POST["b$i"]) ? intval($_POST["b$i"]) : 0;
    }
    // Calculate totals
    $total_collab = array_sum($b);
    $marks = min($total_collab * 2, 35);
    $submitted = true;

    // Save to MySQL
    // Check if a record for this year and department already exists
    $check_sql = "SELECT * FROM conferences_workshops WHERE DEPT_ID = ? AND A_YEAR = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("is", $dept, $A_YEAR);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Update existing record
        $update_sql = "UPDATE conferences_workshops SET 
            A1=?, A2=?, A3=?, A4=?, A5=?, A6=?, 
            B1=?, B2=?, B3=?, B4=?, B5?, 
            TOTAL_COLLAB=?, MARKS=? 
            WHERE DEPT_ID=? AND A_YEAR=?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param(
            "iiiiiiiiiiiisi",
            $a[1],
            $a[2],
            $a[3],
            $a[4],
            $a[5],
            $a[6],
            $b[1],
            $b[2],
            $b[3],
            $b[4],
            $b[5],
            $total_collab,
            $marks,
            $dept,
            $A_YEAR
        );
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Insert new record
        $insert_sql = "INSERT INTO conferences_workshops 
            (A_YEAR, DEPT_ID, A1, A2, A3, A4, A5, A6, B1, B2, B3, B4, B5, TOTAL_COLLAB, MARKS) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param(
            "siiiiiiiiiiiiii",
            $A_YEAR,
            $dept,
            $a[1],
            $a[2],
            $a[3],
            $a[4],
            $a[5],
            $a[6],
            $b[1],
            $b[2],
            $b[3],
            $b[4],
            $b[5],
            $total_collab,
            $marks
        );
        $insert_stmt->execute();
        $insert_stmt->close();
    }
    $stmt->close();
}
?>

<div class="container">
    <form method="post" padding="10px">
        <h1 class="text-center">Conferences, Workshops, and Collaborations</h1>
        <table style="background:white" class="text-center p-1" width="95%">
            <h2 style="margin-top:20px">A. Conferences, Workshops, STTP and Seminars</h2>
            <tr>
                <th>Sr. No.</th>
                <th>Particulars</th>
                <th>Number</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Number of Industry–Academia Innovative practices / Workshops conducted during the last year</td>
                <td><input type="number" name="a1" min="0" value="<?= $submitted ? $a[1] : '' ?>"></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Number of Workshops / STTP / Refresher or Orientation Programme Organized</td>
                <td><input type="number" name="a2" min="0" value="<?= $submitted ? $a[2] : '' ?>"></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Number of National Conferences / Seminars / Workshops organized</td>
                <td><input type="number" name="a3" min="0" value="<?= $submitted ? $a[3] : '' ?>"></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Number of International Conferences / Seminars / Workshops organized</td>
                <td><input type="number" name="a4" min="0" value="<?= $submitted ? $a[4] : '' ?>"></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Number of Teachers invited as speakers / resource persons / Session Chairs</td>
                <td><input type="number" name="a5" min="0" value="<?= $submitted ? $a[5] : '' ?>"></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Number of Teachers who presented at Conferences / Seminars / Workshops</td>
                <td><input type="number" name="a6" min="0" value="<?= $submitted ? $a[6] : '' ?>"></td>
            </tr>
        </table>

        <h2 style="margin-top:20px">B. Collaborations</h2>

        <table style="background:white" class="text-center p-1" width="95%">
            <tr>
                <th>Sr. No.</th>
                <th>Particulars</th>
                <th>Number</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Number of Industry collaborations for Programs and their output</td>
                <td><input type="number" name="b1" min="0" value="<?= $submitted ? $b[1] : '' ?>"></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Number of National Academic collaborations for Programs and their output</td>
                <td><input type="number" name="b2" min="0" value="<?= $submitted ? $b[2] : '' ?>"></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Number of Government / Semi-Government Collaboration Projects / Programs</td>
                <td><input type="number" name="b3" min="0" value="<?= $submitted ? $b[3] : '' ?>"></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Number of International Academic collaborations for Programs and their output</td>
                <td><input type="number" name="b4" min="0" value="<?= $submitted ? $b[4] : '' ?>"></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Number of Outreach / Social Activity Collaborations and their output</td>
                <td><input type="number" name="b5" min="0" value="<?= $submitted ? $b[5] : '' ?>"></td>
            </tr>
            <tr class="total">
                <td colspan="2">Total Collaborations</td>
                <td><?= $submitted ? $total_collab : '' ?></td>
            </tr>
            <tr class="total">
                <td colspan="2">Marks (2 marks per collaboration, max 35)</td>
                <td><?= $submitted ? $marks : '' ?></td>
            </tr>
        </table>
        <input type="submit" class="submit" value="Submit" name="submit" onclick="return Validate()">
    </form>
</div>

<!-- Show Entered Data -->
<div class="row my-5">
    <h3 class="fs-4 mb-3 text-center" id="msg"><b>Show Entire Data</b></h3>
    <div class="col">
        <div class="overflow-auto">
            <table class="table bg-white rounded shadow-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col">Academic Year</th>
                        <th scope="col">Department</th>
                        <th scope="col">A1</th>
                        <th scope="col">A2</th>
                        <th scope="col">A3</th>
                        <th scope="col">A4</th>
                        <th scope="col">A5</th>
                        <th scope="col">A6</th>
                        <th scope="col">B1</th>
                        <th scope="col">B2</th>
                        <th scope="col">B3</th>
                        <th scope="col">B4</th>
                        <th scope="col">B5</th>
                        <th scope="col">Total Collaborations</th>
                        <th scope="col">Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Example: Replace with your actual table and columns for storing conference/workshop data
                    $result = mysqli_query($conn, "SELECT * FROM conferences_workshops WHERE DEPT_ID = $dept ORDER BY A_YEAR DESC");
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $total_collab = $row['B1'] + $row['B2'] + $row['B3'] + $row['B4'] + $row['B5'];
                            $marks = min($total_collab * 2, 35);
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['A_YEAR']) ?></td>
                                <td><?= htmlspecialchars($row['DEPT_ID']) ?></td>
                                <td><?= htmlspecialchars($row['A1']) ?></td>
                                <td><?= htmlspecialchars($row['A2']) ?></td>
                                <td><?= htmlspecialchars($row['A3']) ?></td>
                                <td><?= htmlspecialchars($row['A4']) ?></td>
                                <td><?= htmlspecialchars($row['A5']) ?></td>
                                <td><?= htmlspecialchars($row['A6']) ?></td>
                                <td><?= htmlspecialchars($row['B1']) ?></td>
                                <td><?= htmlspecialchars($row['B2']) ?></td>
                                <td><?= htmlspecialchars($row['B3']) ?></td>
                                <td><?= htmlspecialchars($row['B4']) ?></td>
                                <td><?= htmlspecialchars($row['B5']) ?></td>
                                <td><?= $total_collab ?></td>
                                <td><?= $marks ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="15" class="text-center">No data found.</td></tr>';
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