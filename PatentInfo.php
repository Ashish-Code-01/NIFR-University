<?php
include 'config.php';
require "header.php";
    
$dept = $_SESSION['dept_id'];

if (isset($_POST['submit'])){

    $Patent_Filed_1st_Year=$_POST['Patent_Filed_1st_Year'];
    // $Patent_Filed_2nd_Year=$_POST['Patent_Filed_2nd_Year'];
    // $Patent_Filed_3rd_Year=$_POST['Patent_Filed_3rd_Year'];
    $Patent_Published_1st_Year=$_POST['Patent_Published_1st_Year'];
    // $Patent_Published_2nd_Year=$_POST['Patent_Published_2nd_Year'];
    // $Patent_Published_3rd_Year=$_POST['Patent_Published_3rd_Year'];
    $Patent_Granted_1st_Year=$_POST['Patent_Granted_1st_Year'];
    $Patent_Granted_2nd_Year=$_POST['Patent_Granted_2nd_Year'];
    $Patent_Granted_3rd_Year=$_POST['Patent_Granted_3rd_Year'];
    $Total_Amount_Granted=$_POST['Total_Amount_Granted'];

    $query="INSERT INTO `patent_info`(`A_YEAR`, `DEPT_ID`, `NO_OF_PATENT_FILLED_1_YEAR`, `NO_OF_PATENT_FILLED_2_YEAR`, `NO_OF_PATENT_FILLED_3_YEAR`, `NO_OF_PATENT_PUBLISHED_1_YEAR`, `NO_OF_PATENT_PUBLISHED_2_YEAR`, `NO_OF_PATENT_PUBLISHED_3_YEAR`, `NO_OF_PATENT_GRANTED_1_YEAR`, `NO_OF_PATENT_GRANTED_2_YEAR`, `NO_OF_PATENT_GRANTED_3_YEAR`, `TOTAL_AMT_GRANTED`) 
    VALUES ('$A_YEAR', '$dept','$Patent_Filed_1st_Year','$Patent_Filed_2nd_Year','$Patent_Filed_3rd_Year', '$Patent_Published_1st_Year', '$Patent_Published_2nd_Year', '$Patent_Published_3rd_Year', '$Patent_Granted_1st_Year', '$Patent_Granted_2nd_Year', '$Patent_Granted_3rd_Year', '$Total_Amount_Granted')
    ON DUPLICATE KEY UPDATE
    NO_OF_PATENT_FILLED_1_YEAR = VALUES(NO_OF_PATENT_FILLED_1_YEAR),
    NO_OF_PATENT_FILLED_2_YEAR = VALUES(NO_OF_PATENT_FILLED_2_YEAR),
    NO_OF_PATENT_FILLED_3_YEAR = VALUES(NO_OF_PATENT_FILLED_3_YEAR),
    NO_OF_PATENT_PUBLISHED_1_YEAR = VALUES(NO_OF_PATENT_PUBLISHED_1_YEAR),
    NO_OF_PATENT_PUBLISHED_2_YEAR = VALUES(NO_OF_PATENT_PUBLISHED_2_YEAR),
    NO_OF_PATENT_PUBLISHED_3_YEAR = VALUES(NO_OF_PATENT_PUBLISHED_3_YEAR),
    NO_OF_PATENT_GRANTED_1_YEAR = VALUES(NO_OF_PATENT_GRANTED_1_YEAR),
    NO_OF_PATENT_GRANTED_2_YEAR = VALUES(NO_OF_PATENT_GRANTED_2_YEAR),
    NO_OF_PATENT_GRANTED_3_YEAR = VALUES(NO_OF_PATENT_GRANTED_3_YEAR),
    TOTAL_AMT_GRANTED = VALUES(TOTAL_AMT_GRANTED)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "PatentInfo.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from patent_info where ID = '$id'");
        echo '<script>window.location.href = "PatentInfo.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 " style="margin-bottom: 6px;"><b>Patent Info</b></p>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
                    <input type="text" name="year1" value="<?php echo $A_YEAR?>" class="form-control" style="margin-top: 0;" disabled>
                </div>
                
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
                    <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" style="margin-top: 0;" disabled>
                </div>                
                
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>No of Patent Filed in <?php echo $A_YEAR?></b></label>
                    <input type="number" name="Patent_Filed_1st_Year" class="form-control" placeholder="Enter the No of Patent Filed in <?php echo $A_YEAR?>" style="margin-top: 0;" >
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>No of Patent Published in <?php echo $A_YEAR?></b></label>
                    <input type="number" name="Patent_Published_1st_Year" class="form-control" placeholder="Enter the  No of Patent Published in <?php echo $A_YEAR?>" style="margin-top: 0;">
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>No of Patent Granted in <?php echo $A_YEAR?></b></label>   
                    <input type="number" name="Patent_Granted_1st_Year" class="form-control" placeholder="Enter the  No of Patent Granted in <?php echo $A_YEAR?>" style="margin-top: 0;">
                </div>
                

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Total Amount Granted (INR)</b></label>
                    <input type="number" name="Total_Amount_Granted" class="form-control" placeholder="Enter the Total Amount Granted (INR)" style="margin-top: 0;" required>
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
                            <th scope="col">No of Patent Filed in <?php echo $A_YEAR?></th>
                            <th scope="col">No of Patent Published in <?php echo $A_YEAR?></th>
                            <th scope="col">No of Patent Granted in <?php echo $A_YEAR?></th>
                            <th scope="col">Total Amount Granted (INR)</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM patent_info WHERE DEPT_ID = $dept");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['NO_OF_PATENT_FILLED_1_YEAR']?></td>
                    <td><?php echo $row['NO_OF_PATENT_PUBLISHED_1_YEAR']?></td>
                    <td><?php echo $row['NO_OF_PATENT_GRANTED_1_YEAR']?></td>
                    <td><?php echo $row['TOTAL_AMT_GRANTED']?></td>
                    <td><a class="dbutton" href="EditPatentInfo.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="PatentInfo.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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