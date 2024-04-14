<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('connection.php'); // Συνδεση με τη βάση 

    $teamName = $_POST['teamName'];

    // Προσθήκη της νέας ομάδας στη βάση δεδομένων
    $stmt = $con->prepare("INSERT INTO team (name) VALUES (?)");
    $stmt->bind_param("s", $teamName);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo'<script language="javascript"> document.location="teams.php";</script>';
    } else {//μήνυμα λάθους
        echo "Κάτι πήγε στραβά. Η ομάδα δεν δημιουργήθηκε.";
    }

    $stmt->close();
    $con->close();
}
?>
