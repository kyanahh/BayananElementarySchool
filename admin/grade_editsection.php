<?php

session_start();

require("../server/connection.php");

if (isset($_SESSION["logged_in"])) {
    if (isset($_SESSION["firstname"]) || isset($_SESSION["email"])) {
        $textaccount = $_SESSION["firstname"];
        $lname = $_SESSION["lastname"];
        $useremail = $_SESSION["email"];
    } else {
        $textaccount = "Account";
    }
} else {
    $textaccount = "Account";
}

if (isset($_GET["section_id"]) && !empty($_GET["section_id"])) {
    $section_id = $_GET["section_id"];

    $query = "SELECT * FROM class_sections
            WHERE section_id = '$section_id'";

    $res = $connection->query($query);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();

        $section_name = $row["section_name"];
        $adviser = $row["adviser"];

        $grade_id = (isset($row["grade_id"]) && $row["grade_id"] >= 1 && $row["grade_id"] <= 8) ? (int)$row["grade_id"] : 8;

    } else {
        $errorMessage = "Class Section not found.";
    }
} else {
    $errorMessage = "Class Section ID is missing.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $section_name =  ucwords($_POST["section_name"]);
    $adviser =  ucwords($_POST["adviser"]);
    $grade_id = $_POST["grade_id"];

    $insertQuery = "UPDATE class_sections  
                    SET 
                    grade_id = '$grade_id', 
                    section_name = '$section_name', 
                    adviser = '$adviser'
                    WHERE section_id = '$section_id'";

    $result = $connection->query($insertQuery);

    if ($result) {
        // Set a session variable for success
        $_SESSION['update_success'] = true;
        header("Location: gradesection.php"); 
        exit;
    } else {
        $errorMessage = "Error updating details: " . $connection->error;
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
                            <a href="sports.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-person-arms-up"></i><span class="ms-1 d-none d-sm-inline">Sports Membership</span> </a>
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

                <!-- Edit Section -->
                <div class="container px-3 pt-4">
                    <form method="POST" action="<?php htmlspecialchars("SELF_PHP"); ?>">

                        <div class="row mt-1">
                            <h2 class="fs-5">Edit Class Section</h2>
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
                                <label class="form-label">Grade Level<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-select" id="grade_id" name="grade_id" required>
                                    <option selected disabled>Select an option</option>
                                    <option value="1" <?php echo ($grade_id == 1) ? 'selected' : ''; ?>>Preschool</option>
                                    <option value="2" <?php echo ($grade_id == 2) ? 'selected' : ''; ?>>Kindergarten</option>
                                    <option value="3" <?php echo ($grade_id == 3) ? 'selected' : ''; ?>>Grade 1</option>
                                    <option value="4" <?php echo ($grade_id == 4) ? 'selected' : ''; ?>>Grade 2</option>
                                    <option value="5" <?php echo ($grade_id == 5) ? 'selected' : ''; ?>>Grade 3</option>
                                    <option value="6" <?php echo ($grade_id == 6) ? 'selected' : ''; ?>>Grade 4</option>
                                    <option value="7" <?php echo ($grade_id == 7) ? 'selected' : ''; ?>>Grade 5</option>
                                    <option value="8" <?php echo ($grade_id == 8) ? 'selected' : ''; ?>>Grade 6</option>
                                </select>                            
                            </div>
                        </div>

                        <div class="row mb-3 mt-2 align-items-center">
                            <div class="col-sm-2">
                                <label class="form-label">Class Section<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="section_name" id="section_name" value="<?php echo $section_name; ?>" placeholder="Enter Section Name" required>
                            </div>
                        </div>

                        <div class="row mb-3 mt-2 align-items-center">
                            <div class="col-sm-2">
                                <label class="form-label">Adviser<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="adviser" id="adviser" required>
                                    <option value="" disabled selected>Select Adviser</option>
                                    <?php
                                    // Query to get all faculty members
                                    $sql = "SELECT userid, CONCAT(firstname, ' ', lastname) AS full_name FROM users WHERE usertypeid = 2";
                                    $result = $connection->query($sql);

                                    // Check if there are any faculty members and populate the dropdown
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['userid'] . '">' . $row['full_name'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="" disabled>No Faculty Found</option>';
                                    }
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
                <!-- End of Edit Section -->

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
