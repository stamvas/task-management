<?php
include('connection.php');

// Έλεγχος αν έχει πατηθεί το κουμπί Αποθήκευση Αλλαγών
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ανάκτηση του ID της λίστας από το αίτημα POST
    $list_id = $_POST['list_id'];
    
    // Ανάκτηση των νέων δεδομένων της λίστας από το αίτημα POST
    $title = $_POST['title'];
    $category = $_POST['category'];
    
    // Ενημέρωση των δεδομένων της λίστας στη βάση δεδομένων
    $sql = "UPDATE task_list SET title = '$title', category = '$category' WHERE task_list_id = $list_id";
    
    if (mysqli_query($con, $sql)) {
        // Αν η ενημέρωση είναι επιτυχής, ανακατεύθυνση στη σελίδα tasks.php
        header("Location: tasks.php");
        exit();
    } else {
        // Αν προκύψει σφάλμα κατά την ενημέρωση, εμφάνιση μηνύματος σφάλματος
        echo "Προέκυψε σφάλμα κατά την ενημέρωση της λίστας εργασιών: " . mysqli_error($con);
    }
}

// Ανάκτηση του ID της λίστας από το αίτημα GET
$list_id = $_GET['list_id'];

// Εκτέλεση ερωτήματος για την ανάκτηση των δεδομένων της λίστας από τη βάση δεδομένων
$sql = "SELECT * FROM task_list WHERE task_list_id = $list_id";
$result = mysqli_query($con, $sql);

// Έλεγχος αν υπάρχει τουλάχιστον ένα αποτέλεσμα
if (mysqli_num_rows($result) > 0) {
    // Ανάκτηση των δεδομένων της λίστας
    $row = mysqli_fetch_assoc($result);
    
    // Αποθήκευση των δεδομένων της λίστας σε μεταβλητές
    $title = $row['title'];
    $category = $row['category'];
} else {
    // Αν δεν υπάρχει αποτέλεσμα, εμφάνιση μηνύματος λάθους
    echo "Η λίστα εργασιών δεν βρέθηκε.";
}

// Κλείσιμο της σύνδεσης με τη βάση δεδομένων
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Λίστας Εργασιών</title>
    <link rel="icon" href="images/trello.png" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Επεξεργασία Λίστας Εργασιών</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
        <label for="title">Τίτλος Λίστας:</label>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>
        <label for="category">Κατηγορία:</label>
        <input type="text" id="category" name="category" value="<?php echo $category; ?>" required>
        <button type="submit">Αποθήκευση Αλλαγών</button>
        <a href="tasks.php" class="cancel-button">Ακύρωση</a>
    </form>
</body>
</html>
