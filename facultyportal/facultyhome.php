<?php

session_start();

require("../server/connection.php");

if(isset($_SESSION["logged_in"])){
    if(isset($_SESSION["firstname"]) || isset($_SESSION["email"])){
        $textaccount = $_SESSION["firstname"];
        $usersid = $_SESSION["userid"];
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
<body>
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
                <a class="nav-link" aria-current="page" href="facultyhome.php">Home</a>
              </li>

              <!-- PTA -->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="facultypta.php">PTA</a>
              </li>

              <!-- e-Consultation-->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="facultychats.php">Forum</a>
              </li>

              <!-- OTHER SERVICES -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Other Services
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="facultyaccmgt.php">Account Management</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item">Logged in as:</a></li>
                  <li><a class="dropdown-item"><?php echo $usersid; ?></a></li>
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

      <div class="d-flex align-items-center justify-content-center bg-image p-5 text-center text-white" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('../img/besmainn.png');
        height: 100vh; background-repeat: no-repeat; background-position: center; background-size: cover;">
        <h1 class="fw-bold display-3">
          <span class="h1">WELCOME TO</span>
          <br>BAYANAN ELEMENTARY SCHOOL MAIN<br>
          <span class="h1">Basta BESMAIN, the BEST YAN!</span></h1>
      </div>

      <div class="d-flex align-items-center justify-content-center bg-image p-5 text-center text-white mt-5" style="background-image: url('../img/arrow1.png');
      background-repeat: no-repeat; background-position: center; background-size: cover;">

      </div>
      
      <div class="d-flex align-items-center justify-content-center bg-image p-5 text-center text-white p-5 mx-5" style="background-image: url('../img/git ');
        height: 60vh; background-repeat: no-repeat; background-position: center; background-size: cover;">
        <div class="d-flex align-items-center justify-content-center">
          <img src="../img/principalnew.png" alt="Principal" class="me-5 mb-5 w-25">
          <div class="text-start">
            <h3 style="color: #3c4670">"At BESMAIN, we believe in nurturing minds,</h3>
            <h3 style="color: #3c4670">inspiring hearts, and empowering futures.</h3>
            <h3 style="color: #3c4670">Together, we create a community where</h3>
            <h3 style="color: #3c4670">every student thrives."</h3>
            <h5 style="color: #3c4670" class="fw-bold pt-5">DR. BUENA C. DELA CRUZ</h5>
            <h6 style="color: #3c4670" class="fw-bold">PRINCIPAL</h6>
          </div>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-center bg-image p-5 text-center text-white" style="background-image: url('../img/arrow1.png');
      background-repeat: no-repeat; background-position: center; background-size: cover;">

      </div>

      <!-- Facebook Page Plugin -->
      <div class="container mt-5">
        <h2 class="text-center fw-bold mb-5">NEWS AND ANNOUNCEMENTS</h2>
        <!-- Facebook SDK -->
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" 
            src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0"></script>
        
        <!-- Facebook Page 1 -->
        <div class="fb-page mb-4" 
            data-href="https://www.facebook.com/officialMuntinlupacity" 
            data-tabs="timeline" 
            data-width="400" 
            data-height="600" 
            data-small-header="false" 
            data-adapt-container-width="true" 
            data-hide-cover="false" 
            data-show-facepile="true">
            <blockquote cite="https://www.facebook.com/officialMuntinlupacity" 
                        class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/officialMuntinlupacity">Muntinlupa City Official</a>
            </blockquote>
        </div>

        <!-- Facebook Page 2 -->
        <div class="fb-page mb-4" 
            data-href="https://www.facebook.com/BESMainMuntinlupaOFFICIAL" 
            data-tabs="timeline" 
            data-width="400" 
            data-height="600" 
            data-small-header="false" 
            data-adapt-container-width="true" 
            data-hide-cover="false" 
            data-show-facepile="true">
            <blockquote cite="https://www.facebook.com/BESMainMuntinlupaOFFICIAL" 
                        class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/BESMainMuntinlupaOFFICIAL">Bayanan Elementary School Main</a>
            </blockquote>
        </div>

        <!-- Facebook Page 3 -->
        <div class="fb-page mb-4" 
            data-href="https://www.facebook.com/muntinlupascholarshipdivision" 
            data-tabs="timeline" 
            data-width="400" 
            data-height="600" 
            data-small-header="false" 
            data-adapt-container-width="true" 
            data-hide-cover="false" 
            data-show-facepile="true">
            <blockquote cite="https://www.facebook.com/muntinlupascholarshipdivision" 
                        class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/muntinlupascholarshipdivision">Muntinlupa Scholarship Division</a>
            </blockquote>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-center bg-image p-5 text-center text-white" style="background-image: url('../img/arrow1.png');
      background-repeat: no-repeat; background-position: center; background-size: cover;">

      </div>

      <!-- ANNOUNCEMENTS -->
      <div class="container mt-5">
        <h2 class="text-center fw-bold mb-3">ANNOUNCEMENTS</h2>
        <div class="border p-3" style="height: 300px; overflow-y: auto;">
            <?php
            require("server/connection.php"); // Ensure this path is correct

            $query = "SELECT postitle, postdesc, dateposted FROM announcements ORDER BY id DESC";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='mb-3'>";
                    echo "<h5 class='fw-bold'>" . htmlspecialchars($row["postitle"]) . "</h5>";
                    echo "<p>" . htmlspecialchars($row["postdesc"]) . "</p>";
                    echo "<small class='text-muted'>" . date("F d, Y", strtotime($row["dateposted"])) . "</small>";
                    echo "<hr>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-muted'>No announcements available.</p>";
            }
            ?>
        </div>
    </div>

      <div class="d-flex align-items-center justify-content-center bg-image p-5 text-center text-white" style="background-image: url('img/arrow1.png');
      background-repeat: no-repeat; background-position: center; background-size: cover;">

      </div>

      <!-- Upcoming Events -->
      <div class="container mt-5">
        <h2 class="text-center fw-bold mb-3">UPCOMING EVENTS</h2>
        <div class="border p-3" style="height: 300px; overflow-y: auto;">
            <?php
            $query = "SELECT postitle, postdesc, dateposted FROM events ORDER BY id DESC";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='mb-3'>";
                    echo "<h5 class='fw-bold'>" . htmlspecialchars($row["postitle"]) . "</h5>";
                    echo "<p>" . htmlspecialchars($row["postdesc"]) . "</p>";
                    echo "<small class='text-muted'>" . date("F d, Y", strtotime($row["dateposted"])) . "</small>";
                    echo "<hr>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-muted'>No upcoming events.</p>";
            }
            ?>
        </div>
    </div>


      <hr>
      <footer>
          <div class="container-fluid row m-2">

              <div class="col-md-6">
                  <p>Copyright &copy; 2024 Bayanan Elementary School Main</p>
              </div>

          </div>
      </footer>


    <!-- Script -->  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>