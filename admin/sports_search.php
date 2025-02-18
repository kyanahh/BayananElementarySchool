<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT membership.*, sports.*, 
                users.firstname, users.lastname 
                FROM ((membership 
                INNER JOIN sports 
                    ON membership.sportid = sports.sportid) 
                INNER JOIN users
                    ON membership.userid = users.userid) 
                WHERE membership.userid LIKE '%$query%' 
                OR users.firstname LIKE '%$query%' 
                OR users.lastname LIKE '%$query%' 
                OR membership.stats LIKE '%$query%' 
                OR sports.sportsname LIKE '%$query%' 
                OR sports.coach LIKE '%$query%' 
                ORDER BY membership.memid DESC ";
    } else {
        $sql = "SELECT membership.*, sports.*, 
                users.firstname, users.lastname 
                FROM ((membership 
                INNER JOIN sports 
                    ON membership.sportid = sports.sportid) 
                INNER JOIN users
                    ON membership.userid = users.userid)
                ORDER BY membership.memid DESC";
    }

    $result = mysqli_query($connection, $sql);

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
}

?>