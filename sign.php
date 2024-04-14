<!DOCTYPE html>

<?php
include ('connection.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $check_query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($result) > 0) {
       // Υπάρχει ήδη χρήστης με το ίδιο username
       echo '<script language="javascript">alert("Υπάρχει ήδη ένας χρήστης με αυτό το όνομα χρήστη. Παρακαλώ εισαγάγετε ένα διαφορετικό όνομα χρήστη.")</script>';
    } else {
       // Ο χρήστης μπορεί να εγγραφεί, καθώς το όνομα χρήστη είναι μοναδικό
       // Εκτέλεση ερωτήματος SQL για εισαγωγή δεδομένων
    $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($con->query($sql) === TRUE) {
        echo '<script language="javascript">alert("Η εγγραφή πραγματοποιήθηκε με επιτυχία!")</script';
    } else {
        echo '<script language="javascript">alert("Σφάλμα κατά την εγγραφή: ")</script' . $con->error;
    }
    }

    
}
?>


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
                  <li><a href="tasks.php">Λίστες Εργασιών</a></li>
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

    <form action="sign.php" onsubmit="return validateForm()" method="post">
      <h1>Εγγραφή Χρήστη</h1>
      <label for="username">Όνομα Χρήστη:</label>
      <input type="text" id="username" name="username" required />

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Κωδικός Πρόσβασης:</label>
      <input type="password" id="password" name="password" required />

      <label for="confirm-password">Επιβεβαίωση Κωδικού:</label>
      <input type="password" id="confirm-password" name="confirm-password" required/>

      <button type="submit">Εγγραφή</button>
    </form>

        <script>
          function validateForm() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;

            // Έλεγχος για το αν ο χρήστης έχει εισάγει έγκυρο όνομα χρήστη
            if (username.length < 5) {
              alert("Το όνομα χρήστη πρέπει να περιέχει τουλάχιστον 5 χαρακτήρες.");
              return false;
            }

            // Έλεγχος για τον κωδικό πρόσβασης
            if (password.length < 8 || !password.match(/[0-9]/) || !password.match(/[A-Z]/)) {
              alert("Ο κωδικός πρόσβασης πρέπει να περιέχει τουλάχιστον 8 χαρακτήρες, έναν αριθμητικό χαρακτήρα και ένα κεφαλαίο γράμμα.");
              return false;
            }

            // Έλεγχος για την επιβεβαίωση του κωδικού πρόσβασης
            if (password !== confirmPassword) {
              alert("Ο κωδικός πρόσβασης και η επιβεβαίωση δεν ταιριάζουν.");
              return false;
            }

            return true;
          }
        </script>

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
