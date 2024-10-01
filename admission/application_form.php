<?php

session_start();

require("../server/connection.php");

if (isset($_SESSION["logged_in"])) {
    if (isset($_SESSION["firstname"]) || isset($_SESSION["email"])) {
        $textaccount = $_SESSION["firstname"];
        $fname = $_SESSION["firstname"];
        $lname = $_SESSION["lastname"];
        $useremail = $_SESSION["email"];
        $addid = $_SESSION["addid"];
    } else {
        $textaccount = "Account";
    }
} else {
    $textaccount = "Account";
}

// Check if the user has already submitted a form using the `addid`
$formAlreadySubmitted = false;
$errorMessage = "";

if (isset($addid)) {
    $checkQuery = "SELECT * FROM applicationform WHERE addid = '$addid'";
    $userExistsResult = $connection->query($checkQuery);

    if ($userExistsResult && $userExistsResult->num_rows > 0) {
        $formAlreadySubmitted = true;  // Set flag to indicate that the form already exists
        $errorMessage = "Form is already uploaded. You cannot submit another application.";
    }
}

// Form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$formAlreadySubmitted) {
    $firstname = ucwords($_POST["firstname"]);
    $lastname = ucwords($_POST["lastname"]);
    $birthdate = $_POST["birthdate"];
    $birthplace = $_POST["birthplace"];
    $address = $_POST["address"];
    $parentname = $_POST["parentname"];
    $parentphone = $_POST["parentphone"];
    $parentemail = $_POST["parentemail"];
    $previousschool = $_POST["previousschool"];
    $previousschooladdress = $_POST["previousschooladdress"];

    // Insert the user data into the database
    $insertQuery = "INSERT INTO applicationform (firstname, lastname, birthdate, birthplace, 
    address, parentname, parentphone, parentemail, prevschool, prevschooladdress, addid) 
    VALUES ('$firstname', '$lastname', '$birthdate', '$birthplace', '$address', '$parentname', 
    '$parentphone', '$parentemail', '$previousschool', '$previousschooladdress', '$addid')";
    
    $result = $connection->query($insertQuery);

    if (!$result) {
        $errorMessage = "Invalid query: " . $connection->error;
    } else {
        header("Location: applicationhome.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayanan Elementary School - Application Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

  <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <div class="d-flex align-items-center">
        <!-- Navbar Toggler Button -->
        <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar Brand -->
        <a class="navbar-brand mb-0 h1" href="applicationhome.php">Bayanan Elementary School Main</a>
      </div>

      <!-- Offcanvas Menu -->
      <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title mt-2" id="offcanvasDarkNavbarLabel">Bayanan Elementary School Main</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <hr>
        <div class="d-flex align-items-center ps-3">
          <i class="bi bi-person-circle fs-2"></i>
          <p class="ps-2 pt-4"><?php echo $lname ?>, <?php echo $fname ?></p>
        </div>
        <hr>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <!-- Navigation Links -->
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

  <div class="container mt-5 pt-1">
    <h2 class="mt-5">Student Application Form</h2>
    <!-- Error message if form already submitted -->
    <?php if ($formAlreadySubmitted): ?>
      <div class="alert alert-danger mt-4" role="alert">
        <?php echo $errorMessage; ?>
      </div>
    <?php endif; ?>
    <form class="row g-3 mt-2" action="<?php htmlspecialchars("SELF_PHP"); ?>" method="POST">

     <!-- Disable form fields if the form is already submitted -->
     <fieldset <?php echo $formAlreadySubmitted ? 'disabled' : ''; ?>>
      
      <!-- Student Information -->
      <h4>Student Information</h4>
      <div class="row mt-3">
        <div class="col-md-6">
            <label for="firstname" class="form-label">First Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="firstname" name="firstname" required>
        </div>
        <div class="col-md-6">
            <label for="lastname" class="form-label">Last Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="lastname" name="lastname" required>
        </div>
      </div>

      <div class="row mt-2">
        <div class="col-md-6">
            <label for="birthdate" class="form-label">Birthdate<span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
        </div>
        <div class="col-md-6">
            <label for="birthplace" class="form-label">Birthplace<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="birthplace" name="birthplace" required>
        </div>
      </div>

      <div class="row mt-2">
        <div class="col-md-12">
            <label for="address" class="form-label">Home Address<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
      </div>

      <!-- Parent/Guardian Information -->
      <h4 class="mt-4">Parent/Guardian Information</h4>
      <div class="row mt-3">
        <div class="col-md-6">
            <label for="parentname" class="form-label">Parent/Guardian Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="parentname" name="parentname" required>
        </div>
        <div class="col-md-6">
            <label for="parentphone" class="form-label">Parent/Guardian Contact Number<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="parentphone" name="parentphone" required>
        </div>
      </div>

      <div class="row mt-2">
        <div class="col-md-12">
            <label for="parentemail" class="form-label">Parent/Guardian Email<span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="parentemail" name="parentemail" required>
        </div>
      </div>

      <!-- Previous Education Information -->
      <h4 class="mt-4">Previous Education (For Transferees)</h4>
      <div class="col-md-12 mt-3">
        <label for="previousschool" class="form-label">Previous School</label>
        <input type="text" class="form-control" id="previousschool" name="previousschool">
      </div>
      <div class="col-md-12 mt-2">
        <label for="previousschooladdress" class="form-label">Previous School Address</label>
        <input type="text" class="form-control" id="previousschooladdress" name="previousschooladdress">
      </div>

      <!-- Submit Button -->
      <div class="col-12 mt-4">
        <button type="submit" class="btn btn-primary" <?php echo $formAlreadySubmitted ? 'disabled' : ''; ?>>Submit Application</button>
      </div>
    </form>
  </div>

  <footer class="bg-dark text-white text-center py-3 mt-5">
    <p>Copyright &copy; 2024 Bayanan Elementary School Main</p>
  </footer>

  <!-- Script -->  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
