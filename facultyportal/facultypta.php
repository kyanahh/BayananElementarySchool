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

$ptatitle = $ptapost = "";
$currentDate = date("Y-m-d"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ptatitle =  ucwords($_POST["ptatitle"]);
    $ptapost =  ucwords($_POST["ptapost"]);

    // Insert the user data into the database
    $insertQuery = "INSERT INTO pta (ptatitle, ptapost, postedby, dateposted) 
    VALUES ('$ptatitle', '$ptapost', '$usersid', '$currentDate')";
    $result = $connection->query($insertQuery);

    if (!$result) {
        $_SESSION['toast_message'] = "Invalid query " . $connection->error;
    } else {
        $ptatitle = $ptapost = "";
        $_SESSION['toast_message'] = "Post successfully created"; // Set session message
        header("Location: facultypta.php"); // Redirect to the same page
        exit();
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

              <!-- e-Consultation-->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="consultation.php">e-Consultation</a>
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

      <div class="row d-flex justify-content-center">
        <!-- Card 1 -->
        <div class="card mt-5 p-3 col-sm-5" style="height: 400px;">
            <h4 class="fw-bold">Parent-Teacher Association</h4>
            <!-- Add Post -->
             <form action="<?php htmlspecialchars("SELF_PHP"); ?>" method="POST">
                <div class="mb-3">
                    <label for="ptatitle" class="form-label fw-bold">Title</label>
                    <input type="text" class="form-control" id="ptatitle" name="ptatitle" value="<?php echo $ptatitle; ?>" placeholder="Title">
                </div>
                <div class="mb-3">
                    <label for="ptapost" class="form-label fw-bold">Description</label>
                    <textarea class="form-control" id="ptapost" name="ptapost" rows="6" value="<?php echo $ptapost; ?>" placeholder="Description here"></textarea>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-dark px-5">Post</button>
                    </div>
                </div>
             </form>
            <!-- End of Add Post --> 
        </div>

        <!-- Card 2 -->
        <div class="card p-3 mt-5 ms-3 col-sm-6">
            <div class="table-responsive" style="height: 350px;">
                <table id="user-table" class="table table-border-none table-hover">
                    <tbody class="table-group-divider">
                    <?php
                        // Query the database to fetch user data
                        $result = $connection->query("SELECT pta.ptaid, pta.ptatitle, pta.ptapost, 
                        DATE_FORMAT(pta.dateposted, '%M %d, %Y') AS datepost, users.firstname, users.lastname  
                        FROM pta INNER JOIN users
                            ON pta.postedby = users.userid 
                        ORDER BY ptaid DESC");

                        if ($result->num_rows > 0) {
                            $count = 1; 

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . '<span class="fw-bold">' .
                                $row['ptatitle'] . '</span><br>' . 
                                $row['ptapost'] . ' ' . '<br>' . 
                                $row['firstname'] . ' ' . $row['lastname'] . ' - <span class="">' . $row['datepost'] . '</span>' . 
                                '</td>';
                                echo '<td>';
                                echo '<div class="d-flex justify-content-center align-items-center">';
                                echo '<button class="btn" onclick="openDeleteModal(' . $row['ptaid'] . ')"><i class="bi bi-x-lg"></i></button>';
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';
                                $count++; 
                            }
                        } else {
                            echo '<tr><td colspan="5">No posts found.</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

      </div>

      <!-- Toast Notification -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="successToast" class="toast" style="width: 300px;">
                <div class="toast-header">
                    <strong class="me-auto">Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Post successfully created!
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this post?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button id="confirmDeleteButton" type="button" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

    <hr class="mt-4 text-white">
    <footer>
        <div class="container-fluid row m-2 text-white">

            <div class="col-md-6">
                <p>Copyright &copy; 2024 Bayanan Elementary School Main</p>
            </div>

        </div>
    </footer>


    <!-- Script -->  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Check if the session message is set and show toast
        <?php if (isset($_SESSION['toast_message'])): ?>
            // Show the toast
            var toast = new bootstrap.Toast(document.getElementById('successToast'));
            toast.show();
            <?php unset($_SESSION['toast_message']); // Clear the session message after showing ?>
        <?php endif; ?>
    </script>

    <script>
        //---------------------------Delete Post ---------------------------//
        let ptaIdToDelete = null;

        // Open Delete Modal
        function openDeleteModal(ptaid) {
            ptaIdToDelete = ptaid;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Handle Delete Confirmation
        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            if (ptaIdToDelete) {
                $.ajax({
                    url: "facultyptadelete.php",
                    method: "POST",
                    data: { ptaId: ptaIdToDelete },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            showToast(response.success, "bg-success");
                            setTimeout(() => location.reload(), 2000); // Optional delay before reload
                        } else {
                            showToast(response.error, "bg-danger");
                        }
                    },
                    error: function () {
                        showToast("Error deleting the PTA Post", "bg-danger");
                    }
                });
            }
        });

        function showToast(message, toastClass = "bg-success") {
        // Create the toast container dynamically if it doesn't exist
        let toastContainer = document.querySelector(".toast-container");
        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.className = "toast-container position-fixed bottom-0 end-0 p-3";
            document.body.appendChild(toastContainer);
        }

        // Create the toast
        const toastElement = document.createElement("div");
        toastElement.className = `toast align-items-center text-white ${toastClass}`;
        toastElement.style.width = "300px";
        toastElement.setAttribute("role", "alert");

        toastElement.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        toastContainer.appendChild(toastElement);

        // Show the toast
        const toast = new bootstrap.Toast(toastElement);
        toast.show();

        // Remove toast after it disappears
        toastElement.addEventListener("hidden.bs.toast", () => {
            toastElement.remove();
        });
    }

    </script>

</body>
</html>