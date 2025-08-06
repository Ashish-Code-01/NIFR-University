<?php
include 'config.php';
require "header.php";
    
$dept = $_SESSION['dept_id'];

if (isset($_POST['submit'])){

    $patent_application_number=$_POST['patent_application_number'];
    $status_of_patent=$_POST['status_of_patent'];
    $Inventors_name=$_POST['Inventors_name'];
    $Title_of_the_patent=$_POST['Title_of_the_patent'];
    $Applicant_Name=$_POST['Applicant_Name'];
    $Patent_Filed=$_POST['Patent_Filed'];
    $Patent_published_date=$_POST['Patent_published_date'];
    $Patent_granted_date=$_POST['Patent_granted_date'];
    $Patent_publication_number=$_POST['Patent_publication_number'];
    $Assignee_Name=$_POST['Assignee_Name'];
    $URL=$_POST['URL'];

    $query="INSERT INTO `patent_details`(`A_YEAR`, `DEPT_ID`, `PATENT_APPLICATION_NO`, `STATUS_OF_PATENT`, `INVENTOR_NAME`, `TITLE_OF_PATENT`, `APPLICANT_NAME`, `PATENT_FILED_DATE`, `PATENT_PUBLISHED_DATE`, `PATENT_GRANTED_DATE`, `PATENT_PUBLICATION_NUMBER`, `ASIGNEES_NAME`, `URL`) 
    VALUES ('$A_YEAR', '$dept','$patent_application_number','$status_of_patent','$Inventors_name', '$Title_of_the_patent', '$Applicant_Name', '$Patent_Filed', '$Patent_published_date', '$Patent_granted_date', '$Patent_publication_number', '$Assignee_Name', '$URL')
    ON DUPLICATE KEY UPDATE
    STATUS_OF_PATENT = VALUES(STATUS_OF_PATENT),
    INVENTOR_NAME = VALUES(INVENTOR_NAME),
    TITLE_OF_PATENT = VALUES(TITLE_OF_PATENT),
    APPLICANT_NAME = VALUES(APPLICANT_NAME),
    PATENT_FILED_DATE = VALUES(PATENT_FILED_DATE),
    PATENT_PUBLISHED_DATE = VALUES(PATENT_PUBLISHED_DATE),
    PATENT_GRANTED_DATE = VALUES(PATENT_GRANTED_DATE),
    PATENT_PUBLICATION_NUMBER = VALUES(PATENT_PUBLICATION_NUMBER),
    ASIGNEES_NAME = VALUES(ASIGNEES_NAME),
    URL = VALUES(URL)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "PatentDetailsIndividual.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from patent_details where ID = '$id'");
        echo '<script>window.location.href = "PatentDetailsIndividual.php";</script>';
    }
} 
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 "><b>Patent Details Individual</b></p>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
                    <input type="text" name="year" value="<?php echo $A_YEAR?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
                    <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Patent Application Number</b></label>
                    <input type="text" name="patent_application_number" class="form-control" placeholder="Enter patent application number" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Status of patent</b></label>
                    <select name="status_of_patent" class="form-control" style="margin-top: 0;">
                        <option value="FILED">FILED</option>
                        <option value="GRANTED">GRANTED</option>
                        <option value="PUBLISHED">PUBLISHED</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Inventor's Name</b></label>
                    <input type= "text" name="Inventors_name" class="form-control" placeholder="Enter Name" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Title of the patent</b></label>
                    <input type="text" name="Title_of_the_patent" class="form-control" placeholder="Enter title of the patent" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Applicant Name</b></label>
                    <input type="text" name="Applicant_Name" class="form-control" placeholder="Enter applicant name" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Patent Filed Date</b></label>
                    <input type="date" name="Patent_Filed" class="form-control" placeholder="Enter patent filed date " style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Patent published date</b></label>
                    <input type="date" name="Patent_published_date" class="form-control" placeholder="Enter patent published date " style="margin-top: 0;">
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Patent granted date</b></label>
                    <input type="date" name="Patent_granted_date" class="form-control" placeholder="Enter patent published date " style="margin-top: 0;">
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Patent publication number</b></label>
                    <input type= "Number" name="Patent_publication_number" class="form-control" placeholder="Enter patent publication number " style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Assignee's Name</b></label>
                    <input type= "text" name="Assignee_Name" class="form-control" placeholder="Enter Assignee's Name" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>URL</b></label>
                    <input type= "text" name="URL" class="form-control" placeholder="Enter URL or website's link" style="margin-top: 0;" required>
                </div>

                <input type="submit" class="submit" value="Submit" name="submit" onclick="return Validate()">
            </form>
        </div>

         <!-- Show Entered Data -->
    <div class="row my-5" >
    <h3 class="fs-4 mb-3 text-center" id="msg"><b>You Have Entered the Following Data</b></h3>
        <div class="col ">
            <div class="overflow-auto">
                <table class="table bg-white rounded shadow-sm  table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Academic Year</th>
                            <th scope="col">Patent Application Number</th>
                            <th scope="col">Status of patent</th>
                            <th scope="col">Inventor's Name</th>
                            <th scope="col">Title of the patent</th>
                            <th scope="col">Applicant Name</th>
                            <th scope="col">Patent Filed Date</th>
                            <th scope="col">Patent published date</th>
                            <th scope="col">Patent granted date</th>
                            <th scope="col">Patent publication number</th>
                            <th scope="col">Assignee's Name</th>
                            <th scope="col">URL</th>
                            <th scope="col">Edit</th><b></b>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM patent_details WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['PATENT_APPLICATION_NO']?></td>
                    <td><?php echo $row['STATUS_OF_PATENT']?></td>
                    <td><?php echo $row['INVENTOR_NAME']?></td>
                    <td><?php echo $row['TITLE_OF_PATENT']?></td>
                    <td><?php echo $row['APPLICANT_NAME']?></td>
                    <td><?php echo $row['PATENT_FILED_DATE']?></td>
                    <td><?php echo $row['PATENT_PUBLISHED_DATE']?></td>
                    <td><?php echo $row['PATENT_GRANTED_DATE']?></td>
                    <td><?php echo $row['PATENT_PUBLICATION_NUMBER']?></td>
                    <td><?php echo $row['ASIGNEES_NAME']?></td>
                    <td><?php echo $row['URL']?></td>
                    <td><a class="dbutton" href="EditPatentDetailsIndividual.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="PatentDetailsIndividual.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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

