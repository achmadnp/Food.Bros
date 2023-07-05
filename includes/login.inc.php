<?php
if (isset($_POST['login_submit'])) {
    require 'dbconn.inc.php';

    $name = $_POST['name'];
    $password = $_POST['password'];

    if (empty($name) || empty($password)) {
        header('Location: ../login.php?ms=empty&name=' . $name);
        exit();
    } else {
        include 'dbconn.inc.php';
        $stmt = $conn->prepare("SELECT * FROM user WHERE name=?");
        if ($stmt) {
            header('Location: ../login.php?ms=db&name=' . $name);
            exit();
        }
        $stmt->bind_param('s', $name);
        $stmt->execute();

        $result = $stmt->get_result();
        $result_row = $result->fetch_assoc();
        }

        if (!$stmt) {
            header('Location: ../login.php?ms=notfound&true=' . $name);
            exit();
        } else {
            $validate= password_verify($password, $result_row['password_hash']);
        }

        if (!$validate) {
            header('Location: ../login.php?ms=wrong&name=' . $name);
        } else {
            session_start();
            $_SESSION['user'] = $result_row['name'];
            $_SESSION['id'] = $result_row['id'];
            if (!is_null($result_row['active_menu'])) {
                $_SESSION['mid'] = $result_row['active_menu'];
            }

            header('Location: ../index.php');
        }
        $stmt->close();
        $conn->close();
}