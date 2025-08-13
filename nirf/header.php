<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_username'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit(); // Stop further execution
}

//Normal year wise logic
$year = date("Y");
$pyear = $year - 1;
$A_YEAR = $pyear . '-' . $year;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="/bootstrap-5.0.2-dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="./assets/css/styles.css" />
    <link rel="icon" href="assets/img/mumbai-university-removebg-preview.png" type="image/png">
    <title>MU NIRF PORTAL</title>

    <script>
        function validateForm() {
            var userInput = document.getElementById('userInput').value;

            // Check for potentially harmful characters
            var regex = /^[a-zA-Z0-9\s\-]+$/; // Allow letters, numbers, spaces, and hyphens
            if (!regex.test(userInput)) {
                alert('Invalid input. Please avoid using special characters.');
                return false;
            }

            // Other validation checks can be added based on your requirements

            return true; // Submit the form if validation passes
        }
    </script>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white sidebarr" id="sidebar-wrapper">

            <div class="sidebar-heading text-center py-4  primary-text fs-4 fw-bold text-uppercase border-bottom">
                <img src="assets/img/mumbai-university-removebg-preview.png" alt="Logo" height="85px" width="85px">
                <div>MU NIRF PORTAL</div>
            </div>

            <div class="list-group list-group-flush my-3">

                <a href="dashboard.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Dashboard</a>

                <a href="IntakeActualStrength.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Student
                    Intake & Acutual Strength</a>

                <a href="PlacementDetails.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Placement
                    Details Or Higher Studies</a>

                <a href="SalaryDetails.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Salary
                    Details</a>

                <a href="EmployerDetails.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Employer
                    Details</a>

                <a href="countryWiseStudent.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Country
                    Wise Student</a>

                <a href="phd.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>PHD
                    Details</a>

                <a href="FacultyDetails.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Faculty
                    Details</a>

                <a href="FacultyCount.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Faculty
                    Count</a>

                <a href="AcademicPeers.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Academic
                    Peers</a>

                <a href="InternationalFaculty.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>International
                    Faculty</a>

                <a href="ResearchStaff.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Research
                    Staff</a>

                <a href="PatentInfo.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Patent
                    Info</a>

                <a href="PatentDetailsIndividual.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Patent
                    Details Individual</a>

                <a href="ExecutiveDevelopment.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Executive
                    Development</a>

                <a href="SponsoredProjectDetails.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Sponsored
                    Project Details</a>

                <a href="ConsultancyProjects.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Consultancy
                    Projects</a>

                <a href="OnlineEducation.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Online
                    Education</a>

                <a href="DetailsOfDepartment.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Brief
                    Details of the Department </a>
                <a href="FacultyOutput.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Faculty
                    Output, Research and Professional Activities Details </a>
                <a href="NEPInitiatives.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>NEP
                    Initiatives, Teaching, Learning, and Assessment Process</a>
                <a href="Departmental_Governance.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Departmental
                    Governance and Practices</a>
                <a href="StudentSupport.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Student
                    Support, Achievements and Progression</a>
                <a href="ConferencesWorkshops.php"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i></i>Conferences,
                    Workshops, and Collaborations</a>

                <a href="logout.php"
                    class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i></i>Logout</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i><?php echo $_SESSION['admin_username'] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                <li><a class="dropdown-item" href="Changepwd.php">Change Password</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>