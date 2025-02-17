<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySimpleWebsite</title>
    <style>
        input{
            padding: 1%;margin: auto;

        }
        .error_msg{
            background-color: lightcoral;
            /* font-size: larger; */
            color: red;
            border: 1px solid red;
            padding:1%;
        }
        .success_msg{
            background-color: lightgreen;
            /* font-size: larger; */
            color: green;
            border: 1px solid green;
            padding:1%;
        }
    </style>
</head>
<body>

<div style="width: 100%;border: 1px solid red;text-align:center;">
    Welcome to our simple website.
    <br>
    <?php
        if (isset($_SESSION['email']) && !empty($_SESSION['email'])){
            echo '<a style="background-color:red;" href="logout.php">LOGOUT</a>';
        }
    ?>
</div>
<br>