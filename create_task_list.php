<?php
// Σύνδεση με τη βάση δεδομένων
include ('connection.php');

// Λήψη δεδομένων από τη φόρμα
$listTitle = $_POST['listTitle'];
$category = $_POST['category'];
$status = $_POST['status']; // Η τιμή "New" προκαθορίζεται στη φόρμα

// Εισαγωγή δεδομένων στη βάση
$sql = "INSERT INTO task_list (title, category, status) VALUES ('$listTitle', '$category', '$status')";

if (mysqli_query($con, $sql)) {
    echo'<script language="javascript"> document.location="tasks.php";</script>';
} else {
    echo'<script language="javascript">alert("Προέκυψε σφάλμα κατά τη δημιουργία της λίστας εργασιών: ")</script>'. mysqli_error($con);
    echo'<script language="javascript"> document.location="tasks.php";</script>';
}

// Κλείσιμο σύνδεσης με τη βάση δεδομένων
mysqli_close($con);
?>
