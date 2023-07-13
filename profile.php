<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" type="text/css" href="./css/profile.css">

    <?php include 'includes/navbar.php'; ?>
    <?php include './includes/login_session.php'; ?>

    <?php if (isset($_SESSION['id'])) {
      require 'includes/functions.php';
      $user = get_user_detail($_SESSION['id']);
      $totalCont = count_user_cont($_SESSION['id']);
      $username = $user['username'];
      $email = $user['email'];
    } ?>

<?php if (isset($_POST['toggle_button'])) {
  // Toggle the visibility state
  $visibility =
    $_POST['component_visibility'] === 'hidden' ? 'visible' : 'hidden';
} else {
  // Set the initial visibility state
  $visibility = 'hidden';
} ?>
</head>

<body>
  <div class="profile-card">
    <?php echo "<h2>Userprofil</h2>
        <label>Benutzername: </label>
        <input type='text'value='$username' disabled>
        <label>E-mail:</label>
        <div> 
        <input type='text' id='email' value='$email' disabled>
        </div>
        <label>Totalbeitrag:</label> 
        ",
      implode(", ", $totalCont),
      "
      <div>
        <button type='submit' name='toggle_button' class='edit-btn'>Passwort ändern</button>
      </div>",
      "
      <div id='hidden-component' class='$visibility'>
      <form action='includes/profile.inc.php' method='post'>
        <label>Aktuelles Passwort:</label>
        <input type='password' id='password' name='pass_curr' required>  
        <label>Neues Passwort:</label>
        <input type='password' id='password' name='pass_new' required>
        <label>Neues Passwort wiederholen:</label>
        <input type='password' id='confirmPassword' name='pass_new_repeat'>
        <button type='submit' name='password_change_submit' class='edit-btn'>Bestätigen</button>
      </form>
      <div>
     </div>
    </div>"; ?>

    <?php
    if (isset($_GET['err'])) {
      $message = $_GET['err'];
      switch ($message) {
        case 'empty':
          echo '<p>Eingabefelder sind unvollständig</p>';
          break;

        case 'wrong':
          echo '<p>Ungültiges aktuelles Passwort<p>';
          break;

        case 'match':
          echo '<p>Passwort stimmt nicht überein</p>';
          break;

        case 'db':
          echo '<p>Fehler an der Datenbank. Bitte versuchen Sie es später erneut</p>';
          break;

        case 'fail':
          echo '<p>Bitte versuchen Sie es später erneut</p>';
          break;
      }
    }

    if (isset($_GET['code']) && $_GET['code'] === 'success') {
      echo '<p>Passwort erfolgreich aktualisiert<p>';
    }
    ?>
  </div>

  <script src="js/profileToggleHidden.js"></script>
</body>
</html>
