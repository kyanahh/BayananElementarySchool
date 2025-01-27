<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT 
                    users.firstname, 
                    users.lastname, 
                    class_section_assignments.assignmentid, 
                    class_sections.section_name, 
                    enrollment_applications.studentid, 
                    grade_levels.grade_name, 
                    class_section_assignments.assignmentdate
                FROM 
                    class_section_assignments
                INNER JOIN users 
                    ON class_section_assignments.assignedby = users.userid
                INNER JOIN enrollment_applications 
                    ON class_section_assignments.applicationid = enrollment_applications.applicationid 
                INNER JOIN class_sections 
                    ON class_section_assignments.sectionid = class_sections.section_id
                INNER JOIN grade_levels 
                    ON class_sections.grade_id = grade_levels.grade_id
                WHERE grade_levels.grade_name LIKE '%$query%' 
                OR users.firstname LIKE '%$query%' 
                OR users.lastname LIKE '%$query%' 
                OR enrollment_applications.studentid LIKE '%$query%' 
                OR grade_levels.grade_name LIKE '%$query%' 
                OR class_sections.section_name LIKE '%$query%' 
                ORDER BY 
                    class_section_assignments.assignmentdate DESC";
    } else {
        $sql = "SELECT 
                    users.firstname, 
                    users.lastname, 
                    class_section_assignments.assignmentid, 
                    class_sections.section_name, 
                    enrollment_applications.studentid,  
                    grade_levels.grade_name, 
                    class_section_assignments.assignmentdate
                FROM 
                    class_section_assignments
                INNER JOIN users 
                    ON class_section_assignments.assignedby = users.userid
                INNER JOIN enrollment_applications 
                    ON class_section_assignments.applicationid = enrollment_applications.applicationid
                INNER JOIN class_sections 
                    ON class_section_assignments.sectionid = class_sections.section_id
                INNER JOIN grade_levels 
                    ON class_sections.grade_id = grade_levels.grade_id
                ORDER BY 
                    class_section_assignments.assignmentdate DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['assignmentid'] . '</td>';
            echo '<td>' . $row['studentid'] . '</td>';
            echo '<td>' . $row['grade_name'] . '</td>';
            echo '<td>' . $row['section_name'] . '</td>';
            echo '<td>' . $row['assignmentdate'] . '</td>';
            echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-primary me-2" onclick="editClass(' . $row['assignmentid'] . ')">Edit</button>';
            echo '<button class="btn btn-danger" onclick="openDeleteModal(' . $row['assignmentid'] . ')">Delete</button>';
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