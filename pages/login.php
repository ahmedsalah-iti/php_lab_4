
<form method="post" style="margin:auto;" enctype="multipart/form-data" >

<fieldset style="border: 5px solid red;padding:2%;width:70%;margin:auto;">
    <legend  style="border: 3px solid black;font-size:30px;">Login</legend>
    <label>Email: <input type="text" name="email" style="width:100%"  ></label>
    <br><br>
    <label>Password: <input type="password" name="password" style="width:100%"  ></label>
    <br><br>
    <label>
        <input type="submit" value="Login" name="btn_login">
    </label>
    <hr>
    Are You new User ? : <a href="index.php?action=register">Register NOW</a>
    <hr>
    <br>
    <?php
    showMsg(errNum: $showErrors);
    ?>
    </fieldset>

</form>
<?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (
                isset($_POST['email'] ) &&
                isset($_POST['password'] ) &&
                !empty($_POST['email']) &&
                !empty($_POST['password'])
            
            ){
                $email = strtolower(addslashes(htmlspecialchars(trim($_POST['email']))));
                $password = addslashes(htmlspecialchars(trim($_POST['password'])));
            

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    header('location: ?err=3&action='.$_GET["action"].'');
                    die();
                }

                if (isValidLogin($email, $password)){
                    $userLoginData = getDataByEmail($email);
                    $_SESSION['email'] = $userLoginData['email'];
                    $_SESSION['name'] = $userLoginData['name'];
                    $_SESSION['room_number'] = $userLoginData['room_number'];
                    $_SESSION['ext'] = $userLoginData['ext'];
                    $_SESSION['profile_img'] = $userLoginData['profile_img'];
                    header('location: ?err=13&action='.$_GET["action"].'');
                }else{
                    header('location: ?err=14&action='.$_GET["action"].'');
                }
            
            }else{
                header('location: ?err=1&action='.$_GET["action"].'');
            }

        }

?>