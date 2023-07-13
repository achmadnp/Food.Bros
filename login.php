<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/login.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <?php include 'includes/navbar.php'; ?>
</head>

<body>
    <div class="wrapper">
        <div class="form-box login">
            <h2>FOOD.BROS</h2>
            <h3>WILLKOMMEN ZURÜCK</h3>
            <form action="includes/login.inc.php" method="post">
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
                <button type="submit" class="btn" name="login_submit">Anmelden</button>
                <div class="login-register">
                    <p>Haben Sie noch kein Konto? <a href="register.php" class="register-link">Registrieren</a>
                    </p>
                </div>
            </form>    
            <?php
            // Fehlermeldung
            isset($_GET['ms']) ? ($message = $_GET['ms']) : ($message = '');
            if ($message !== '') {
              switch ($message) {
                case 'empty':
                  echo '<p>Eingabefelder sind unvollständig</p>';
                  break;

                case 'db':
                  echo '<p>Fehler an der Datenbank. Bitte versuchen Sie es später erneut</p>';
                  break;

                case 'wrong':
                  echo '<p>Falsche Anmeldedaten</p>';
                  break;

                case 'notfound':
                  echo '<p>Benutzer existiert nicht</p>';
                  break;
              }
            }
            ?>
        </div>
    </div>

</body>

</html>