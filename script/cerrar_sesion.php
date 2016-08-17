<?php

session_start();
if (!empty($_SESSION['usuario'])) {
    session_destroy();
}
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: ../index.php");
}
?>