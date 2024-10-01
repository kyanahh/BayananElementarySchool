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

$errorMessage = "";

// Composer's autoload file
require '../vendor/autoload.php'; // Adjust the path if necessary

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

// Initialize variables
$name = "";
$email = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'denbertcalago@gmail.com'; // Replace with your email
        $mail->Password = 'oqoh dqni gljr avzu'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587;

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('denbertcalago@gmail.com', 'BESMAIN Website'); // Change as needed

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Inquiry Form Submission';
        $mail->Body = "<strong>Name:</strong> $name<br>
                       <strong>Email:</strong> $email<br><br>
                       <strong>Message:</strong><br>$message";

        $mail->send();
        $errorMessage = 'Message has been sent';
    } catch (Exception $e) {
        $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
                <h3 class="fw-bold text-white ms-5">Contacts and Directory</h3>
                <ol class="breadcrumb ms-5">
                    <li class="breadcrumb-item fw-bold">
                        <a href="home.html" class="text-decoration-none text-white">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Contacts and Directory</li>
                </ol>
            </nav>
        </div>
    </div> 
    
    <div class="container-fluid mt-5 d-flex justify-content-center">
        <div class="card p-4 mx-5 col-sm-10">
          <h4 class="fw-bold">Contact Details</h4>
          <div class="row">
            <div class="col">
              <p>Telephone Number:</p>
              <p>8862 – 2199</p>
              <p class="mt-2">Telfax Number:</p>
              <p>8862 – 2199</p>
            </div>
            <div class="col">
              <p>Address:</p>
              <p>F.L.Navarro Ln, Bayanan, Muntinlupa, 1772 Metro Manila</p>
              <p class="mt-2">Email Address:</p>
              <a class="text-decoration-none" href="mailto:bayanan.esmain2016@gmail.com">bayanan.esmain2016@gmail.com</a>
            </div>
          </div>
            <div class="card p-4 mt-3">
              <h4 class="fw-bold">Inquiry Form</h4>
                <form action="<?php htmlspecialchars("SELF_PHP"); ?>" method="POST">
                  <div class="mb-3">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                  </div>
                  <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                  </div>
                  <div class="pb-3">
                      <label for="message" class="form-label">Message</label>
                      <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter message here.." required></textarea>
                      <p class="text-danger"><?php echo $errorMessage ?></p>
                  </div>
                  <button type="submit" class="btn btn-primary px-4">Submit</button>
                </form>
            </div>
            <h4 class="fw-bold mt-3">Map</h4>
            <div class="container mt-4">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3054.2582417036324!2d121.04271338517454!3d14.406036819149588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d0457e9d9b4f%3A0xb55fa7af84f799cc!2sBayanan%20Elementary%20School%20-%20Main!5e1!3m2!1sen!2sph!4v1727124998585!5m2!1sen!2sph" 
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
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