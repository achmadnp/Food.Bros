<?php if (isset($_POST['password_change_submit'])) {
  require 'dbconn.inc.php';
  session_start();
  $uid = $_SESSION['id'];
  $pass_curr = htmlspecialchars($_POST['pass_curr']);
  $pass_new = htmlspecialchars($_POST['pass_new']);
  $pass_repeat = htmlspecialchars($_POST['pass_new_repeat']);

  if (empty($pass_curr) || empty($pass_new) || empty($pass_repeat)) {
    header('Location: ../profile.php?err=empty');
    exit();
  }
  if ($pass_new !== $pass_repeat) {
    header('Location: ../profile.php?err=match');
    exit();
  }

  $stmt = $conn->prepare("SELECT * FROM user WHERE id=?");
  if (!$stmt) {
    header('Location: ../profile.php?err=db');
    exit();
  }

  $stmt->bind_param('i', $uid);
  $stmt->execute();

  if (!$stmt) {
    header('Location: ../profile.php?err=db');
    exit();
  }

  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $verify = password_verify($pass_curr, $row['passhash']);

  if (!$verify) {
    header('Location: ../profile.php?err=wrong');
    exit();
  }

  $passhash = password_hash($pass_new, PASSWORD_BCRYPT);
  $stmt->close();

  $stmt = $conn->prepare("UPDATE user SET passhash=? WHERE id=?");
  $stmt->bind_param('si', $passhash, $uid);
  $stmt->execute();
  if ($stmt) {
    header('Location: ../profile.php?code=success');
    exit();
  }
  $con->close();
}
