<?php
if (basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'register.php' && basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'register.php') {
    ini_set('session.gc_maxlifetime', 24 * 60 * 60); // 24 hours
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ./login.php');
    }
}