<?php
    session_start();
    if (isset($_GET["action"]) && !empty($_GET['action']) && ($_GET['action'] === 'login' || $_GET['action'] === 'register')) {
            
    }else{
        if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
            header("location: logout.php");
        }
    }
        if (isset($_SESSION['profile_img']) && (!$_SESSION['profile_img'] || !file_exists($_SESSION['profile_img']))){
            $_SESSION['profile_img'] = './uploads/empty.jpg';
        }
?>