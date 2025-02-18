<?php
session_start();
require("../server/connection.php");

if (!isset($_SESSION["logged_in"]) || !isset($_SESSION["userid"])) {
    header("Location: ../login.php"); // Redirect if not logged in
    exit();
}

$userid = $_SESSION["userid"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["sportid"])) {
        $sportid = intval($_POST["sportid"]);

        // Check if the user is already a member
        $checkQuery = "SELECT * FROM membership WHERE userid = ?";
        $stmt = $connection->prepare($checkQuery);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION["error"] = "You have already joined a sport.";
            header("Location: sports.php");
            exit();
        } else {
            // Insert new membership record
            $insertQuery = "INSERT INTO membership (userid, sportid, stats) VALUES (?, ?, 'Pending')";
            $stmt = $connection->prepare($insertQuery);
            $stmt->bind_param("ii", $userid, $sportid);

            if ($stmt->execute()) {
                $_SESSION["success"] = "Your request to join the sport has been submitted.";
            } else {
                $_SESSION["error"] = "An error occurred. Please try again.";
            }

            header("Location: sports.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "Please select a sport.";
        header("Location: sports.php");
        exit();
    }
} else {
    header("Location: sports.php");
    exit();
}
?>
