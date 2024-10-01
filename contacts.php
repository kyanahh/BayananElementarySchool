<?php

$errorMessage = "";

// Composer's autoload file
require 'vendor/autoload.php'; // Adjust the path if necessary

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        $mail->Username = 'sumbongmagulang@gmail.com'; // Replace with your email
        $mail->Password = 'nurm zexy krps rweo'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587;

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('sumbongmagulang@gmail.com', 'BESMAIN Website'); // Change as needed

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
<body>
    <nav class="navbar" style="background-color: #708238;">
        <a class="navbar-brand" style="color: #708238;">Navbar</a>
          <div class="d-flex me-5">
            <a href="https://www.facebook.com/BESMainMuntinlupaOFFICIAL/" target="_blank">
                <i class="bi bi-facebook text-white"></i></a>
            <a href="mailto:bayanan.esmain2016@gmail.com"><i class="bi bi-google text-white ms-4"></i></a>
        </div>
    </nav>

    <nav class="navbar bg-white">
        <div class="container-fluid d-flex justify-content-center">
          <a class="navbar-brand mb-0 fs-3" href="home.html">Bayanan Elementary School Main</a>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg bg-white py-3">
        <div class="container-fluid">
          <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav grid gap-5">

                <!-- HOME -->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="home.html">Home</a>
              </li>

              <!-- ABOUT -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  About
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="visionmission.html">Vision and Mission</a></li>
                  <li><a class="dropdown-item" href="history.html">History</a></li>
                  <li><a class="dropdown-item" href="contacts.php">Contacts and Directory</a></li>
                  <li><a class="dropdown-item" href="board.html">Board of Regents</a></li>
                </ul>
              </li>

              <!-- LIFE@BES -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Life@BES
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="hymn.html">BESMAIN Hymn</a></li>
                  <li><a class="dropdown-item" href="facilities.html">Facilities</a></li>
                </ul>
              </li>

              <!-- ADMINISTRATION-->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Administration
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="hymn.html">BESMAIN Hymn</a></li>
                  <li><a class="dropdown-item" href="facilities.html">Facilities</a></li>
                </ul>
              </li>

              <!-- ADMISSION -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Admission
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="admission/application.php">Application</a></li>
                  <li><a class="dropdown-item" href="https://www.deped.gov.ph/matatagcurriculumk147/">Curriculum Overview</a></li>
                </ul>
              </li>

              <!-- SERVICES -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Services
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="studentportal/studentportal.php">Student Portal</a></li>
                  <li><a class="dropdown-item" href="parentportal/parentportal.php">Parent Portal</a></li>
                  <li><a class="dropdown-item" href="facultyportal/facultyportal.php">Faculty Portal</a></li>
                </ul>
              </li>
              
            </ul>
          </div>
        </div>
      </nav>

      <div class="container-fluid bg-image p-5 text-white" style="background-image: 
      linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
      url('../bayanan/img/besmain.png'); height: 30vh; background-repeat: no-repeat; 
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