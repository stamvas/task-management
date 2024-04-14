<?php
include('connection.php');//σύνδεση με τη βάση

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ελέγχουμε αν το list_id και το user_id έχουν περαστεί σωστά
    if (isset($_POST['list_id']) && isset($_POST['user_id'])) {
        $list_id = $_POST['list_id'];
        $user_id = $_POST['user_id'];

        // Ελέγχουμε αν η εργασία έχει ήδη ανατεθεί στον επιλεγμένο χρήστη
        $check_assignment_sql = "SELECT * FROM tasklist_assignment WHERE task_list_id = $list_id AND user_id = $user_id";
        $check_assignment_result = mysqli_query($con, $check_assignment_sql);

        if(mysqli_num_rows($check_assignment_result) > 0) {
            // Η εργασία έχει ήδη ανατεθεί στον επιλεγμένο χρήστη, εμφανίζουμε μήνυμα λάθους
            echo "<div class='error-message'>Η εργασία έχει ήδη ανατεθεί σε αυτόν το χρήστη.</div>";
            echo "<button onclick='goBack()' class='back-button'>Πίσω</button>";
        } else {
            // Η εργασία δεν έχει ανατεθεί ακόμα στον επιλεγμένο χρήστη, προβαίνουμε στην ανάθεση
            $assign_sql = "INSERT INTO tasklist_assignment (task_list_id, user_id) VALUES ($list_id, $user_id)";

            if (mysqli_query($con, $assign_sql)) {
                // Επιτυχής ανάθεση, ενημερώνουμε την κατάσταση της λίστας εργασιών σε "In Progress"
                $update_status_sql = "UPDATE task_list SET status = 'In Progress' WHERE task_list_id = $list_id";
                mysqli_query($con, $update_status_sql);

                echo "Η λίστα εργασιών ανατέθηκε με επιτυχία στον επιλεγμένο χρήστη.";
                header("Location: tasks.php");
            } else {
                echo "<div class='error-message'>Προέκυψε κάποιο σφάλμα κατά την ανάθεση της λίστας εργασιών.</div>";
                echo "<button onclick='goBack()' class='back-button'>Πίσω</button>";
            }
        }
    } else {
        echo "<div class='error-message'>Δεν έχουν περαστεί σωστά τα απαραίτητα δεδομένα.</div>";
        echo "<button onclick='goBack()' class='back-button'>Πίσω</button>";
    }
}

mysqli_close($con);
?>

<script>
function goBack() {
    window.history.back();
}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ανάθεση Λίστας</title>
    <link rel="icon" href="images/trello.png" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
</body>
</html>

