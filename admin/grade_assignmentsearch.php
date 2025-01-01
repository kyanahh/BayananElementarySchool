<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT student_grade_levels.*, users.firstname, 
                users.lastname, grade_levels.grade_name
                FROM ((student_grade_levels INNER JOIN users 
                ON student_grade_levels.updatedby = users.userid)
                INNER JOIN grade_levels 
                ON student_grade_levels.gradeid = grade_levels.grade_id) 
                WHERE grade_levels.grade_name LIKE '%$query%' 
                OR users.firstname LIKE '%$query%' 
                OR users.lastname LIKE '%$query%' 
                OR student_grade_levels.studentid LIKE '%$query%' 
                ORDER BY assigneddate DESC";
    } else {
        $sql = "SELECT student_grade_levels.*, users.firstname, 
                users.lastname, grade_levels.grade_name
                FROM ((student_grade_levels INNER JOIN users 
                ON student_grade_levels.updatedby = users.userid)
                INNER JOIN grade_levels 
                ON student_grade_levels.gradeid = grade_levels.grade_id) 
                ORDER BY assigneddate DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['studentid'] . '</td>';
            echo '<td>' . $row['grade_name'] . '</td>';
            echo '<td>' . $row['assigneddate'] . '</td>';
            echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-primary me-2" onclick="editAssignment(' . $row['id'] . ')">Edit</button>';
            echo '<button class="btn btn-danger" onclick="openDeleteModal(' . $row['id'] . ')">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No grade assignment found.</td></tr>';
    }
}

?>