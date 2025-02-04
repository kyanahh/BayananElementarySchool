<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT events.id, events.postitle, events.postdesc, 
                DATE_FORMAT(events.dateposted, '%M %d, %Y') AS datepost, users.firstname, users.lastname  
                FROM events INNER JOIN users
                    ON events.postedby = users.userid 
                WHERE events.postitle LIKE '%$query%' 
                OR events.postdesc LIKE '%$query%' 
                OR events.dateposted LIKE '%$query%' 
                OR users.firstname LIKE '%$query%' 
                OR users.lastname LIKE '%$query%' 
                OR DATE_FORMAT(events.dateposted, '%M %d, %Y') LIKE '%$query%' 
                ORDER BY id DESC";
    } else {
        $sql = "SELECT events.id, events.postitle, events.postdesc, 
                DATE_FORMAT(events.dateposted, '%M %d, %Y') AS datepost, users.firstname, users.lastname  
                FROM events INNER JOIN users
                    ON events.postedby = users.userid 
                ORDER BY id DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['postitle'] . '</td>';
            echo '<td>' . $row['postdesc'] . '</td>';
            echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
            echo '<td>' . $row['datepost'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-primary me-2" onclick="edit(' . $row['id'] . ')">Edit</button>';
            echo '<button class="btn btn-danger" onclick="openDeleteModal(' . $row['id'] . ')">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No upcoming events found.</td></tr>';
    }
}

?>