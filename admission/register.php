<?php

session_start();

require("../server/connection.php");

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = ucwords($_POST["firstname"]);
    $lastname = ucwords($_POST["lastname"]);
    $bday = $_POST["bday"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $email = $_POST["email"];

    // Check if PIN length is between 4 and 5 digits
    if (!preg_match('/^\d{4,5}$/', $password)) {
        $errorMessage = "PIN must contain exactly 4-5 digits.";
    } elseif ($password !== $confirmpassword) {
        $errorMessage = "Passwords do not match";
    } else {
        // Check if the username already exists in the database
        $userExistsQuery = "SELECT * FROM admission WHERE username = '$username'";
        $userExistsResult = $connection->query($userExistsQuery);

        if ($userExistsResult->num_rows > 0) {
            $errorMessage = "User already exists";
        } else {
            // Insert the user data into the database
            $insertQuery = "INSERT INTO admission (firstname, lastname, bday, username, pin, email) 
            VALUES ('$firstname', '$lastname', '$bday', '$username', '$password', '$email')";
            $result = $connection->query($insertQuery);

            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
            } else {
                header("Location: success.html");
                exit();
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
    
    <style>
        /* Full-screen background */
        .bg-cover {
            background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('../img/besmain1.png');
            background-size: cover;
            background-position: center;
            height: 170vh;

        }
    </style>

</head>
<body>
        
    <div class="bg-cover d-flex justify-content-center align-items-center">
        <div class="text-center text-white">
            <div class="card col-md-8 mx-auto p-2 mt-4">
                <div class="card-body">
                    <?php
                    if (!empty($errorMessage)) {
                        echo "
                        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>$errorMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                        ";
                    }
                    ?>
                    <img src="../img/logo.jpg" alt="BESMAIN" style="height: 13vh;">
                    <h2 class="card-title text-center my-3">BESMAIN Admission Portal</h2>
                    <h4 class="card-title text-center my-3">Registration Form</h4>
                    <hr class="my-4">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <h6 class="text-start">Personal Information</h6>
                        <div class="row">
                            <div class="col input-group">
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col input-group">
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
                            </div>
                        </div>

                        <h6 class="mt-3 text-start">Birthday</h6>
                        <div class="row">
                            <div class="col input-group">
                                <input type="date" class="form-control" id="bday" name="bday" required>
                            </div>
                        </div>

                        <h6 class="mt-3 text-start">Sign-in Information</h6>
                        <div class="row">
                            <div class="col input-group">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="PIN" required
                                    pattern="\d{4,5}" title="PIN must contain exactly 4 or 5 digits.">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col input-group">
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm PIN" required
                                    pattern="\d{4,5}" title="PIN must contain exactly 4 or 5 digits.">
                            </div>
                        </div>
                        <p class="text-start mt-2">Note: PIN must contain exactly 4-5 digits.</p>

                        <h6 class="mt-3 text-start">Contact Information</h6>
                        <div class="row mt-2">
                            <div class="col input-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email address" required>
                            </div>
                        </div>
                        <p class="text-start mt-2">Note: Please enter a valid and active Email Address since this will be used to contact you.</p>

                        <div class="row">
                            <div class="col d-grid gap-2">
                                <button type="submit" class="btn text-white fw-bold" style="background-color: #708238;">Register Account</button>
                                <p>Already have an account? <a class="text-decoration-none" href="application.php">Sign in here.</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Script -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>