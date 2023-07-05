<?php
$conn = mysqli_connect('localhost', 'root', '', 'foodbros');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}