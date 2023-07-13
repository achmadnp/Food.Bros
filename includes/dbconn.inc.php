<?php
$conn = mysqli_connect('localhost', 'root', '', 'food.bros_schema');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
