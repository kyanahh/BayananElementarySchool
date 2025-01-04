<?php
session_start();
require("../server/connection.php");

if (isset($_SESSION["logged_in"])) {
    if (isset($_SESSION["firstname"]) || isset($_SESSION["email"])) {
        $textaccount = $_SESSION["firstname"];
        $userid = $_SESSION["userid"];
    } else {
        $textaccount = "Account";
    }
} else {
    $textaccount = "Account";
}

$application_status = "N/A";
$grade_name = "N/A";
$section_name = "N/A"; // Default to N/A
$errorMessage = "";
$subjects = [];

if (isset($userid) && !empty($userid)) {
    $stmt = $connection->prepare("
        SELECT enrollment_applications.*, 
               grade_levels.grade_name, 
               class_sections.section_name
        FROM enrollment_applications 
        INNER JOIN grade_levels ON enrollment_applications.gradeid = grade_levels.grade_id
        LEFT JOIN class_section_assignments ON class_section_assignments.applicationid = enrollment_applications.applicationid
        LEFT JOIN class_sections ON class_section_assignments.sectionid = class_sections.section_id
        WHERE enrollment_applications.studentid = ? 
        ORDER BY FIELD(enrollment_applications.application_status, 'Approved') DESC, 
                 enrollment_applications.appdate DESC
        LIMIT 1
    ");

    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $application_status = $row["application_status"];
        $grade_name = $row["grade_name"];
        $section_name = $row["section_name"] ?? "N/A";
    } else {
        $errorMessage = "Enrollment Status not found.";
    }

    // Only fetch subjects if the application is approved
    if ($application_status == "Approved") {
        $subjectStmt = $connection->prepare("
            SELECT DISTINCT subjects.subject_name
            FROM subjects
            INNER JOIN enrollment_applications ON enrollment_applications.gradeid = subjects.grade_id
            WHERE enrollment_applications.studentid = ?
        ");    
        $subjectStmt->bind_param("i", $userid);
        $subjectStmt->execute();
        $subjectResult = $subjectStmt->get_result();

        if ($subjectResult && $subjectResult->num_rows > 0) {
            while ($subjectRow = $subjectResult->fetch_assoc()) {
                $subjects[] = $subjectRow["subject_name"];
            }
        }
    }
} else {
    $errorMessage = "User ID is missing.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayanan Elementary School - Main</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body style="background-color: #424d21;">
    <nav class="navbar" style="background-color: #708238;">
        <a class="navbar-brand" style="color: #708238;">Navbar</a>
          <div class="d-flex me-5">
            <a href="https://www.facebook.com/BESMainMuntinlupaOFFICIAL/" target="_blank">
                <i class="bi bi-facebook text-white"></i></a>
            <a href="mailto:bayanan.esmain2016@gmail.com"><i class="bi bi-google text-white ms-4"></i></a>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg py-3 bg-white">
        <div class="container-fluid">
            <img src="../img/logo.jpg" alt="BESMAIN" style="height: 7vh;" class="mx-3">
            <a class="navbar-brand " href="studenthome.php">Bayanan Elementary School Main</a>
          <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav grid gap-3">

              <!-- HOME -->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="studenthome.php">Home</a>
              </li>

              <!-- ENROLLMENT SERVICES -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Enrollment Services
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="enrollment.php">Online Enrollment</a></li>
                  <li><a class="dropdown-item" href="enrollmentstatus.php">Enrollment Status</a></li>
                </ul>
              </li>

              <!-- Faculty Evaluation -->
              <li class="nav-item">
                <a class="nav-link" href="facultyevalutation.php">
                    Faculty Evaluation
                </a>
              </li>

              <!-- OTHER SERVICES -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Other Services
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="studentaccmgt.php">Account Management</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item">Student Number <br><?php echo $userid; ?></a></li>
                </ul>
              </li>
              
              <!-- LOGOUT -->
              <li class="nav-item me-3">
                <a class="nav-link" href="../logout.php" role="button">
                  Logout
                </a>
              </li>
              
            </ul>
          </div>
        </div>
    </nav>    

    <div class="row">

        <!-- COLUMN 1 -->
        <div class="pt-5 col-sm-6">

            <h2 class="fw-bold text-white ms-5">Enrollment Status</h2>
                <!-- Display Enrollment Status -->
                <div class="container pt-4 ms-5">
                        <form method="POST" action="<?php htmlspecialchars("SELF_PHP"); ?>">

                        <?php if (!empty($errorMessage)): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($errorMessage); ?>
                            </div>
                        <?php endif; ?>

                            <div class="row mb-3 mt-2 align-items-center">
                                <div class="col-sm-4">
                                    <label class="form-label text-white fw-bold">Student Number</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="userid" id="userid" value="<?php echo $userid; ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3 mt-2 align-items-center">
                                <div class="col-sm-4">
                                    <label class="form-label text-white fw-bold">Enrollment Status</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="application_status" id="application_status" value="<?php echo $application_status; ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3 mt-2 align-items-center">
                                <div class="col-sm-4">
                                    <label class="form-label text-white fw-bold">Grade Level</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="grade_name" id="grade_name" value="<?php echo $grade_name; ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3 mt-2 align-items-center">
                                <div class="col-sm-4">
                                    <label class="form-label text-white fw-bold">Section</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="section_name" id="section_name" value="<?php echo $section_name; ?>" disabled>
                                </div>
                            </div>

                        </form>
                </div>
                <!-- End of Display Enrollment Status -->
        </div>

        <!-- COLUMN 2 -->
        <div class="col-sm-5">
            <!-- List of Subjects-->
            <div class="pt-5">
                    <div class="card" style="height: 400px;">
                        <div class="card-body">
                            <div class="table-responsive" style="height: 360px;">
                                <table id="user-table" class="table table-border-none table-hover">
                                    <thead class="table-light" style="position: sticky; top: 0;">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Subjects</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php
                                        if ($application_status == "Approved" && count($subjects) > 0) {
                                            foreach ($subjects as $index => $subject) {
                                                echo "<tr><td>" . ($index + 1) . "</td><td>" . $subject . "</td></tr>";
                                            }
                                        } else {
                                            echo '<tr><td colspan="2">No subjects found.</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of List of Subjects -->
        </div>

    </div>
    
    <hr>
    <footer>
        <div class="container-fluid row m-2 text-white">

            <div class="col-md-6">
                <p>Copyright &copy; 2024 Bayanan Elementary School Main</p>
            </div>

        </div>
    </footer>


    <!-- Script -->  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>