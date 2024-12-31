<?php

session_start();

require("../server/connection.php");

if (isset($_SESSION["logged_in"])) {
    if (isset($_SESSION["firstname"]) || isset($_SESSION["email"])) {
        $textaccount = $_SESSION["firstname"];
        $lname = $_SESSION["lastname"];
        $useremail = $_SESSION["email"];
    } else {
        $textaccount = "Account";
    }
} else {
    $textaccount = "Account";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayanan Elementary School - Requirements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <div class="container-fluid overflow-hidden">
        <div class="row g-0 vh-100 overflow-y-auto">
            <div class="col-2 col-sm-3 col-xl-2 d-flex fixed-top" id="sidebar">
                <div class="d-flex flex-column flex-grow-1 align-items-center align-items-sm-start bg-dark px-2 px-sm-3 py-2 text-white vh-100 overflow-auto">
                    <a href="adminhome.php" class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 fw-bold pt-3">BESMAIN</span></span>
                    </a>
                    <!-- Sidebar -->
                    <ul class="nav nav-pills flex-column flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="adminhome.php" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#submenu1" class="nav-link px-sm-0 px-2" data-bs-toggle="collapse" data-bs-target="#submenu1">
                                <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline">Users <span class="bi-caret-down"></span></span>
                            </a>
                            <div class="collapse collapse-horizontal px-2" id="submenu1">
                                <ul class="list-unstyled mx-2">
                                    <li>
                                        <a href="students.php" class="nav-link">
                                            <span>Students</span></a>
                                    </li>
                                    <li>
                                        <a href="faculty.php" class="nav-link">
                                            <span>Facutly</span></a>
                                    </li>
                                    <li>
                                        <a href="admin.php" class="nav-link">
                                            <span>Admins</span></a>
                                    </li>
                                    <li>
                                        <a href="admissionacc.php" class="nav-link">
                                            <span>Admissions</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="admission.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-files"></i><span class="ms-1 d-none d-sm-inline">Admission Forms</span> </a>
                        </li>
                        <li>
                            <a href="admissionsched.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-calendar-check"></i><span class="ms-1 d-none d-sm-inline">Admission Schedules</span> </a>
                        </li>
                        <li class="nav-item">
                            <a href="#submenu2" class="nav-link px-sm-0 px-2" data-bs-toggle="collapse" data-bs-target="#submenu2">
                                <i class="fs-5 bi-file-person"></i><span class="ms-1 d-none d-sm-inline">Enrollment <span class="bi-caret-down"></span></span>
                            </a>
                            <div class="collapse collapse-horizontal px-2" id="submenu2">
                                <ul class="list-unstyled mx-2">
                                    <li>
                                        <a href="gradesection.php" class="nav-link">
                                            <span>Class Section</span></a>
                                    </li>
                                    <li>
                                        <a href="grade_enrollment.php" class="nav-link">
                                            <span>Enrollment Applications</span></a>
                                    </li>
                                    <li>
                                        <a href="grade_classassignment.php" class="nav-link">
                                            <span>Class Assignments</span></a>
                                    </li>
                                    <li>
                                        <a href="grade_assignment.php" class="nav-link">
                                            <span>Grade Assignments</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="facultyevaluation.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-clipboard2-check"></i><span class="ms-1 d-none d-sm-inline">Faculty Evaluation</span> </a>
                        </li>
                    </ul>
                    <div class="dropup py-sm-4 py-1 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../img/nopf.jpg" alt="hugenerd" width="28" height="28" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1"><?php echo $textaccount . " " . $lname ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark px-0 px-sm-2 text-center text-sm-start" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item px-1" href="profile.php"><i class="fs-6 bi-person"></i><span class="d-none d-sm-inline ps-1">Profile</span></a></li>
                            <li><a class="dropdown-item px-1" href="settings.php"><i class="fs-6 bi-gear"></i><span class="d-none d-sm-inline ps-1">Settings</span></a></li>
                            <li><a class="dropdown-item px-1" href="../logout.php"><i class="fs-6 bi-power"></i><span class="d-none d-sm-inline ps-1">Logout</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="col offset-2 offset-sm-3 offset-xl-2 d-flex flex-column vh-100 pt-4">

                <!-- List of Admission Details-->
                <div class="px-3">
                    <div class="row">
                        <div class="col-sm-2">
                            <h2 class="fs-5 mt-1 ms-2">Admission Forms</h2>
                        </div>
                        <div class="col input-group mb-3 ms-4">
                            <input type="text" class="form-control" id="searchUserInput" placeholder="Search" aria-describedby="button-addon2" oninput="searchUsers()">
                        </div>
                    </div>
                    
                    <div class="card" style="height: 600px;">
                        <div class="card-body">
                            <div class="table-responsive" style="height: 550px;">
                                <table id="user-table" class="table table-bordered table-hover">
                                    <thead class="table-light" style="position: sticky; top: 0;">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Admission ID</th>
                                            <th scope="col">AddForm ID</th>
                                            <th scope="col">First</th>
                                            <th scope="col">Last</th>
                                            <th scope="col">Birthday</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                    <?php
                                        // Query the database to fetch user data
                                        $result = $connection->query("SELECT applicationform.*, admission.addid 
                                        FROM applicationform INNER JOIN admission
                                        ON applicationform.addid = admission.addid 
                                        ORDER BY appformid DESC");

                                        if ($result->num_rows > 0) {
                                            $count = 1; 

                                            while ($row = $result->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $count . '</td>';
                                                echo '<td>' . $row['addid'] . '</td>';
                                                echo '<td>' . $row['appformid'] . '</td>';
                                                echo '<td>' . $row['firstname'] . '</td>';
                                                echo '<td>' . $row['lastname'] . '</td>';
                                                echo '<td>' . date('M d, Y', strtotime($row['birthdate'])) . '</td>';
                                                echo '<td>';
                                                echo '<div class="d-flex justify-content-center">';
                                                $appformid = $row['appformid']; 

                                                    // Check if this appformid exists in the 'appsched' table
                                                    $schedCheck = $connection->query("SELECT COUNT(*) as count FROM appsched WHERE appformid = $appformid");
                                                    $schedCheckResult = $schedCheck->fetch_assoc();

                                                    // If no schedule exists, show the "Add Exam Schedule" button
                                                    if ($schedCheckResult['count'] == 0) {
                                                        echo '<button class="btn btn-warning me-2" onclick="addSchedule(' . $appformid . ')">Add Exam Schedule</button>';
                                                    } else {
                                                        // If schedule exists, show the "View Exam Schedule" button
                                                        echo '<button class="btn btn-dark me-2" onclick="viewExamSched(' . $appformid . ')">Exam Schedule</button>';
                                                    }

                                                echo '<button class="btn btn-info me-2" onclick="viewAdmission(' . $row['appformid'] . ')">View</button>';
                                                echo '<button class="btn btn-danger" onclick="deleteAdmission(' . $row['appformid'] . ')">Delete</button>';
                                                echo '</div>';
                                                echo '</td>';
                                                echo '</tr>';
                                                $count++; 
                                            }
                                        } else {
                                            echo '<tr><td colspan="5">No admission details found.</td></tr>';
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                        <!-- Search results will be displayed here -->
                    <div id="search-results"></div>
                </div>
                <!-- End of List of Admission Details -->

                <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container">
                    <div id="deleteToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Notification</strong>
                            <small>Just now</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Admission Form deleted successfully.
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
                            Are you sure you want to delete this admission form?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Toast Notification -->
                <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container">
                    <div id="updateToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Notification</strong>
                            <small>Just now</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Information updated successfully.
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div> 

    <!-- Script -->  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        //---------------------------Add Exam Sched---------------------------//
        function addSchedule(appformid) {
            window.location = "admissionaddsched.php?appformid=" + appformid;
        }

        //---------------------------View Exam Sched---------------------------//
        function viewExamSched(appformid) {
            window.location = "admissionviewsched.php?appformid=" + appformid;
        }

        //---------------------------View Admission Form---------------------------//
        function viewAdmission(appformid) {
            window.location = "adminviewforms.php?appformid=" + appformid;
        }

        //---------------------------Delete Users---------------------------//
        let addIdToDelete = null;

        function deleteAdmission(appformid) {
            addIdToDelete = appformid; // Store the user ID to delete
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show(); // Show the modal
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (addIdToDelete) {
                $.ajax({
                    url: 'admissionformdelete.php',
                    method: 'POST',
                    data: { appformid: addIdToDelete },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            showDeleteToast();
                            setTimeout(function () {
                                location.reload();
                            }, 3000); // Wait 3 seconds before refreshing
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function () {
                        alert('Error deleting user');
                    }
                });
            }
        });

        function showDeleteToast() {
            const deleteToast = new bootstrap.Toast(document.getElementById('deleteToast'));
            deleteToast.show();
        }


        //---------------------------Search Admission Form Results---------------------------//
        function searchUsers() {
            const query = document.getElementById("searchUserInput").value;

            // Make an AJAX request to fetch search results
            $.ajax({
                url: 'admissionsearch_forms.php', // Replace with the actual URL to your search script
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    // Update the user-table with the search results
                    $('#user-table tbody').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error during search request:", error);
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if the session has the update success flag set
            <?php if (isset($_SESSION['update_success'])): ?>
                var updateToast = new bootstrap.Toast(document.getElementById('updateToast'));
                updateToast.show();
                <?php unset($_SESSION['update_success']); // Clear the session variable after showing the toast ?>
            <?php endif; ?>
        });
    </script>

</body>
</html>
