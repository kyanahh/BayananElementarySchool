<?php
require("../server/connection.php");
require_once('../TCPDF-main/tcpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["appformid"])) {
    $appformid = $_POST["appformid"];

    // Fetch data from the database
    $query = "SELECT applicationform.*
              FROM applicationform 
              WHERE appformid = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $appformid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        // Prepare data
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $birthdate = $row["birthdate"];
        $birthplace = $row["birthplace"];
        $address = $row["address"];
        $parentname = $row["parentname"];
        $parentphone = $row["parentphone"];
        $parentemail = $row["parentemail"];
        $prevschool = $row["prevschool"];
        $prevschooladdress = $row["prevschooladdress"];
        $appstatus = $row["appstatus"];

        // Create PDF
        $pdf = new TCPDF();
        $pdf->SetTitle("Student Application Form");
        $pdf->AddPage();

        $html = "
        <h1 style='text-align: center;'>Student Application Form</h1>
        <h3>Student Information</h3>
        <p><strong>First Name:</strong> $firstname</p>
        <p><strong>Last Name:</strong> $lastname</p>
        <p><strong>Birthdate:</strong> $birthdate</p>
        <p><strong>Birthplace:</strong> $birthplace</p>
        <p><strong>Home Address:</strong> $address</p>

        <h3>Parent/Guardian Information</h3>
        <p><strong>Name:</strong> $parentname</p>
        <p><strong>Contact Number:</strong> $parentphone</p>
        <p><strong>Email:</strong> $parentemail</p>

        <h3>Previous Education (For Transferees)</h3>
        <p><strong>Previous School:</strong> $prevschool</p>
        <p><strong>Previous School Address:</strong> $prevschooladdress</p>

        <h3>Application Details</h3>
        <p><strong>Application Status:</strong> $appstatus</p>
        ";

        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF
        $pdf->Output("Application_Form_$appformid.pdf", 'D');
    } else {
        echo "No data found for the given application form ID.";
    }
} else {
    echo "Invalid request.";
}
?>
