<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["name"]) || !isset($_SESSION["role"]) || !isset($_SESSION["email"]) || !isset($_SESSION["id"])) {
    header("location:login.php");
}
?>