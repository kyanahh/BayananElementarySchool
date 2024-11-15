<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT userid, firstname, lastname, email, DATE_FORMAT(bday, '%M %d, %Y') AS bday
                FROM users 
                WHERE (userid LIKE '%$query%' 
                OR firstname LIKE '%$query%' 
                OR lastname LIKE '%$query%' 
                OR email LIKE '%$query%' 
                OR DATE_FORMAT(bday, '%M %d, %Y') LIKE '%$query%' 
                OR DATE_FORMAT(bday, '%m/%d/%Y') LIKE '%$query%')
                AND usertypeid = 1 
                ORDER BY userid DESC";
    } else {
        $sql = "SELECT userid, firstname, lastname, email, DATE_FORMAT(bday, '%M %d, %Y') AS bday
                FROM users 
                WHERE usertypeid = 1 
                ORDER BY userid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['userid'] . '</td>';
            echo '<td>' . $row['firstname'] . '</td>';
            echo '<td>' . $row['lastname'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['bday'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-info me-2" onclick="viewUser(' . $row['userid'] . ')">View</button>';
            echo '<button class="btn btn-primary me-2" onclick="editUser(' . $row['userid'] . ')">Edit</button>';
            echo '<button class="btn btn-danger" onclick="deleteUser(' . $row['userid'] . ')">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++;
        }
    } else {
        echo '<tr><td colspan="10">No admin found.</td></tr>';
    }
}

?>