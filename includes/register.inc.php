<?php
if (isset($_POST['register_submit'])) {
  require 'dbconn.inc.php';
  $username = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $pass_repeat = htmlspecialchars($_POST['pass_repeat']);

  if (empty($username) || empty($password) || empty($pass_repeat)) {
    if (empty($username)) {
      header('Location: ..register.php?err=empty');
      exit();
    }
    header('Location: ../register.php?err=empty&username=' . $username);
    exit();
  } elseif ($password !== $pass_repeat) {
    header('Location: ../register.php?err=match&username=' . $username);
  } else {
    $stmt = $conn->prepare("SELECT * FROM user WHERE username=?");
    if (!$stmt) {
      header('Location: ../register.php?err=db&username=' . $username);
      exit();
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    $result = $stmt->num_rows();

    if ($result > 0) {
      header('Location: ../register.php?err=taken&username=' . $username);
      exit();
    } else {
      $stmt->close();
      $stmt = $conn->prepare(
        "INSERT INTO user (username, email, passhash) VALUES (?, ?, ?);"
      );
      if (!$stmt) {
        header('Location: ../register.php?err=db&username=' . $username);
        exit();
      }
      $passhash = password_hash($password, PASSWORD_BCRYPT);
      $stmt->bind_param('sss', $username, $email, $passhash);
      $stmt->execute();
      if (!$stmt) {
        header('Location: ../register.php?err=failed&username=' . $username);
      }
      $stmt->close();
      $stmt = $conn->prepare("SELECT * FROM user WHERE username=?;");
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $result = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      session_start();
      $_SESSION['user'] = $username;
      $_SESSION['id'] = $result['id'];
      header('Location: ../index.php');
    }
  }
  $stmt->close();
  $conn->close();
}
