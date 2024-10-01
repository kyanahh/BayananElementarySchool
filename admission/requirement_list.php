<?php

session_start();

require("../server/connection.php");

if (isset($_SESSION["logged_in"])) {
    if (isset($_SESSION["firstname"]) || isset($_SESSION["email"])) {
        $textaccount = $_SESSION["firstname"];
        $firstname = $_SESSION["firstname"];
        $lastname = $_SESSION["lastname"];
        $useremail = $_SESSION["email"];
    } else {
        $textaccount = "Account";
    }
} else {
    $textaccount = "Account";
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
          <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Bayanan Elementary School Main</h5>
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

  <div class="container mt-5 pt-2">
    <h2 class="mt-5">Admission Requirements</h2>
    <p class="lead">For incoming students at Bayanan Elementary School, please ensure you have the following documents prepared for the application process:</p>

    <ul class="list-group">
      <li class="list-group-item">
        <h5>1. Birth Certificate</h5>
        <p>A certified true copy or a photocopy of the student’s Birth Certificate from the Philippine Statistics Authority (PSA).</p>
      </li>
      <li class="list-group-item">
        <h5>2. Form 138 (Report Card)</h5>
        <p>For transferees and incoming Grade 1 students, please provide a copy of the latest report card indicating the student’s previous school performance.</p>
      </li>
      <li class="list-group-item">
        <h5>3. Certificate of Good Moral Character</h5>
        <p>For Grade 2 and up, submit a Certificate of Good Moral Character from the student’s previous school.</p>
      </li>
      <li class="list-group-item">
        <h5>4. 2x2 ID Photos</h5>
        <p>Submit four (4) recent 2x2 ID photos with the student’s name at the back of each photo.</p>
      </li>
      <li class="list-group-item">
        <h5>5. Parent's or Guardian's Valid ID</h5>
        <p>Submit a photocopy of a valid ID of the parent or guardian (e.g., Driver’s License, Passport, or any government-issued ID).</p>
      </li>
      <li class="list-group-item">
        <h5>6. Proof of Residence</h5>
        <p>Provide any document that indicates your current residential address (e.g., utility bill or barangay certificate).</p>
      </li>
      <li class="list-group-item">
        <h5>7   . Kindergarten Certificate of Completion</h5>
        <p>For incoming Grade 1 students, provide the Kindergarten Certificate of Completion or equivalent document.</p>
      </li>
    </ul>

    <div class="alert alert-info mt-4">
      <p><strong>Note:</strong> All photocopied documents must be submitted with the original copies for verification.</p>
    </div>
  </div>

  <footer class="bg-dark text-white text-center py-3 mt-5">
    <p>Copyright &copy; 2024 Bayanan Elementary School Main</p>
  </footer>

  <!-- Script -->  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
