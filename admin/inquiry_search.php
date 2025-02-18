<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT * FROM inquiry 
                WHERE fullname LIKE '%$query%' 
                OR email LIKE '%$query%' 
                OR dateposted LIKE '%$query%' 
                OR messages LIKE '%$query%' 
                OR DATE_FORMAT(dateposted, '%M %d, %Y') LIKE '%$query%' 
                ORDER BY inquiryid DESC ";
    } else {
        $sql = "SELECT * FROM inquiry 
                ORDER BY inquiryid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['fullname'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['messages'] . '</td>';
            echo '<td>' . $row['dateposted'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-danger" onclick="openDeleteModal(' . $row['inquiryid'] . ')">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No inquiry found.</td></tr>';
    }
}

?>