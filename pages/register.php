<form method="post" style="margin:auto;" enctype="multipart/form-data" >

<fieldset style="border: 5px solid red;padding:2%;width:70%;margin:auto;">
    <legend  style="border: 3px solid black;font-size:30px;">Register</legend>
    <label>Name: <input type="text" name="name" style="width:100%"></label>
    <br><br>
    <label>Email: <input type="text" name="email" style="width:100%"  ></label>
    <br><br>
    <label>Password: <input type="password" name="password" style="width:100%"  ></label>
    <br><br>
    <label>Confirm Password: <input type="password" name="confirm_password" style="width:100%"  ></label>
    <br><br>
    <label>RoomNumber: <input type="number" name="room_number" style="width:100%"  ></label>
    <br><br>
    <label>Ext: <input type="number" name="ext" style="width:100%"  ></label>
    <br><br>
    <div style="border: 1px solid gray;padding:1%;">

        <label>Profile Picture: <input type="file" name="profile_img" style="width:100%"  ></label>

    </div>
    <br><br>
    <label>
        <input type="submit" value="Register" name="btn_register">
    </label>
    <hr>
    do u already have account ? : <a href="index.php?action=login">LOGIN</a>
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
            isset($_POST['name'] ) &&
            isset($_POST['email'] ) &&
            isset($_POST['password'] ) &&
            isset($_POST['confirm_password'] ) &&
            isset($_POST['room_number'] ) &&
            isset($_POST['ext'] ) &&
            !empty($_POST['name']) &&
            !empty($_POST['email']) &&
            !empty($_POST['password']) &&
            !empty($_POST['confirm_password']) &&
            !empty($_POST['room_number']) &&
            !empty($_POST['ext'])
        
        ){
            $name = addslashes(htmlspecialchars(trim($_POST['name'])));
            $email = strtolower(addslashes(htmlspecialchars(trim($_POST['email']))));
            $password = addslashes(htmlspecialchars(trim($_POST['password'])));
            $confirm_password = addslashes(htmlspecialchars(trim($_POST['confirm_password'])));
            $room_number = $_POST['room_number'];
            $ext = $_POST['ext'];

        if (!isValidName($name)){
            header('location: ?err=4&action='.$_GET["action"].'');
            die();
           
        }
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('location: ?err=3&action='.$_GET["action"].'');
            die();
        }

        if ($password !== $confirm_password){
            header('location: ?err=2&action='.$_GET["action"].'');
            die();
        }
        if (!isValidPass($password)){
            header('location: ?err=5&action='.$_GET["action"].'');
            die();
        }
        if (isEmailFound($email)){
            header('location: ?err=10&action='.$_GET["action"].'');
            die();
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        $profileImg = false;
        //test
        // $_SESSION['GlobalFiles'] = $_FILES;
        if (isset($_FILES['profile_img']) && !empty($_FILES['profile_img'])){
            uploadImg($_FILES['profile_img'],$profileImg);
        }
        
        
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;
        $_SESSION["room_number"] = $room_number;
        $_SESSION["ext"] = $ext;
        $_SESSION["profile_img"] = $profileImg;
        $rowData ="";
        myConcat($rowData,$email);
        myConcat($rowData,$password);
        myConcat($rowData,$name);
        myConcat($rowData,$room_number);
        myConcat($rowData,$ext);
        myConcat($rowData,$profileImg);
        

        saveToFile($rowData);
        header("location: ?err=12");
        
    
    
     
           
    
    
    
    
    
    }else{
            header('location: ?err=1&action='.$_GET["action"].'');
        }
    }
?>

