<?php

session_start();

require("../server/connection.php");

if(isset($_SESSION["logged_in"])){
    if(isset($_SESSION["firstname"]) || isset($_SESSION["email"])){
        $useremail = $_SESSION["email"];
        $firstname = $_SESSION["firstname"];
        $lastname = $_SESSION["lastname"];
        $middlename = $_SESSION["middlename"];
        $suffix = $_SESSION["suffix"];
        $gender = $_SESSION["gender"];
        $bday = $_SESSION["bday"];
        $birthplace = $_SESSION["birthplace"];
        $cs = $_SESSION["cs"];
        $citizenship = $_SESSION["citizenship"];
        $phone = $_SESSION["phone"];
        $address = $_SESSION["address"];
        $curriculum = $_SESSION["curriculum"];
        $usertypename = $_SESSION["usertypename"];

    }else{
        $textaccount = "Account";
    }
}else{
    $textaccount = "Account";
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

      <div class="w-100 justify-content-center d-flex">
        <div class="card mt-3 col-sm-9">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="true" href="studentaccmgt.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="studentchangepin.php">Change PIN</a>
                </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-sm-3">
                        <h4 class="card-title">Personal Details</h4>
                        <p>First Name</p>
                        <p>Middle Name</p>
                        <p>Last Name</p>
                        <p>Suffix</p>
                        <p>Gender</p>
                        <p>Birthdate</p>
                        <p>Birth Place</p>
                        <p>Civil Status</p>
                        <p>Citizenship</p>
                    </div>
                    <div class="col-sm-3">
                        <h4 class="card-title text-white">Personal Details</h4>
                        <p><?php echo $firstname; ?></p>
                        <p><?php echo $middlename; ?></p>
                        <p><?php echo $lastname; ?></p>
                        <p><?php echo $suffix; ?></p>
                        <p><?php echo $gender; ?></p>
                        <p><?php echo $bday; ?></p>
                        <p><?php echo $birthplace; ?></p>
                        <p><?php echo $cs; ?></p>
                        <p><?php echo $citizenship; ?></p>
                    </div>
                    <div class="col-sm-3">
                        <h4 class="card-title">Contact Details</h4>
                        <p>Contact Number</p>
                        <p>Email Address</p>
                        <p>Present Address</p>
                        <h4 class="card-title">Program</h4>
                        <p>Standing</p>
                        <p>Curriculum</p>
                    </div>
                    <div class="col-sm-3">
                        <h4 class="card-title text-white">Contact Details</h4>
                        <p><?php echo $phone; ?></p>
                        <p><?php echo $useremail; ?></p>
                        <p><?php echo $address; ?></p>
                        <h4 class="card-title text-white">Program</h4>
                        <p><?php echo $usertypename; ?></p>
                        <p><?php echo $curriculum; ?></p>
                    </div>
                </div>
            </div>
        </div>
      </div>

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