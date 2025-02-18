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
                                            <span>Faculty</span></a>
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
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="pta.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-person-vcard-fill"></i><span class="ms-1 d-none d-sm-inline">PTA</span> </a>
                        </li>
                        <li>
                            <a href="announcements.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-megaphone"></i><span class="ms-1 d-none d-sm-inline">Announcements</span> </a>
                        </li>
                        <li>
                            <a href="events.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-calendar-event"></i><span class="ms-1 d-none d-sm-inline">Upcoming Events</span> </a>
                        </li>
                        <li>
                            <a href="sports.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-person-arms-up"></i><span class="ms-1 d-none d-sm-inline">Sports Membership</span> </a>
                        </li>
                        <li>
                            <a href="inquiry.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-info-circle"></i><span class="ms-1 d-none d-sm-inline">Inquiries</span> </a>
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
            <div class="col offset-2 offset-sm-3 offset-xl-2 d-flex flex-column vh-100">

            <!-- List of Event Posts -->
            <div class="px-3 pt-4">
                    <div class="row">
                        <div class="col-sm-3">
                            <h2 class="fs-5 mt-1 ms-2">Sports Membership</h2>
                        </div>
                        <div class="col input-group mb-3 ms-4">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search" aria-describedby="button-addon2" oninput="search()">
                        </div>
                    </div>
                    
                    <div class="card" style="height: 600px;">
                        <div class="card-body">
                            <div class="table-responsive" style="height: 550px;">
                                <table id="sports-table" class="table table-bordered table-hover">
                                    <thead class="table-light" style="position: sticky; top: 0;">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Membership ID</th>
                                            <th scope="col">LRN</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Sports</th>
                                            <th scope="col">Coach</th>
                                            <th scope="col">Date Created</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                    <?php
                                        // Query the database to fetch user data
                                        $result = $connection->query("SELECT membership.*, sports.*, 
                                            users.firstname, users.lastname 
                                            FROM ((membership 
                                            INNER JOIN sports 
                                                ON membership.sportid = sports.sportid) 
                                            INNER JOIN users
                                                ON membership.userid = users.userid)
                                            ORDER BY membership.memid DESC");

                                        if ($result->num_rows > 0) {
                                            $count = 1; 

                                            while ($row = $result->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $count . '</td>';
                                                echo '<td>' . $row['memid'] . '</td>';
                                                echo '<td>' . $row['userid'] . '</td>';
                                                echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                                echo '<td>' . $row['stats'] . '</td>';
                                                echo '<td>' . $row['sportsname'] . '</td>';
                                                echo '<td>' . $row['coach'] . '</td>';
                                                echo '<td>' . $row['dateposted'] . '</td>';
                                                echo '<td>';
                                                echo '<div class="d-flex justify-content-center">';
                                                if ($row['stats'] == 'Pending') {
                                                    echo '<button class="btn btn-success me-2" onclick="Approve(' . $row['memid'] . ')">Approve</button>';
                                                    echo '<button class="btn btn-danger me-2" onclick="Reject(' . $row['memid'] . ')">Reject</button>';
    
                                                }
                                                
                                                echo '<button class="btn btn-primary me-2" onclick="editStats(' . $row['memid'] . ', \'' . $row['stats'] . '\')">Edit</button>';
                                                echo '<button class="btn btn-danger" onclick="openDeleteModal(' . $row['memid'] . ')">Delete</button>';
                                                echo '</div>';
                                                echo '</td>';
                                                echo '</tr>';
                                                $count++; 
                                            }
                                        } else {
                                            echo '<tr><td colspan="5">No sports membership found.</td></tr>';
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
                <!-- End of Upcoming Events -->

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
                            Are you sure you want to delete this membership?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button id="confirmDeleteButton" type="button" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approve Modal -->
            <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="approveModalLabel">Approve Membership</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to approve this membership?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-success" id="approveButton">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reject Modal -->
            <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Reject Membership</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to reject this membership?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep It</button>
                            <button type="button" class="btn btn-danger" id="rejectButton">Yes, Reject</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Status Modal -->
            <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editStatusModalLabel">Edit Membership Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="updateStatusForm">
                                <input type="hidden" id="editMemid" name="memid">
                                
                                <div class="mb-3">
                                    <label for="editStatus" class="form-label">Select Status</label>
                                    <select class="form-select" id="editStatus" name="status">
                                        <option value="Approved">Approved</option>
                                        <option value="Rejected">Rejected</option>
                                        <option value="AW">AW</option>
                                        <option value="Removed">Removed</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="updateStatus()">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toast Notification -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer">
                <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body" id="toastMessage">
                           Membership added successfully!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
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
        //---------------------------Search Sports---------------------------//
        function search() {
            const query = document.getElementById("searchInput").value;

            // Make an AJAX request to fetch search results
            $.ajax({
                url: 'sports_search.php', // Replace with the actual URL to your search script
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    // Update the sched-table with the search results
                    $('#sports-table tbody').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error during search request:", error);
                }
            });
        }

        // Function to display the toast
        function showToast(message, className) {
            // Get the toast elements
            const toastMessage = document.getElementById('toastMessage');
            const toastElement = document.getElementById('liveToast');

            // Update the toast message and class
            toastMessage.textContent = message;
            toastElement.className = `toast align-items-center text-white ${className} border-0`;

            // Initialize and show the toast
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        //---------------------------Delete Membership ---------------------------//
        let IdToDelete = null;

        // Open Delete Modal
        function openDeleteModal(memid) {
            IdToDelete = memid;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Handle Delete Confirmation
        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            if (IdToDelete) {
                $.ajax({
                    url: "sports_delete.php",
                    method: "POST",
                    data: { Id: IdToDelete },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            showToast(response.success, "bg-success");
                            setTimeout(() => location.reload(), 2000); // Optional delay before reload
                        } else {
                            showToast(response.error, "bg-danger");
                        }
                    },
                    error: function (xhr, status, error) {
                        showToast("Error deleting the membership", "bg-danger");
                    }
                });
            }
        });

        //---------------------------Approve Stats---------------------------//
        // JavaScript code for modal and toast handling
        let IdToConfirm = null;

        // Function to open the approve modal
        function Approve(memid) {
            IdToConfirm = memid;
            const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
            approveModal.show();
        }

        // Event listener for the confirmation button
        document.getElementById('approveButton').addEventListener('click', function () {
            if (IdToConfirm) {
                $.ajax({
                    url: "sports_approve.php",
                    method: "POST",
                    data: { Id: IdToConfirm },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            // Display the success toast
                            showToast(response.success, "bg-success");
                            setTimeout(() => location.reload(), 2000); // Optional delay before reload
                        } else {
                            // Display an error toast
                            showToast(response.error, "bg-danger");
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors from the AJAX request
                        showToast('Error approving the membership', 'bg-danger');
                    }
                });
            }
        });

        // Function to display the toast
        function showToast(message, className) {
            // Get the toast elements
            const toastMessage = document.getElementById('toastMessage');
            const toastElement = document.getElementById('liveToast');

            // Update the toast message and class
            toastMessage.textContent = message;
            toastElement.className = `toast align-items-center text-white ${className} border-0`;

            // Initialize and show the toast
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        //---------------------------Reject Stats---------------------------//
        let enrollmentIdToCancel = null;

        // Open Reject Modal
        function Reject(memid) {
            console.log("Opening Reject Modal for ID:", memid); // Debugging log
            IdToCancel = memid;

            const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
            rejectModal.show();
        }

        // Handle Reject Confirmation
        document.getElementById('rejectButton').addEventListener('click', function () {
            if (IdToCancel) {
                console.log("Rejecting Sports Membership with ID:", IdToCancel); // Debugging log

                $.ajax({
                    url: "sports_reject.php",
                    method: "POST",
                    data: { Id: IdToCancel },
                    dataType: "json",
                    success: function(response) {
                        console.log("Server Response:", response); // Debugging log
                        if (response.success) {
                            showToast(response.success, "bg-success");
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            showToast(response.error, "bg-danger");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error); // Debugging log
                        showToast('Error rejecting the sports membership', 'bg-danger');
                    }
                });
            }
        });

        //---------------------------Edit Status---------------------------//
        function editStats(memid, currentStatus) {
            document.getElementById('editMemid').value = memid;
            document.getElementById('editStatus').value = currentStatus;
            var editModal = new bootstrap.Modal(document.getElementById('editStatusModal'));
            editModal.show();
        }

        function updateStatus() {
            var memid = document.getElementById('editMemid').value;
            var status = document.getElementById('editStatus').value;

            var formData = new FormData();
            formData.append('memid', memid);
            formData.append('status', status);

            fetch('update_status.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Handle JSON response
            .then(data => {
                if (data.success) {
                    showToast(data.success, 'bg-success'); // Success toast
                } else if (data.error) {
                    showToast(data.error, 'bg-danger'); // Error toast
                }
                location.reload(); // Refresh the page to see changes
            })
            .catch(error => {
                showToast('Error: ' + error.message, 'bg-danger'); // Error toast for any network issues
            });
        }

    </script>

</body>
</html>
