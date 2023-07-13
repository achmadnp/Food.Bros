<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <link rel="stylesheet" href="css/regis.css">

    <?php include 'includes/navbar.php'; ?>
</head>

<body>
    <div class="wrapper">
        
        <div class="form-box register">
            <h4>Hier Registrieren!</h4>
            <form action="includes/register.inc.php" method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label>Benutzername</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" name="email" required>
                    <label>E-Mail</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>Passwort</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" name="pass_repeat" required>
                    <label>Passwort bestätigen</label>
                </div>
                <button type="submit" class="btn" name="register_submit">Registrieren</button>
                <div class="login-register">
                    <p>haben Sie bereits ein Konto?<a href="login.php" class="login-link">Anmelden</a>
                    </p>
                </div>
            </form>
            <?php
            // Fehlermeldung
            isset($_GET['err']) ? ($message = $_GET['err']) : ($message = '');
            if ($message !== '') {
              switch ($message) {
                case 'empty':
                  echo '<p>Eingabefelder sind unvollständig</p>';
                  break;

                case 'match':
                  echo '<p>Passwort stimmt nicht überein</p>';
                  break;

                case 'db':
                  echo '<p>Fehler an der Datenbank. Bitte versuchen Sie es später erneut</p>';
                  break;

                case 'taken':
                  echo '<p>Benutzer ist vergeben </p>';
                  break;

                case 'fail':
                  echo '<p>Bitte versuchen Sie es später erneut</p>';
                  break;
              }
            }
            ?>    
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>