<?php

session_start();

require("../server/connection.php");

$errorMessage = "";

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $result = $connection->query("SELECT users.*, gender.gendertype as gender, 
    civilstatus.civilstats as cs, usertype.usertypename as usertypename, users.usertypeid as typeid 
    FROM (((users INNER JOIN gender on users.genderid = gender.genderid) 
    INNER JOIN civilstatus on users.civilstatus = civilstatus.statusid) 
    INNER JOIN usertype on users.usertypeid = usertype.usertypeid) 
    WHERE users.email = '$email' AND users.pin = '$password' AND users.usertypeid = 4");

    if ($result->num_rows === 1) {
        $record = $result->fetch_assoc();

        // Fetch the usertypeid for the user
        $usertypeid = $record["typeid"];

        // Set session variables
        $_SESSION["userid"] = $record["userid"];
        $_SESSION["firstname"] = $record["firstname"];
        $_SESSION["middlename"] = $record["middlename"];
        $_SESSION["lastname"] = $record["lastname"];
        $_SESSION["suffix"] = $record["suffix"];
        $_SESSION["gender"] = $record["gender"];
        $_SESSION["bday"] = $record["bday"];
        $_SESSION["birthplace"] = $record["birthplace"];
        $_SESSION["cs"] = $record["cs"];
        $_SESSION["citizenship"] = $record["citizenship"];
        $_SESSION["phone"] = $record["phone"];
        $_SESSION["email"] = $record["email"];
        $_SESSION["address"] = $record["address"];
        $_SESSION["curriculum"] = $record["curriculum"];
        $_SESSION["usertypename"] = $record["usertypename"];
        $_SESSION["usertypeid"] = $row["usertypeid"]; // Ensure this is set after login
        $_SESSION["logged_in"] = true;

        $userid = $record["userid"];
        $logtime = date("Y-m-d H:i:s");
        $connection->query("INSERT INTO userlogs (logtime, userid) VALUES ('$logtime', '$userid')");

        // Redirect users based on usertypeid
        if ($usertypeid == 4) {
            header("Location: parenthome.php");
            exit();  // Always use exit after a header redirection
        } else {
            $errorMessage = "You are not authorized to access this portal.";
        }

    } else {
        $errorMessage = "Incorrect email or password";
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
            background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('../img/parentportal.png');
            background-size: cover;
            background-position: center;
            height: 100vh;

        }
    </style>

</head>
<body>
        
    <div class="bg-cover d-flex justify-content-center align-items-center">
        <div class="text-center text-white">
            <div class="card mt-3 col-md-12 mx-auto p-2">
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
                    <h2 class="card-title text-center my-3">BESMAIN Parents Portal</h2>
                    <h4 class="card-title text-center my-3">Login</h4>
                    <form method="POST" action="<?php htmlspecialchars("SELF_PHP"); ?>">
                        <div class="row my-4">
                            <div class="col input-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email address" required>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="PIN" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-grid gap-2">
                                <button type="submit" class="btn text-white mt-3 fw-bold py-3" style="background-color: #708238;">LOGIN</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-grid gap-2">
                                <a class="btn btn-outline-success mt-3 fw-bold py-3" href="../home.html">Visit BESMAIN Official Website</a>
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