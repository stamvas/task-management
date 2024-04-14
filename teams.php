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
                  <li class="current"><a href="teams.php">Ομάδες</a></li>
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

    <h1 class="welcome-msg">Ομάδες</h1>
          <form class='create-team-form' action="create_team.php" method="POST">
              <h3>Δημιουργία Νέας Ομάδας</h3>
              <label for="teamName">Όνομα Ομάδας:</label>
              <input type="text" id="teamName" name="teamName" required>
              <button type="submit">Δημιουργία Ομάδας</button>
          </form>


          <?php
            include('connection.php');

            //εμφάνιση των ομάδων από τη βάση δεδομένων
            $queryTeams = "SELECT * FROM team";
            $resultTeams = $con->query($queryTeams);

            echo "<div class='team-container'>";

            if ($resultTeams->num_rows > 0) {
                while ($team = $resultTeams->fetch_assoc()) {// Εμφάνιση κάθε ομάδας με τα στοιχεία της
                    echo "<div class='team'><h2>" . $team['name'] . "</h2><ul>";

                    //Ερώτημα για την ανάκτηση των μελών κάθε ομάδας
                    $queryMembers = "SELECT u.username 
                                    FROM user u JOIN user_team ut 
                                    ON u.user_id = ut.user_id 
                                    WHERE ut.team_id = " . $team['team_id'];
                    $resultMembers = $con->query($queryMembers);

                    if ($resultMembers->num_rows > 0) {
                        while ($member = $resultMembers->fetch_assoc()) {
                            echo "<li>" . $member['username'] . "</li>";
                        }
                    } else {
                        echo "<li>Δεν υπάρχουν μέλη σε αυτή την ομάδα.</li>";
                    }// Σύνδεσμος για την προσθήκη νέου μέλους στην ομάδα
                    echo "<a href='add_member.php?team_id=" . $team['team_id'] . "' class='add-task-button'><img src='images/add.png'/></a>";

                    echo "</ul></div>";
                }
            } else {
                echo "Δεν υπάρχουν διαθέσιμες ομάδες.";
            }

            echo "</div>";
            $con->close();
          ?>




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
