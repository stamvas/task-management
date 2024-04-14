<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $list_id = $_POST['list_id'];
    $sql = "DELETE FROM task_list WHERE task_list_id = $list_id";
    
    if (mysqli_query($con, $sql)) {
        header("Location: tasks.php");
        exit();
    } else {
        echo "Προέκυψε σφάλμα κατά τη διαγραφή της λίστας εργασιών: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
