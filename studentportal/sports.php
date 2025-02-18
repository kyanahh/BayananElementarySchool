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

$memid = "N/A";
$stats = "N/A";
$sportsname = "N/A";
$coach = "N/A";
$hasMembership = false;

// Fetch membership details
$query = "SELECT membership.*, sports.sportsname, sports.coach 
          FROM membership 
          INNER JOIN sports ON membership.sportid = sports.sportid 
          WHERE membership.userid = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $memid = $row['memid'];
    $stats = $row['stats'];
    $sportsname = $row['sportsname'];
    $coach = $row['coach'];
    $hasMembership = true;
}
$stmt->close();

// Fetch available sports for dropdown
$sportsOptions = "";
$sportsQuery = "SELECT * FROM sports";
$sportsResult = $connection->query($sportsQuery);
while ($sport = $sportsResult->fetch_assoc()) {
    $sportsOptions .= "<option value='" . $sport['sportid'] . "'>" . $sport['sportsname'] . "</option>";
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
                  <li><a class="dropdown-item" href="enrollmentstatus.php">Enrollment Status</a></li>
                </ul>
              </li>

              <!-- EXTRA CURRICULAR -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Extra Curricular
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="sports.php">Sports</a></li>
                </ul>
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

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-white">Sports Membership</h2>
            <?php if (!$hasMembership): ?>
                <button class="btn btn-light fw-bold px-4 py-3" data-bs-toggle="modal" data-bs-target="#joinModal">Join Now</button>
            <?php endif; ?>
        </div>
        
        <table class="table mt-3">
            <tr><th>Application No.</th><td><?php echo $memid; ?></td></tr>
            <tr><th>Membership Status</th><td><?php echo $stats; ?></td></tr>
            <tr><th>Sports</th><td><?php echo $sportsname; ?></td></tr>
            <tr><th>Coach</th><td><?php echo $coach; ?></td></tr>
        </table>
    </div>

    <!-- Join Now Modal -->
    <div class="modal fade" id="joinModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Join a Sport</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="join_sport.php" method="POST">
                    <label for="sportid" class="form-label">Select a Sport</label>
                    <select class="form-select" name="sportid" id="sportid" required>
                        <option value="" disabled selected>Select a sport</option>
                        <?php
                        $sportsQuery = "SELECT * FROM sports";
                        $sportsResult = $connection->query($sportsQuery);
                        while ($row = $sportsResult->fetch_assoc()) {
                            echo "<option value='{$row['sportid']}'>{$row['sportsname']}</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">Join</button>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
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