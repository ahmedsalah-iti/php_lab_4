<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$showErrors = "";
if (isset($_GET['err']) && !empty(($_GET['err']) && is_numeric($_GET['err']) )){
    $showErrors = $_GET['err'];
}
    include("./session.php");
    include("./functions.php");
    include("./pages/header.php");
    if (isset($_SESSION["email"]) && !empty($_SESSION["email"])){
        include("./pages/dashboard.php");
    }else{
        if (isset($_GET["action"]) && !empty($_GET['action']) && $_GET['action'] === 'login') {
            include("./pages/login.php");
        }else if (isset($_GET["action"]) && !empty($_GET['action']) && $_GET['action'] === 'register') {
            include("./pages/register.php");
        }else{
            include("./pages/home.php");
        }
    }

    include("./pages/footer.php");


    
?>