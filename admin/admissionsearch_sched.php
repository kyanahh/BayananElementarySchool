<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT applicationform.addid, applicationform.appformid,
                appsched.*  
                FROM appsched INNER JOIN applicationform 
                ON appsched.appformid = applicationform.appformid 
                WHERE applicationform.addid LIKE '%$query%' 
                OR applicationform.appformid LIKE '%$query%' 
                OR appsched.appstatus LIKE '%$query%' 
                OR appsched.examdate LIKE '%$query%' 
                OR DATE_FORMAT(appsched.examdate, '%b %e') LIKE '%$query%' -- For 'Jan 9'
                OR DATE_FORMAT(appsched.examdate, '%M %e') LIKE '%$query%' -- For 'January 9'
                OR DATE_FORMAT(appsched.examdate, '%M %d, %Y') LIKE '%$query%' 
                OR appsched.examvenue LIKE '%$query%' 
                OR appsched.remarks LIKE '%$query%' 
                ORDER BY examdate DESC";
    } else {
        $sql = "SELECT applicationform.addid, applicationform.appformid,
                appsched.*  
                FROM appsched INNER JOIN applicationform 
                ON appsched.appformid = applicationform.appformid 
                ORDER BY examdate DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['schedid'] . '</td>';
            echo '<td>' . $row['addid'] . '</td>';
            echo '<td>' . $row['appformid'] . '</td>';
            echo '<td>' . $row['appstatus'] . '</td>';
            echo '<td>' . (new DateTime($row['examdate']))->format('M j Y') . '</td>';
            echo '<td>' . $row['examvenue'] . '</td>';
            echo '<td>' . $row['remarks'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-primary me-2" onclick="editSched(' . $row['schedid'] . ')">Edit</button>';
            echo '<button class="btn btn-danger" onclick="deleteSched(' . $row['schedid'] . ')">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No admission schedule found.</td></tr>';
    }
}

?>