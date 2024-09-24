<?php

session_start();

require("../server/connection.php");

if(isset($_SESSION["logged_in"])){
    if(isset($_SESSION["firstname"]) || isset($_SESSION["email"])){
        $textaccount = $_SESSION["firstname"];
        $useremail = $_SESSION["email"];
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
            <a class="navbar-brand " href="parenthome.php">Bayanan Elementary School Main</a>
          <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav grid gap-3">

              <!-- HOME -->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="parenthome.php">Home</a>
              </li>

              <!-- ABOUT -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  About
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="parentvisionmission.php">Vision and Mission</a></li>
                  <li><a class="dropdown-item" href="parenthymn.php">BESMAIN Hymn</a></li>
                  <li><a class="dropdown-item" href="parenthistory.php">History</a></li>
                  <li><a class="dropdown-item" href="parentcontacts.php">Contacts and Directory</a></li>
                </ul>
              </li>

              <!-- e-Consultation-->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                e-Consultation
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="parentconsult.php">Consult a Teacher</a></li>
                </ul>
              </li>

              <!-- GRADES -->
              <li class="nav-item">
                <a class="nav-link" href="parentstudentgrades.php">
                  Student Grades
                </a>
              </li>

              <!-- OTHER SERVICES -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Other Services
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="parentpta.php">PTA</a></li>
                  <li><a class="dropdown-item" href="parentaccmgt.php">Account Management</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item">Logged in as:</a></li>
                  <li><a class="dropdown-item"><?php echo $useremail; ?></a></li>
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

    <div class="container-fluid bg-image p-5 text-white" style="background-image: 
      linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
      url('../img/besmain.png'); height: 30vh; background-repeat: no-repeat; 
      background-position: center; background-size: cover; position: relative;">
        <div class="content-container" style="position: absolute; bottom: 0; width: 100%;">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <h3 class="fw-bold text-white ms-5">History</h3>
                <ol class="breadcrumb ms-5">
                    <li class="breadcrumb-item fw-bold">
                        <a href="home.html" class="text-decoration-none text-white">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-white fw-bold" aria-current="page">History</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="container-fluid mt-5 d-flex justify-content-center">
        <div class="card p-4 mx-5 col-sm-10">
            <p>Bayanan Elementary School (Main) started from the grass roots with a Maestro who conducted his teachings under the mango tree during the Spanish era.</p>
            <p class="mt-3">Formal education was introduced when the Americans came, but because there were only less than 50 schoolchildren in Bayanan, only Grades one to two were held with only one teacher regardless of age. They were taught the 3R’s such as Reading, Writing and Arithmetic.</p>
            <p class="mt-3">The Japanese Headquarters was made the temporary school when the Japanese left the country in 1946. The four-classroom school building was later named Bayanan Barrio School as proposed by then Mayor Baldomero Vinalon. There were only four Grade levels, I to IV until the addition of a Grade V level in 1958. In the school year 1958 – 1959, Bayanan Barrio School held its first graduation day.</p>
            <p class="mt-3">The following school principals supervised the school:</p>
            <p>1955-1965 Mrs. Serafina Argana (Head Teacher)</p>
            <p>1965-1970 Mr. Simeom Bumanglag
            <p>1974 – 1975 Mrs. Ermelinda Hernandez</p>
            <p>1975 – 1985 Mrs. Salud Figuracion
            <p>1985 – 1990 Dr. Herminia A. Arancillo</p>
            <p>1990 – 1997 Dr. Belen C. Garcia</p>
            <p>1997 – 2002 Dr. Rosita Espina</p>
            <p>2002 – 2007 Dr. Rosita J. Gonzales</p>
            <p>Jan. – Aug. 2007 Dr. Francisca A. Pagkalinawan</p>
            <p class="mt-3">(OIC) Principal, Parent Supervisor</p>
            <p>Sept. 2007- June 2008 Dr. Angelita M. Pelagio</p>
            <p>June 2008 – June 2009 Dr. Francisca A. Pagkalinawan</p>
            <p class="mt-3">(OIC), Principal, Parent Supervisor</p>
            <p>June 2009-Present Ms. Marissa M. Andanza</p>
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