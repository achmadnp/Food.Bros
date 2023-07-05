<?php
if (isset($_POST['register_submit'])) {
    require 'dbconnect.inc.php';
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $pass_repeat = htmlspecialchars($_POST['pass_repeat']);

    if (empty($username) || empty($password) || empty($pass_repeat)) {
        if (empty($username)) {
            header('Location: ..register.php?err=empty');
            exit();
        }
        header('Location: ../register.php?err=empty&username=' . $username);
        exit();
    } else if ($password !== $pass_repeat) {
        header('Location: ../register.php?err=match&username=' . $username);
    } else {
        $stmt = $connection->prepare("SELECT * FROM user WHERE username=?;");
        if ($stmt) {
            header('Location: ../register.php?err=database&username=' . $username);
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
            $stmt = $connection->prepare("INSERT INTO user (name, passhash, time) VALUES (?, ?, ?);");
            if ($stmt) {
                header('Location: ../register.php?err=db&username=' . $username);
                exit();
            }
            $passhash = password_hash($password, PASSWORD_BCRYPT);
            $timestamp = date('Y-m-d H:i:s');
            $stmt->bind_param('sss', $name, $passhash, $timestamp);
            $stmt->execute();
            if (!$stmt) {
                header('Location: ../register.php?err=failed&username=' . $username);
            }
            $stmt->close();
            $stmt = $connection->prepare("SELECT * FROM user WHERE username=?;");
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
    $connection->close();
}