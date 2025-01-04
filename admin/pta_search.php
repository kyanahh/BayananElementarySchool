<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT pta.*, 
                DATE_FORMAT(pta.dateposted, '%M %d, %Y') AS datepost, users.firstname, users.lastname  
                FROM pta INNER JOIN users
                    ON pta.postedby = users.userid 
                WHERE pta.ptatitle LIKE '%$query%' 
                OR pta.ptapost LIKE '%$query%' 
                OR pta.dateposted LIKE '%$query%' 
                OR users.firstname LIKE '%$query%' 
                OR users.lastname LIKE '%$query%' 
                OR DATE_FORMAT(pta.dateposted, '%M %d, %Y') LIKE '%$query%' 
                ORDER BY ptaid DESC";
    } else {
        $sql = "SELECT pta.*, 
                DATE_FORMAT(pta.dateposted, '%M %d, %Y') AS datepost, users.firstname, users.lastname  
                FROM pta INNER JOIN users
                    ON pta.postedby = users.userid 
                ORDER BY ptaid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['ptatitle'] . '</td>';
            echo '<td>' . $row['ptapost'] . '</td>';
            echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
            echo '<td>' . $row['datepost'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-primary me-2" onclick="editPTA(' . $row['ptaid'] . ')">Edit</button>';
            echo '<button class="btn btn-danger" onclick="openDeleteModal(' . $row['ptaid'] . ')">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No posts found.</td></tr>';
    }
}

?>