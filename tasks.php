<?php
// session_start();

    
// include ('connection.php');

// // Έλεγχος αν ο χρήστης δεν είναι συνδεδεμένος, τότε ανακατεύθυνση στη σελίδα σύνδεσης
// if (!isset($_SESSION['user_id'])) {
//     echo "<div id='error-message'>Πρέπει να συνδεθείτε για να δείτε αυτή τη σελίδα.</div>";
//     echo "<a href='login.php'>login</a>";
//     exit;
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!--author Vasilis Stamatis-->
    <meta charset="UTF-8" />
    <link href="style.css" rel="stylesheet" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tremmo Manage Your Team's Projects</title>
    <link rel="icon" href="images/trello.png" />
</head>

<body>
<header id="main-header">
    <h1 id="header1">Πλατφόρμα Διαχείρισης Εργασιών</h1>
    <table id="logo-nav-login">
        <tbody>
        <tr>
            <td>
                <h1 id="branding">
                    <a href="index.php">
                        <img
                            src="images/trello.png"
                            alt="Trello Logo"
                            width="50"
                            height="50"
                        />
                        <h6 class="branding-name">Tremmo</h6>
                    </a>
                </h1>
            </td>
            <td>
                <nav>
                    <ul>
                        <li><a href="index.php">Αρχική</a></li>
                        <li class="current">
                            <a href="tasks.php">Λίστες Εργασιών</a>
                        </li>
                        <li><a href="teams.php">Ομάδες</a></li>
                        <li>
                    <span id="login"
                    ><button
                            class="button-login"
                            onclick="window.location.href='login.php'"
                        >
                        Είσοδος
                      </button></span
                    >
                        </li>
                    </ul>
                </nav>
            </td>
            <td></td>
        </tr>
        </tbody>
    </table>
</header>

<h1 class="welcome-msg">Λίστες Εργασιών</h1>

<form class='create-list-form' action="create_task_list.php" method="POST">
    <h3>Δημιουργία Νέας Λίστας Εργασιών</h3>
    <label for="listTitle">Τίτλος Λίστας:</label>
    <input type="text" id="listTitle" name="listTitle" required />

    <label for="category">Κατηγορία:</label>
    <input type="text" id="category" name="category" required />

    <!-- Προκαθορισμένη κατάσταση "New" -->
    <input type="hidden" name="status" value="New">

    <button type="submit">Δημιουργία Λίστας</button>
</form>

<div class="task-list-container">
    <?php
    include('connection.php');

    // Εμφάνιση λιστών εργασιών από τη βάση δεδομένων
    $sql = "SELECT * FROM task_list ORDER BY status DESC";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='task-list'>";
            echo "<div class='task-list-frame'>";
            echo "<h2>{$row['title']}</h2>";
            
            // Ερώτηση για όλους τους χρήστες που έχουν ανατεθεί σε αυτή τη λίστα εργασιών
            $assignment_sql = "SELECT u.username 
                                FROM user u 
                                INNER JOIN tasklist_assignment a 
                                ON u.user_id = a.user_id 
                                WHERE a.task_list_id = {$row['task_list_id']}";
            $assignment_result = mysqli_query($con, $assignment_sql);

            if (mysqli_num_rows($assignment_result) > 0) {
                echo "<p><strong>Ανατεθειμένοι Χρήστες:</strong></p>";
                echo "<ul>";
                while ($assigned_user = mysqli_fetch_assoc($assignment_result)) {
                    echo "<li>{$assigned_user['username']}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p><strong>Ανατεθειμένοι Χρήστες:</strong> Δεν έχουν ανατεθεί ακόμα.</p>";
            }

            
            echo "<div class='task-buttons'>";

            echo "<form class='delete-button-form' action='delete_list.php' method='POST' onsubmit='return confirmDelete()'>";
            echo "<input type='hidden' name='list_id' value='{$row['task_list_id']}'>";
            echo "<a style='float:left' href='edit_list.php?list_id={$row['task_list_id']}' class='edit-button'><img src='images/pencil.png'/></a>";
            echo "<button style='float:right' class='delete-list-btn' type='submit'><img src='images/cross.png'/></button>";
            
            echo "<a href='assign_list.php?list_id={$row['task_list_id']}' class='assign-list-btn'><img src='images/assign.png'/></a>";
            echo "</form>";
            echo "</div>"; // task-buttons
            


            echo "<div class='details'>";
            echo "<p><strong>Κατηγορία:</strong> {$row['category']}</p>";
            echo "<p><strong>Κατάσταση:</strong> {$row['status']}</p>";

            $list_id = $row['task_list_id'];
            $tasks_sql = "SELECT task_id, title FROM task WHERE task_list_id = $list_id ORDER BY title ASC";
            $tasks_result = mysqli_query($con, $tasks_sql);

            
    

            if (mysqli_num_rows($tasks_result) > 0) {
                echo "<div class='tasks'>";
                echo "<p><strong>Εργασίες:</strong></p>";
                echo "<ul>";
                while ($task_row = mysqli_fetch_assoc($tasks_result)) {
                    echo "<li>{$task_row['title']} <form class='delete-task-btn' action='delete_task.php' method='POST' onsubmit='return confirmDelete()'>
                    <input type='hidden' name='task_id' value='{$task_row['task_id']}'>
                    <button class='delete-task-btn' type='submit'><img src='images/trash.png'/></button></form></li>";
                }
                echo "</ul>";
                echo "</div>"; // tasks
            } else {
                echo "<p>Δεν υπάρχουν εργασίες σε αυτή τη λίστα.</p>";
            }
            echo "<a href='add_task.php?list_id={$row['task_list_id']}' class='add-task-button'><img src='images/add.png'/></a>";

            
            echo "</div>"; // details
            echo "</div>"; // task-list-frame
            echo "</div>"; // task-list

            
        }
    } else {
        echo "<p>Δεν υπάρχουν διαθέσιμες λίστες εργασιών.</p>";
    }

    mysqli_close($con);
    ?>
</div>



<footer>
    <a href="pdf/terms-of-use.pdf" target="_blank">Όροι χρήσης |</a>

    <a href="pdf/privacy-policy.pdf" target="_blank">Πολιτική Απορρήτου</a>

    <p id="copyright">
        Copyright &copy; 2023 created by
        <a href="https://github.com/stamvas" target="_blank"
        >Vasilis Stamatis</a
        >
    </p>
</footer>

</body>
</html>

<script>
function confirmDelete() {// Συνάρτηση για επιβεβαίωση διαγραφής εργασίας
    return confirm("Είστε βέβαιοι ότι θέλετε να προχωρήσετε με τη διαγραφή;");
}
</script>

<script>
function confirmSign() {
    return confirm("Πρέπει να είστε συνδεδεμένοι για να δείτε τη σελίδα");
}
</script>
