<?php
include('connection.php');//σύνδεση με τη βάση

// Έλεγχος αν έχει πατηθεί το κουμπί Προσθήκη Εργασίας
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ανάκτηση του ID της λίστας από το αίτημα POST
    $list_id = $_POST['list_id'];
    // Ανάκτηση του τίτλου της νέας εργασίας από το αίτημα POST
    $taskTitle = $_POST['taskTitle'];
    
    // Εισαγωγή της νέας εργασίας στη βάση δεδομένων
    $sql = "INSERT INTO task (title, task_list_id) VALUES ('$taskTitle', $list_id)";
    
    if (mysqli_query($con, $sql)) {
        // Αν η εισαγωγή είναι επιτυχής, ανακατεύθυνση στη σελίδα tasks.php
        header("Location: tasks.php");
        exit();
    } else {
        // Αν προκύψει σφάλμα κατά την εισαγωγή, εμφάνιση μηνύματος σφάλματος
        echo "Προέκυψε σφάλμα κατά την προσθήκη νέας εργασίας: " . mysqli_error($con);
    }
}

// Κλείσιμο της σύνδεσης με τη βάση δεδομένων
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Προσθήκη Νέας Εργασίας</title>
    <link rel="icon" href="images/trello.png" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Προσθήκη Νέας Εργασίας</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="hidden" name="list_id" value="<?php echo $_GET['list_id']; ?>">
        <label for="taskTitle">Τίτλος Εργασίας:</label>
        <input type="text" id="taskTitle" name="taskTitle" required>
        <button type="submit">Προσθήκη Εργασίας</button>
        <a href="tasks.php" class="cancel-button">Ακύρωση</a>
    </form>
</body>
</html>
