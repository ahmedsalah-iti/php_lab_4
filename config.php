<?php
    define("DB_HOST","localhost");
    define("DB_DBNAME","php_test");
    define("DB_USER","php_tester");
    define("DB_PASS","123");
    define("DB_DSN","mysql:host=" . DB_HOST . ";dbname=" . DB_DBNAME . "");
    // $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_DBNAME . "";
    
    try{
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    //echo "connected.";
    } catch(PDOException $e){
        echo "". $e->getMessage();
        die();
    }

?>