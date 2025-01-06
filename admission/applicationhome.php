<?php

session_start();

require("../server/connection.php");

if (isset($_SESSION["logged_in"])) {
    if (isset($_SESSION["firstname"]) || isset($_SESSION["email"])) {
        $textaccount = $_SESSION["firstname"];
        $firstname = $_SESSION["firstname"];
        $lastname = $_SESSION["lastname"];
        $useremail = $_SESSION["email"];
        $addid = $_SESSION["addid"];
    } else {
        $textaccount = "Account";
    }
} else {
    $textaccount = "Account";
}

$appstatus = 'Not Available';
$examdate = 'Not Available';
$examvenue = 'Not Available';
$formattedExamDate = 'Not Available';
$remarks = 'Not Available';
$appformid = 'Not Available';

$admissionData = [];
$uploadedFiles = []; // To hold uploaded file statuses

$query = "SELECT applicationform.*, appsched.* 
            FROM applicationform INNER JOIN appsched 
            ON applicationform.appformid = appsched.appformid 
            WHERE addid = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $addid);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $admissionData = $result->fetch_all(MYSQLI_ASSOC);
    $row = $admissionData[0]; // Use the first record
    
    $appformid = $row['appformid'];
    $appstatus = $row['appstatus'];
    $examdate = $row['examdate'];
    $formattedExamDate = (new DateTime($examdate))->format('F j, Y');
    $examvenue = $row['examvenue'];
    $remarks = $row['remarks'];

    foreach (['pic', 'psa', 'reportcard', 'goodmoral', 'validid', 'residence', 'kinder'] as $requirement) {
        if (!empty($row[$requirement])) {
            $uploadedFiles[$requirement] = true;
        }
    }
} else {
    echo "No application data found.";
}


$uploadMessage = "";

// Handle file uploads
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requirements = ['pic', 'psa', 'reportcard', 'goodmoral', 'validid', 'residence', 'kinder'];

    foreach ($requirements as $requirement) {
        if (isset($_FILES[$requirement]) && $_FILES[$requirement]['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$requirement]['tmp_name'];
            $fileName = $_FILES[$requirement]['name'];
            $fileSize = $_FILES[$requirement]['size'];
            $fileType = $_FILES[$requirement]['type'];

            // Set the destination path
            $uploadFileDir = '../uploads/';
            $dest_path = $uploadFileDir . $fileName;

            // Move the file to the designated folder
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Update the database record with the file path
                $updateQuery = "UPDATE applicationform SET $requirement = ? WHERE addid = ?";
                $updateStmt = $connection->prepare($updateQuery);
                $updateStmt->bind_param("si", $dest_path, $addid);
                $updateStmt->execute();
                $uploadedFiles[$requirement] = true; // Mark as uploaded
            } else {
                $uploadMessage .= "There was an error moving the uploaded file.<br>";
            }
        } else {
            if (isset($_FILES[$requirement]) && $_FILES[$requirement]['error'] != UPLOAD_ERR_NO_FILE) {
                $uploadMessage .= "Error uploading file for requirement $requirement.<br>";
            }
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
<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand mb-0 h1" href="applicationhome.php">Bayanan Elementary School Main</a>
        </div>

        <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title mt-2" id="offcanvasDarkNavbarLabel">Bayanan Elementary School Main</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr>
            <div class="d-flex align-items-center ps-3">
                <i class="bi bi-person-circle fs-2"></i>
                <p class="ps-2 pt-4"><?php echo $lastname ?>, <?php echo $firstname ?></p>
            </div>
            <hr>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="applicationhome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="application_form.php">Application Form</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="requirement_list.php">Requirement List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid mt-5 pt-5 px-5 mb-5">
    <div class="row d-flex justify-content-center">

        <div class="col-sm-4 me-2">
            <div class="card">
                <div class="card-header fw-bold">
                    Status
                </div>
                <div class="card-body">
                    <div class="border py-3 px-3">
                        <p class="fw-bold">Application Status: 
                        <br><span class="fw-bold"><?php echo $appstatus ?></span></p>
                        <hr>
                        <p class="fw-bold">Application No.: <br><span><?php echo $appformid ?></span></p>
                        <p class="fw-bold">Examination Date: <br><span class="fw-bold"><?php echo $formattedExamDate ?></span></p>
                        <p class="fw-bold">Examination Venue: <br><span class="fw-bold"><?php echo $examvenue ?></span></p>
                        <hr>
                        <p class="fw-bold">Reminders / Remarks: <?php echo $remarks ?></p>
                        <p class="text-danger fw-bold">Please check the schedule of your exam which will be shown above.</p>
                        <hr>
                        <div class="d-flex justify-content-center">
                            <?php if (!empty($appformid)) : ?>
                                <form method="POST" action="generate_pdf.php">
                                    <input type="hidden" name="appformid" value="<?php echo $appformid; ?>">
                                    <button type="submit" class="btn btn-primary p-2">Print Application Form</button>
                                </form>
                            <?php else : ?>
                                <button class="btn btn-secondary p-2" disabled>Print Application Form</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-7">
            <div class="card">
                <div class="card-header fw-bold">
                    Requirements
                </div>
                <div class="card-body">

                    <!-- Application Form -->
                    <div class="row mx-2 mt-2">
                        <div class="col border p-2">
                            <p class="px-2">Requirement #1: <br><span class="fw-bold">Fill-up Application Form</span></p>
                        </div>
                        <div class="col border text-center p-2">
                            <p class="text-success fw-bold p-2"><?php echo $appformid ?></p>
                        </div>
                    </div>

                    <!-- Upload Documents -->
                    <?php 
                    $requirementsText = [
                        'pic' => 'Upload Scanned Copy of 2x2 Picture with White Background',
                        'psa' => 'Upload Scanned Copy of PSA Birth Certificate',
                        'reportcard' => 'Upload Scanned Copy of Report Card (Form 138)',
                        'goodmoral' => 'Upload Scanned Copy of Good Moral',
                        'validid' => 'Upload Scanned Copy of Parent\'s/Guardian\'s Valid ID',
                        'residence' => 'Upload Scanned Copy of Proof of Residence',
                        'kinder' => 'Upload Scanned Copy of Kindergarten Certificate of Completion (if applicable)',
                    ];

                    foreach ($requirementsText as $key => $requirement) { ?>
                        <div class="row mx-2">
                            <div class="col border p-2">
                                <p class="px-2">Requirement #<?php echo array_search($key, array_keys($requirementsText)) + 2; ?>: <br><span class="fw-bold"><?php echo $requirement; ?></span></p>
                            </div>
                            <div class="col border text-center p-2">
                                <?php if (isset($uploadedFiles[$key])): ?>
                                    <p class="fw-bold text-success">UPLOADED</p>
                                <?php else: ?>
                                    <!-- File Upload Form -->
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="file" name="<?php echo $key; ?>" class="form-control mt-4">
                                        <button type="submit" class="btn btn-primary mt-2">Upload</button>
                                    </form>
                                <?php endif; ?>
                                <p class="mt-2 text-success"><?php echo $uploadMessage; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                        
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
