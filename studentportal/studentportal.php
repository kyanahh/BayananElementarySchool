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
            background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('../img/studentportal.png');
            background-size: cover;
            background-position: center;
            height: 100vh;

        }
    </style>

</head>
<body>
        
    <div class="bg-cover d-flex justify-content-center align-items-center">
        <div class="text-center text-white">
            <img src="../img/logo.jpg" alt="BESMAIN" style="height: 20vh;">
            <div class="card mt-3 col-md-8 mx-auto p-3">
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
                    <h4 class="card-title fw-bold text-center my-3">BESMAIN STUDENT PORTAL</h4>
                    <form method="POST" action="<?php htmlspecialchars("SELF_PHP"); ?>">
                        <div class="row mt-2">
                            <div class="col input-group">
                                <input type="text" class="form-control" id="studentnumber" name="studentnumber" placeholder="Student Number" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="PIN" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-grid gap-2">
                                <button type="submit" class="btn text-white mt-3 fw-bold" style="background-color: #708238;">LOG IN</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-grid gap-2">
                                <p class="text-center mt-4">For student portal assistance, please email <a class="text-decoration-none" style="color: #708238;" href="mailto:bayanan.esmain2016@gmail.com">bayanan.esmain2016@gmail.com</a></p>
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