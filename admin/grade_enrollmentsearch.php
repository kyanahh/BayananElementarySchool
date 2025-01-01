<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT grade_levels.grade_name, enrollment_applications.* 
                FROM grade_levels INNER JOIN enrollment_applications 
                ON grade_levels.grade_id = enrollment_applications.gradeid 
                WHERE grade_levels.grade_name LIKE '%$query%' 
                OR enrollment_applications.studentid LIKE '%$query%' 
                OR enrollment_applications.application_status LIKE '%$query%' 
                OR enrollment_applications.remarks LIKE '%$query%' 
                ORDER BY appdate DESC";
    } else {
        $sql = "SELECT grade_levels.grade_name, enrollment_applications.* 
                FROM grade_levels INNER JOIN enrollment_applications 
                ON grade_levels.grade_id = enrollment_applications.gradeid
                ORDER BY appdate DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['applicationid'] . '</td>';
            echo '<td>' . $row['studentid'] . '</td>';
            echo '<td>' . $row['grade_name'] . '</td>';
            echo '<td>' . $row['appdate'] . '</td>';
            echo '<td>' . $row['application_status'] . '</td>';    
            echo '<td>' . $row['remarks'] . '</td>';    
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';

            if ($row['application_status'] == 'Pending') {
                echo '<button class="btn btn-success me-2" onclick="Approve(' . $row['applicationid'] . ')">Approve</button>';
                echo '<button class="btn btn-danger me-2" onclick="Rejected(' . $row['applicationid'] . ')">Reject</button>';

            }

            echo '<button class="btn btn-primary me-2" onclick="editEnrollment(' . $row['applicationid'] . ')">Edit</button>';
            echo '<button class="btn btn-danger" onclick="deleteEnrollment(' . $row['applicationid'] . ')">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No enrollment application found.</td></tr>';
    }
}

?>