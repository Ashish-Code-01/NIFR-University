<?php
session_start();

include '../config.php';
include '../PERMISSION.php';
checkPermission('admin');

error_reporting(E_ALL);

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

session_regenerate_id(true);

// Database Connection
$database = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'test' // Replace with your actual database name
];

// $tables = ['intake_actual_strength', 'financial_expenditure']; // Add more tables if needed
$tables = ['intake_actual_strength', 'phd_details', 'placement_details', 'faculty_details', 'faculty_count', 
            'academic_peers', 'inter_faculty', 'sponsored_project_details', 'research_staff', 'patent_details', 
            'patent_info', 'exec_dev', 'consultancy_projects', 'employers_details', 'country_wise_student', 
            'salary_details', 'online_education_details'];

$years = [];

$conn = new mysqli($database['host'], $database['user'], $database['pass'], $database['name']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_set_charset($conn, 'utf8mb4'); // Ensure proper encoding

// Fetch years from multiple tables
foreach ($tables as $table) {
    // Check if the table exists
    $checkTableQuery = "SHOW TABLES LIKE '$table'";
    $tableExists = $conn->query($checkTableQuery);

    if ($tableExists->num_rows > 0) {
        // Check if A_YEAR column exists
        $query = "SHOW COLUMNS FROM `$table` LIKE 'A_YEAR'";
        $columnExists = $conn->query($query);
        
        if ($columnExists->num_rows > 0) {
            $query = "SELECT DISTINCT A_YEAR FROM `$table` ORDER BY A_YEAR DESC";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                if (!empty($row['A_YEAR'])) { 
                    $years[] = $row['A_YEAR'];
                }
            }            
        }
    }
}


$conn->close();

// Remove duplicate years and sort
$years = array_unique($years);
rsort($years);

// Debugging: Uncomment this to check the values in the array
// echo "<pre>";
// print_r($years);
// echo "</pre>";
// exit();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="icon" href="../assets/img/mumbai-university-removebg-preview.png" type="image/png">
    <title>MU NIRF PORTAL</title>
</head>

<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                <a href="Dashboard.php"><img src="../assets/img/mumbai-university-removebg-preview.png" alt="Logo" height="85px" width="85px"></a>
                <div>MU NIRF PORTAL</div>
            </div>

            <div class="list-group list-group-flush my-3">
                <a href="Dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    Dashboard</a>
                <a href="FinancialExpenditure.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    Financial Expenditure</a>
                <a href="../logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">
                    Logout</a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard</h2>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i><?php echo $_SESSION['admin_username'] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">
                <h4 class="mt-4">Hello, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h4>

                <!-- Outer Card -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title"><b>Admin Dashboard</b></h5>
                        <div class="row">

                            <!-- Smaller Box (1/3 width) -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border border-dark"> <!-- Added border classes -->
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <form action="download.php" method="get" class="w-100 text-center">
                                            <label for="downloadButton" class="form-label"><b>Download the Data:</b></label>
                                            <hr>
                                            <label for="year" class="form-label"><b>Select Year:</b></label>

                                            <select name="year" id="year" class="form-select me-2" style="width: 150px;">
                                                <option value="all" selected>All</option>
                                                <?php foreach ($years as $year) { ?>
                                                    <option value="<?php echo $year; ?>">
                                                        <?php echo $year; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>

                                            </hr>
                                            <button type="submit" id="downloadButton" class="btn btn-primary">Download</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Smaller Box (2/3 width) -->
                            <div class="col-md-8 mb-4">
                                <div class="card h-100 border border-dark"> <!-- Added border classes -->
                                    <div class="card-body d-flex flex-column justify-content-center">
                                        <form method="POST" action="send_invitation.php" class="w-100">
                                            <label for="email" class="form-label"><b>Invite User: </b></label>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter User Email" required>
                                            <button type="submit" class="btn btn-success mt-2">Send Invitation</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function() {
            el.classList.toggle("toggled");
        };
    </script>
</body>

</html>