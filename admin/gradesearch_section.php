<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT grade_levels.grade_name, class_sections.* 
                FROM grade_levels INNER JOIN class_sections 
                ON grade_levels.grade_id = class_sections.grade_id 
                WHERE grade_levels.grade_name LIKE '%$query%' 
                OR class_sections.section_name LIKE '%$query%' 
                OR class_sections.adviser LIKE '%$query%' 
                ORDER BY grade_id ASC";
    } else {
        $sql = "SELECT grade_levels.grade_name, class_sections.* 
                FROM grade_levels INNER JOIN class_sections 
                ON grade_levels.grade_id = class_sections.grade_id 
                ORDER BY grade_id ASC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['grade_name'] . '</td>';
            echo '<td>' . $row['section_name'] . '</td>';
            echo '<td>' . $row['adviser'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-primary me-2" onclick="editSection(' . $row['section_id'] . ')">Edit</button>';
            echo '<button class="btn btn-danger" onclick="deleteSection(' . $row['section_id'] . ')">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No section found.</td></tr>';
    }
}

?>