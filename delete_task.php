<?php
include('connection.php');

// Έλεγχος αν έχει πατηθεί το κουμπί Διαγραφή
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ανάκτηση του ID της εργασίας από το αίτημα POST
    $task_id = $_POST['task_id'];
    
    // Εκτέλεση ερωτήματος για τη διαγραφή της εργασίας από τη βάση δεδομένων
    $sql = "DELETE FROM task WHERE task_id = $task_id";
    
    if (mysqli_query($con, $sql)) {
        // Αν η διαγραφή είναι επιτυχής, ανακατεύθυνση στη σελίδα tasks.php
        header("Location: tasks.php");
        exit();
    } else {
        // Αν προκύψει σφάλμα κατά τη διαγραφή, εμφάνιση μηνύματος σφάλματος
        echo "Προέκυψε σφάλμα κατά τη διαγραφή της εργασίας: " . mysqli_error($con);
    }
}

// Κλείσιμο της σύνδεσης με τη βάση δεδομένων
mysqli_close($con);
?>
