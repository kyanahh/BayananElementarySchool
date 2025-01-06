<?php
session_start();
require("../server/connection.php");

if (isset($_SESSION["logged_in"])) {
    $textaccount = $_SESSION["firstname"] ?? "Account";
    $lname = $_SESSION["lastname"] ?? "";
    $useremail = $_SESSION["email"] ?? "";
} else {
    $textaccount = "Account";
}

// Fetch Data
$data = [];

// Total number of users per type
$result = $connection->query("SELECT usertypeid, COUNT(*) AS total FROM users GROUP BY usertypeid");
while ($row = $result->fetch_assoc()) {
    $data['usertype'][$row['usertypeid']] = $row['total'];
}

// Total male and female users
$result = $connection->query("SELECT genderid, COUNT(*) AS total FROM users WHERE usertypeid = 3 GROUP BY genderid");
while ($row = $result->fetch_assoc()) {
    $data['gender'][$row['genderid']] = $row['total'];
}

// Total admissions
$result = $connection->query("SELECT COUNT(*) AS total FROM admission");
$data['total_admissions'] = $result->fetch_assoc()['total'];

// Approved and Rejected applications
$result = $connection->query("SELECT application_status, COUNT(*) AS total FROM enrollment_applications GROUP BY application_status");
while ($row = $result->fetch_assoc()) {
    $data['application_status'][$row['application_status']] = $row['total'];
}

// Total students per section
$result = $connection->query("SELECT cs.section_name, COUNT(csa.applicationid) AS total FROM class_section_assignments csa
                        JOIN class_sections cs ON csa.sectionid = cs.section_id GROUP BY cs.section_id");
while ($row = $result->fetch_assoc()) {
    $data['sections'][$row['section_name']] = $row['total'];
}

// Total students per grade level
$result = $connection->query("SELECT gl.grade_name, COUNT(ea.studentid) AS total FROM enrollment_applications ea
                        JOIN grade_levels gl ON ea.gradeid = gl.grade_id GROUP BY gl.grade_id");
while ($row = $result->fetch_assoc()) {
    $data['grades'][$row['grade_name']] = $row['total'];
}

// Total number of application forms
$result = $connection->query("SELECT COUNT(*) AS total FROM applicationform");
$data['total_application_forms'] = $result->fetch_assoc()['total'];

// Total number of civil status (join users and civilstatus table)
$result = $connection->query("SELECT cs.civilstats, COUNT(*) AS total 
                               FROM users u 
                               JOIN civilstatus cs ON u.civilstatus = cs.statusid 
                               GROUP BY u.civilstatus");
while ($row = $result->fetch_assoc()) {
    $data['civilstatus'][$row['civilstats']] = $row['total'];
}

// Total number of examiners per year (grouping by year from the examdate)
$result = $connection->query("SELECT YEAR(examdate) AS exam_year, COUNT(*) AS total FROM appsched GROUP BY exam_year");
while ($row = $result->fetch_assoc()) {
    $data['examiners_per_year'][$row['exam_year']] = $row['total'];
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
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="pta.php" class="nav-link px-sm-0 px-2 text-truncate">
                                <i class="fs-5 bi-person-vcard-fill"></i><span class="ms-1 d-none d-sm-inline">PTA</span> </a>
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
                <div class="container mt-4">
                    <h3 class="fw-bold">School Analytics Dashboard</h3>
                    <div class="row mt-4 mx-5">
                        <div class="col-md-6">
                            <canvas id="usertypeChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <canvas id="statusChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="sectionChart"></canvas>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <canvas id="gradeChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="examinersChart"></canvas>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <canvas id="applicationFormsChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="civilStatusChart"></canvas>
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
    // Prepare Data for Charts
    const usertypeData = {
        labels: ['Admin', 'Faculty', 'Student', 'Parent'],
        datasets: [{
            label: 'User Type Distribution',
            data: <?= json_encode(array_values($data['usertype'] ?? [])) ?>,
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
        }]
    };

    const genderData = {
        labels: ['Male', 'Female'],
        datasets: [{
            label: 'Gender Distribution',
            data: <?= json_encode(array_values($data['gender'] ?? [])) ?>,
            backgroundColor: ['#36A2EB', '#FF6384']
        }]
    };

    const statusData = {
        labels: ['Approved', 'Rejected'],
        datasets: [{
            label: 'Application Status',
            data: <?= json_encode(array_values($data['application_status'] ?? [])) ?>,
            backgroundColor: ['#4BC0C0', '#FF6384']
        }]
    };

    const sectionData = {
        labels: <?= json_encode(array_keys($data['sections'] ?? [])) ?>,
        datasets: [{
            label: 'Students per Section',
            data: <?= json_encode(array_values($data['sections'] ?? [])) ?>,
            backgroundColor: '#FFCE56'
        }]
    };

    const gradeData = {
        labels: <?= json_encode(array_keys($data['grades'] ?? [])) ?>,
        datasets: [{
            label: 'Students per Grade Level',
            data: <?= json_encode(array_values($data['grades'] ?? [])) ?>,
            backgroundColor: '#36A2EB'
        }]
    };

    const applicationFormsData = {
        labels: ['Total Application Forms'],
        datasets: [{
            label: 'Total Application Forms',
            data: [<?= $data['total_application_forms'] ?>],
            backgroundColor: '#FF5733'
        }]
    };

    const civilStatusData = {
        labels: <?= json_encode(array_keys($data['civil_status'] ?? [])) ?>,
        datasets: [{
            label: 'Civil Status Distribution',
            data: <?= json_encode(array_values($data['civil_status'] ?? [])) ?>,
            backgroundColor: '#FFD700'
        }]
    };

    const examinersData = {
        labels: <?= json_encode(array_keys($data['examiners_per_year'] ?? [])) ?>,
        datasets: [{
            label: 'Examiners per Year',
            data: <?= json_encode(array_values($data['examiners_per_year'] ?? [])) ?>,
            backgroundColor: '#8B0000'
        }]
    };

    // Render Charts
    new Chart(document.getElementById('usertypeChart'), { type: 'pie', data: usertypeData });
    new Chart(document.getElementById('genderChart'), { type: 'doughnut', data: genderData });
    new Chart(document.getElementById('statusChart'), { type: 'bar', data: statusData });
    new Chart(document.getElementById('sectionChart'), { type: 'bar', data: sectionData });
    new Chart(document.getElementById('gradeChart'), { type: 'line', data: gradeData });
    new Chart(document.getElementById('applicationFormsChart'), { type: 'pie', data: applicationFormsData });
    new Chart(document.getElementById('civilStatusChart'), { type: 'doughnut', data: civilStatusData });
    new Chart(document.getElementById('examinersChart'), { type: 'line', data: examinersData });
    </script>

</body>
</html>
