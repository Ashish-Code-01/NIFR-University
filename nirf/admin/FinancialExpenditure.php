<?php
session_start();
include '../config.php';

//Normal year wise logic
$year= date("Y");
$pyear= $year - 1;
$A_YEAR= $pyear . '-' . $year;

$dept = $_SESSION['dept_id'];
    
if (isset($_POST['submit'])){

    $Male_Students_FT=$_POST['Male_Students_FT'];

    $query="INSERT INTO `phd_details`(`A_YEAR`, `DEPT_ID`, `FULL_TIME_MALE_STUDENTS`, `FULL_TIME_FEMALE_STUDENTS`, `PART_TIME_MALE_STUDENTS`, `PART_TIME_FEMALE_STUDENTS`, `PHD_AWARDED_MALE_STUDENTS_FULL`, `PHD_AWARDED_FEMALE_STUDENTS_FULL`, `PHD_AWARDED_MALE_STUDENTS_PART`,`PHD_AWARDED_FEMALE_STUDENTS_PART`) 
    VALUES ('$A_YEAR', '$dept','$Male_Students_FT','$Female_Students_FT','$Male_Students_PT', '$Female_Students_PT', '$Male_Students_AWD_FT', '$Female_Students_AWD_FT', '$Male_Students_AWD_PT', '$Female_Students_AWD_PT')";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not able to execute $query. " . mysqli_error($conn);
    }
}    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="/bootstrap-5.0.2-dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="icon" href="../assets/img/mumbai-university-removebg-preview.png" type="image/png">
    <title>MU NIRF PORTAL</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                    ></i>MU NIRF PORTAL</div>
            <div class="list-group list-group-flush my-3">
                <a  class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        ></i>Dashboard</a>
                <a href="FinancialExpenditure.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        ></i>Financial Expenditure</a>
                <a href="../logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                       ></i>Logout</a>
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
                                <i class="fas fa-user me-2"></i><?php echo $_SESSION['admin_username']?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="mb-3">
                    <p class="text-center fs-4 ">Financial Expenditure</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        Academic Year
                    </label>
                    <input type="year" name="year" value="<?php echo $A_YEAR?>" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    <h5><b>Financial Resources: Utilised Amount for the Capital & Operational expenditure</b></h5>
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    <h5 style="color:red;"><b> i) Annual Capital Expenditure on Academic Activities and Resources (excluding expenditure on buildings)</b></h5>
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    <h5 style="color:red;"><b> Financial Year 2022-23</b></h5>
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Library
                    </label>
                    <input type="number" name="library" class="form-control" placeholder="Enter Amount spent" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    New Equipement for Laborities
                    </label>
                    <input type="number" name="laboratory" class="form-control" placeholder="Enter Amount spent" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    Engineering Workshops
                    </label>
                    <input type="number" name="Engineering Workshops" class="form-control" placeholder="Enter Amount spent" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    Studios
                    </label>
                    <input type="number" name="studios" class="form-control" placeholder="Enter Amount spent" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    Other expenditure on creation of Capital Assets (excluding expenditure on Land and Building)
                    </label>
                    <input type="number" name="other expenditure" class="form-control" placeholder="Enter Amount spent" required>
                </div>


                <div class="mb-3">
                    <label class="form-label">
                    <h5 style="color:red;"><b>  ii) Annual Operational Expenditure</b></h5>
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    <h5 style="color:red;"><b> Financial Year 2022-23</b></h5>
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    Salaries (Teaching and Non Teaching staff)
                    </label>
                    <input type="number" name="salary" class="form-control" placeholder="Enter Amount spent" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    Maintenance of Academic Infrastructure or consumables,  running expenditures etc. (excluding maintenance of hostels and allied services)
                    </label>
                    <input type="number" name="Maintenance of Academic" class="form-control" placeholder="Enter Amount spent" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                    Seminars/Conferences/Workshops
                    </label>
                    <input type="number" name="Seminars/Conferences/Workshops" class="form-control" placeholder="Enter Amount spent" required>
                </div>
                
                <input type="submit" class="submit" value="Submit" name="submit" onclick="return Validate()">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
</body>

</html>