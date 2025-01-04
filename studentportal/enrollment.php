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

$gradeid = $remarks = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gradeid = $_POST["gradeid"];
    $application_status = "Pending";
    $remarks = $_POST["remarks"];

    // Check if the student already has an application
    $checkQuery = "SELECT * FROM enrollment_applications WHERE studentid = ?";
    $stmt = $connection->prepare($checkQuery);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If application exists, set an error message
        $errorMessage = "Enrollment has already been submitted and cannot be modified. If you encounter any issues, please contact the IT department for assistance.";
    } else {
        // Get the current date and time
        $appdate = date("Y-m-d H:i:s");

        // Insert the section data into the database
        $insertQuery = "INSERT INTO enrollment_applications (studentid, gradeid, application_status, remarks, appdate) 
        VALUES (?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($insertQuery);
        $stmt->bind_param("iisss", $userid, $gradeid, $application_status, $remarks, $appdate);

        if ($stmt->execute()) {
            $errorMessage = "Enrollment Application Successfully Submitted";
        } else {
            $errorMessage = "Invalid query: " . $connection->error;
        }
    }
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

      <div class="pt-5">

        <h2 class="fw-bold text-white ms-5">Enrollment Application</h2>
        <!-- Add Enrollment Application -->
        <div class="container px-3 pt-4">
                    <form method="POST" action="<?php htmlspecialchars("SELF_PHP"); ?>">

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
                                <label class="form-label text-white fw-bold">Student Number<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="userid" id="userid" value="<?php echo $userid; ?>" disabled>
                            </div>
                        </div>

                        <div class="row mb-3 mt-2 align-items-center">
                            <div class="col-sm-2">
                                <label class="form-label text-white fw-bold">Grade Level Applying For<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-select" id="gradeid" name="gradeid" required>
                                    <option selected disabled>Select an option</option>
                                    <option value="1" <?php echo ($gradeid == 1) ? 'selected' : ''; ?>>Preschool</option>
                                    <option value="2" <?php echo ($gradeid == 2) ? 'selected' : ''; ?>>Kindergarten</option>
                                    <option value="3" <?php echo ($gradeid == 3) ? 'selected' : ''; ?>>Grade 1</option>
                                    <option value="4" <?php echo ($gradeid == 4) ? 'selected' : ''; ?>>Grade 2</option>
                                    <option value="5" <?php echo ($gradeid == 5) ? 'selected' : ''; ?>>Grade 3</option>
                                    <option value="6" <?php echo ($gradeid == 6) ? 'selected' : ''; ?>>Grade 4</option>
                                    <option value="7" <?php echo ($gradeid == 7) ? 'selected' : ''; ?>>Grade 5</option>
                                    <option value="8" <?php echo ($gradeid == 8) ? 'selected' : ''; ?>>Grade 6</option>
                                </select>                            
                            </div>
                        </div>

                        <div class="row mb-3 mt-2 align-items-center">
                            <div class="col-sm-2">
                                <label class="form-label text-white fw-bold">Remarks</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="remarks" id="remarks" value="<?php echo $remarks; ?>" placeholder="Remarks..">
                            </div>
                        </div>

                        <div class="row mb-3 mt-2">
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-light fw-bold px-5">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End of Add Enrollment Application -->

      </div>
    
    <div class="mt-5 pt-4"></div>
    <hr class="mt-5">
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