<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT applicationform.*, admission.addid 
                FROM applicationform 
                INNER JOIN admission ON applicationform.addid = admission.addid 
                WHERE applicationform.firstname LIKE '%$query%' 
                OR applicationform.lastname LIKE '%$query%' 
                OR applicationform.birthdate LIKE '%$query%' 
                OR DATE_FORMAT(applicationform.birthdate, '%M %d, %Y') LIKE '%$query%' 
                OR applicationform.appformid LIKE '%$query%' 
                OR admission.addid LIKE '%$query%' 
                ORDER BY appformid DESC";
    } else {
        $sql = "SELECT applicationform.*, admission.addid 
                FROM applicationform INNER JOIN admission
                ON applicationform.addid = admission.addid 
                ORDER BY appformid DESC";
    }

    $result = mysqli_query($connection, $sql);

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
}

?>