<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ανάθεση Λίστας</title>
    <link rel="icon" href="images/trello.png" />
</head>
<body>
    <h1>Ανάθεση Λίστας</h1>

    <form action="assign_process.php" method="POST">
        <label for="user_id">Επιλογή Χρήστη:</label>
        <select name="user_id" id="user_id" required>
            <?php
            include('connection.php');// σύνδεση με τη βάση

            $sql = "SELECT * FROM user";//ανάκτηση όλων των χρηστών
            $result = mysqli_query($con, $sql);

            // Έλεγχος αν υπάρχουν χρήστες
            if (mysqli_num_rows($result) > 0) {
                // Διατρέχει κάθε χρήστη και τον εμφανίζει ως επιλογή
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
                }
            } else {
                // Εμφανίζει μήνυμα αν δεν υπάρχουν διαθέσιμοι χρήστες
                echo "<option value=''>No users available</option>";
            }

            mysqli_close($con);// Κλείσιμο σύνδεσης με τη βάση
            ?>
        </select>

        <!-- Κρυφό πεδίο για την αποστολή του ID της λίστας στον εξυπηρετητή -->
        <input type="hidden" name="list_id" value="<?php echo $_GET['list_id']; ?>">

        <button type="submit">Ανάθεση Λίστας</button>
        <a href="tasks.php" class="cancel-button">Ακύρωση</a>
    </form>
</body>
</html>
