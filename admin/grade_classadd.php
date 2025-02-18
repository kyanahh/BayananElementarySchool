<?php

session_start();

require("../server/connection.php");

if (isset($_SESSION["logged_in"])) {
    if (isset($_SESSION["firstname"]) || isset($_SESSION["email"])) {
        $textaccount = $_SESSION["firstname"];
        $lname = $_SESSION["lastname"];
        $useremail = $_SESSION["email"];
        $usersid = $_SESSION["userid"];
    } else {
        $textaccount = "Account";
    }
} else {
    $textaccount = "Account";
}

if (isset($_GET["applicationid"]) && !empty($_GET["applicationid"])) {
    $applicationid = $_GET["applicationid"];

    $query = "SELECT * FROM enrollment_applications   
                WHERE applicationid = '$applicationid'";

    $res = $connection->query($query);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();

        $applicationid = $row["applicationid"];
        $studentid = $row["studentid"];

    } else {
        $errorMessage = "Application not found.";
    }
} else {
    $errorMessage = "Application ID is missing.";
}

// Get the current date and time
$assigneddate = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sectionid = $_POST["sectionid"];

    // Insert the section data into the database
    $insertQuery = "INSERT INTO class_section_assignments (applicationid, sectionid, assignmentdate, assignedby) 
    VALUES ($applicationid, $sectionid, '$assigneddate', '$usersid')";
    $result = $connection->query($insertQuery);

    if ($result) {
        // Set a session variable for success
        $_SESSION['update_success'] = true;
        header("Location: grade_classassignment.php"); 
        exit;
    } else {
        $errorMessage = "Error adding details: " . $connection->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayanan Elementary School - Requirements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <div class="container-fluid overflow-hidden">
        <div class="row g-0 vh-100 overflow-y-auto">
            <div class="col-2 col-sm-3 col-xl-2 d-flex fixed-top" id="sidebar">
                <div class="d-flex flex-column flex-grow-1 align-items-center align-items-sm-start bg-dark px-2 px-sm-3 py-2 text-white vh-100 overflow-auto">
                    <a href="adminhome.php" class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 fw-bold pt-3">BESMAIN</span></span>
                    </a>
                    <!-- Sidebar -->
                    <ul class="nav nav-pills flex-column flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="adminhome.php" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#submenu1" class="nav-link px-sm-0 px-2" data-bs-toggle="collapse" data-bs-target="#submenu1">
                                <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline">Users <span class="bi-caret-down"></span></span>
                            </a>
                            <div class="collapse collapse-horizontal px-2" id="submenu1">
                                <ul class="list-unstyled mx-2">
                                    <li>
                                        <a href="students.php" class="nav-link">
                                            <span>Students</span></a>
                                    </li>
                                    <li>
                                        <a href="faculty.php" class="nav-link">
                                            <span>Faculty</span></a>
                                    </li>
                                    <li>
                                        <a href="admin.php" class="nav-link">
                                            <span>Admins</span></a>
                                    </li>
                                    <li>
                                        <a href="admissionacc.php" class="nav-link">
                                            <span>Admissions</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="admission.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-files"></i><span class="ms-1 d-none d-sm-inline">Admission Forms</span> </a>
                        </li>
                        <li class="nav-item">
                            <a href="#submenu2" class="nav-link px-sm-0 px-2" data-bs-toggle="collapse" data-bs-target="#submenu2">
                                <i class="fs-5 bi-file-person"></i><span class="ms-1 d-none d-sm-inline">Enrollment <span class="bi-caret-down"></span></span>
                            </a>
                            <div class="collapse collapse-horizontal px-2" id="submenu2">
                                <ul class="list-unstyled mx-2">
                                    <li>
                                        <a href="gradesection.php" class="nav-link">
                                            <span>Class Section</span></a>
                                    </li>
                                    <li>
                                        <a href="grade_enrollment.php" class="nav-link">
                                            <span>Enrollment Applications</span></a>
                                    </li>
                                    <li>
                                        <a href="grade_classassignment.php" class="nav-link">
                                            <span>Class Assignments</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="pta.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-person-vcard-fill"></i><span class="ms-1 d-none d-sm-inline">PTA</span> </a> 
                        </li>
                        <li>
                            <a href="announcements.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-megaphone"></i><span class="ms-1 d-none d-sm-inline">Announcements</span> </a>
                        </li>
                        <li>
                            <a href="events.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-calendar-event"></i><span class="ms-1 d-none d-sm-inline">Upcoming Events</span> </a>
                        </li>
                        <li>
                            <a href="inquiry.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-info-circle"></i><span class="ms-1 d-none d-sm-inline">Inquiries</span> </a>
                        </li>
                    </ul>
                    <div class="dropup py-sm-4 py-1 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../img/nopf.jpg" alt="hugenerd" width="28" height="28" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1"><?php echo $textaccount . " " . $lname ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark px-0 px-sm-2 text-center text-sm-start" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item px-1" href="profile.php"><i class="fs-6 bi-person"></i><span class="d-none d-sm-inline ps-1">Profile</span></a></li>
                            <li><a class="dropdown-item px-1" href="settings.php"><i class="fs-6 bi-gear"></i><span class="d-none d-sm-inline ps-1">Settings</span></a></li>
                            <li><a class="dropdown-item px-1" href="../logout.php"><i class="fs-6 bi-power"></i><span class="d-none d-sm-inline ps-1">Logout</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="col offset-2 offset-sm-3 offset-xl-2 d-flex flex-column vh-100">

            <!-- Add Class Assignment -->
            <div class="container px-3 pt-4">
                    <form method="POST" action="<?php htmlspecialchars("SELF_PHP"); ?>">

                        <div class="row mt-1">
                            <h2 class="fs-5">Class Assignment</h2>
                        </div>

                        <!-- Display Error Message -->
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                    if (!empty($errorMessage)) {
                                        echo "
                                        <div class='alert alert-warning alert-dismissible fade show mt-2' role='alert'>
                                            <strong>$errorMessage</strong>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                        </div>
                                        ";
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row mb-3 mt-2 align-items-center">
                            <div class="col-sm-2">
                                <label class="form-label">Application ID</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="applicationid" id="applicationid" value="<?php echo $applicationid; ?>" disabled>
                            </div>
                        </div>

                        <div class="row mb-3 mt-2 align-items-center">
                            <div class="col-sm-2">
                                <label class="form-label">Student Number</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="studentid" id="studentid" value="<?php echo $studentid; ?>" disabled>
                            </div>
                        </div>

                        <div class="row mb-3 mt-2 align-items-center">
                            <div class="col-sm-2">
                                <label class="form-label">Section<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-select" id="sectionid" name="sectionid" required>
                                    <option selected disabled>Select an option</option>
                                    <?php
                                        // Fetch section names from class_sections table
                                        // Fetch the gradeid for the selected student
                                        $gradeQuery = "SELECT gradeid FROM enrollment_applications WHERE applicationid = '$applicationid'";
                                        $gradeResult = $connection->query($gradeQuery);

                                        if ($gradeResult && $gradeResult->num_rows > 0) {
                                            $gradeRow = $gradeResult->fetch_assoc();
                                            $gradeid = $gradeRow['gradeid'];

                                            // Fetch sections based on gradeid
                                            $query = "SELECT section_id, section_name 
                                                    FROM class_sections 
                                                    WHERE grade_id = '$gradeid'
                                                    ORDER BY section_name ASC";
                                            $result = $connection->query($query);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['section_id'] . "'>" . htmlspecialchars($row['section_name']) . "</option>";
                                                }
                                            } else {
                                                echo "<option disabled>No sections available</option>";
                                            }
                                        } else {
                                            echo "<option disabled>Grade not assigned</option>";
                                        }
                                        $result = $connection->query($query);

                                    ?>
                                </select>                            
                            </div>
                        </div>

                        <div class="row mb-3 mt-2">
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-dark px-5">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End of Add Class Assignment -->

            </div>

        </div>
    </div> 

    <!-- Script -->  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
