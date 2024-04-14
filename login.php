<?php
session_start();
$error = '';

//Κανονικός κώδικας σύνδεσης για την περίπτωση που ο χρήστης δεν είναι συνδεδεμένος
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  include('connection.php'); // Συνδεση με τη βάση
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT user_id, password FROM user WHERE username = '$username'";
  $result = mysqli_query($con, $query);

  if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);

      // Έλεγχος κωδικού πρόσβασης
      if (password_verify($password, $row['password'])) {
          // Σύνδεση επιτυχής, αποθηκεύστε το user_id στη συνεδρία
          $_SESSION['user_id'] = $row['user_id'];
          header("Location: tasks.php"); // Ανακατεύθυνση στη σελίδα tasks.php
          exit;
      } else {
          // Λάθος κωδικός
          $error = 'Λάθος κωδικός πρόσβασης.';
          
      }
  } else {
      // Ο χρήστης δεν βρέθηκε
      $error = 'Ο χρήστης δεν βρέθηκε.';
  }

  $con->close();
}
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
                  <li><a href="tasks.php">Λίστες Εργασιών</a></li>
                  <li><a href="teams.php">Ομάδες</a></li>
                  <li class="current">
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

    <?php echo $error; ?>
    <form method="POST" onsubmit="return validateForm()">
      <h1>Είσοδος Χρήστη</h1>
      <label for="username">Όνομα Χρήστη:</label>
      <input type="text" id="username" name="username" />

      <label for="password">Κωδικός Πρόσβασης:</label>
      <input type="password" id="password" name="password"/>

      <button type="submit">Είσοδος</button>
      <a href="sign.php" class="register-link">Εγγραφή</a>
    </form>

    <script>
    function validateForm() {
      var username = document.getElementById('username').value;
      var password = document.getElementById('password').value;

      // Ελέγχουμε εάν τα πεδία έχουν εισαχθεί
      if (username.trim() === '' || password.trim() === '') {
        alert('Παρακαλώ εισάγετε όνομα χρήστη και κωδικό πρόσβασης.');
        return false;
      }
      // Εάν φτάσουμε εδώ, τα στοιχεία είναι σωστά
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
