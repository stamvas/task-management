<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Προσθήκη Μέλους</title>
    <link rel="icon" href="images/trello.png"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
</body>
</html>

<?php
// σύνδεση με τη βάση
include('connection.php');
// Λήψη του ID της ομάδας από την παράμετρο της διεύθυνσης URL
$teamId = isset($_GET['team_id']) ? $_GET['team_id'] : null;


// Εμφάνιση της φόρμας μόνο αν δεν έχει γίνει υποβολή
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<form class='form-container' action='add_member.php' method='POST'>
        <input type='hidden' name='teamId' value='" . $teamId . "'>
        <label for='userId'>Επιλέξτε Χρήστη:</label>
        <select id='userId' name='userId'>";
    // Εκτέλεση ερωτήματος για την ανάκτηση των χρηστών από τη βάση
    $usersQuery = "SELECT user_id, username FROM user";
    $usersResult = $con->query($usersQuery);
    while ($user = $usersResult->fetch_assoc()) {
        echo "<option value='" . $user['user_id'] . "'>" . $user['username'] . "</option>";
    }
    // Κλείσιμο της φόρμας
    echo "</select>
        <button id='add-user-btn' type='submit'>Προσθήκη Μέλους</button>
        <a href='teams.php' class='cancel-button'>Ακύρωση</a>
    </form>";
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];// Λήψη του ID του χρήστη από τη φόρμα
    $teamId = $_POST['teamId'];// Λήψη του ID της ομάδας από τη φόρμα

    // Έλεγχος αν ο χρήστης είναι ήδη μέλος της ομάδας
    $checkQuery = "SELECT * FROM user_team WHERE user_id = ? AND team_id = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("ii", $userId, $teamId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Προσθήκη του χρήστη στην ομάδα εάν δεν είναι ήδη μέλος
        $insertQuery = "INSERT INTO user_team (user_id, team_id) VALUES (?, ?)";
        $insertStmt = $con->prepare($insertQuery);
        $insertStmt->bind_param("ii", $userId, $teamId);
        $insertStmt->execute();

        // Ανακατεύθυνση στη σελίδα των ομάδων μετά την επιτυχή προσθήκη
        if ($insertStmt->affected_rows > 0) {
            header("Location: teams.php");
        } else {
            // Εμφάνιση μηνύματος σφάλματος σε περίπτωση αποτυχίας
            echo "<div class='error-message'>Σφάλμα κατά την προσθήκη του μέλους στην ομάδα.</div>";
            echo "<button onclick='goBack()' class='back-button'>Πίσω</button>";
        }
    } else {// Εμφάνιση μηνύματος σφάλματος 
        echo "<div class='error-message'>Η λίστα έχει ήδη ανατεθεί σε αυτόν το χρήστη.</div>";
        echo "<button onclick='goBack()' class='back-button'>Πίσω</button>";
    }
    $con->close();
}
?>
<!-- Συνάρτηση για την επιστροφή στην προηγούμενη σελίδα -->
<script>
function goBack() {
    window.history.back();
}
</script>





