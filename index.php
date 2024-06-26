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
                  <li class="current"><a href="index.php">Αρχική</a></li>
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

    <article>
      <header class="welcome-msg">
        <h1>Καλωσορίσατε στην Πλατφόρμα Διαχείρισης Εργασιών</h1>
      </header>

      <img
        src="images/calendar-gif.gif"
        alt="Calendar image"
        width="400"
        height="300"
      />

      <img
        src="images/view-img.png"
        alt="View image"
        width="400"
        height="300"
      />

      <img
        src="images/calendar-img.png"
        alt="Calendar image"
        width="400"
        height="300"
      />
    </article>

    <div class="btn-group">
      <button onclick="window.location.href='login.php'">Είσοδος</button>
      <button onclick="window.location.href='sign.php'">Εγγραφή</button>
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
