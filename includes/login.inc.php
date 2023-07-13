<?php
if (isset($_POST['login_submit'])) {
  require 'dbconn.inc.php';
  $email = $_POST['email'];
  $password = $_POST['password'];
  if (empty($email) || empty($password)) {
    header('Location: ../login.php?ms=empty&email=' . $email);
    exit();
  } else {
    include 'dbconn.inc.php';
    $stmt = $conn->prepare("SELECT * FROM user WHERE email=?");
    if (!$stmt) {
      header('Location: ../login.php?ms=db&email=' . $email);
      exit();
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $result_row = $result->fetch_assoc();
  }

  if (!$stmt) {
    header('Location: ../login.php?ms=notfound&true=' . $email);
    exit();
  } else {
    echo $result_row['passhash'];
    $validate = password_verify($password, $result_row['passhash']);
  }

  if (!$validate) {
    header('Location: ../login.php?ms=wrong&email=' . $email);
  } else {
    session_start();
    $_SESSION['user'] = $result_row['email'];
    $_SESSION['id'] = $result_row['id'];
    if (!is_null($result_row['active_menu'])) {
      $_SESSION['mid'] = $result_row['active_menu'];
    }

    header('Location: ../index.php');
  }
  $stmt->close();
  $conn->close();
}
