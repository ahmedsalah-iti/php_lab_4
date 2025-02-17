<?php
    function showMsg($errNum = 0){
        if ($errNum != "" && !empty($errNum) && is_numeric($errNum)){

        
        $errClass = "error_msg";
        $successClass = "success_msg";
        $class = "";
        $msg_text_type = getMessages($errNum);
        $type = $msg_text_type[0];
        $msg = $msg_text_type[1];
        if($type == true){
            $class = $successClass;
        }else{
            $class = $errClass;
        }
        echo "
        <span class='$class'>$msg</span>
        ";
    }
    }
    function getMessages($errNum = 0){
        $errMsg = "test";
        $type = false;
        switch($errNum){
            case 1:
            $errMsg = "Error: You shouldn't forget any fields Empty !";
            $type = false;
            break;
            case 2:
            $errMsg = "Error: Passwords Are NOT Matched.";
            $type = false;
            break;
            case 3:
            $errMsg = "Error: Bad Email , please write your email correctly.";
            $type = false;
            break;
            case 4:
            $errMsg = "Error: bad Name , Your name should contains only Text.";
            $type = false;
            break;
            case 5:
            $errMsg = "Error: Bad Password , Use at least 8 characters and a mix of letters (uppercase and lowercase), numbers, and symbols.";
            $type = false;
            break;
            case 6:
            $errMsg = "Error: Room Number Should be only Numbers !";
            $type = false;
            break;
            case 7:
            $errMsg = "Error: Ext Should be only Number !";
            $type = false;
            break;
            case 8:
            $errMsg = "Error: Failed To Upload The Img , Unknown Error.";
            $type = false;
            break;
            case 9:
            $errMsg = "Error: Your Image Size is too big , our max size is 10MB.";
            $type = false;
            break;
            case 10:
            $errMsg = "Error: This Email is already Existed , please use another Email.";
            $type = false;
            break;
            case 11:
            $errMsg = "Error: Your uploaded file isn't image or it's not supported img.";
            $type = false;
            break;
            case 12:
            $errMsg = "Success: Your Account is just created successfuly.";
            $type = true;
            break;
            case 13:
            $errMsg = "Success: You logged in successfuly.";
            $type = true;
            break;
            case 14:
            $errMsg = "Error: Email/Password is/are incorrect.";
            $type = false;
            break;
            default:
            $errMsg = "UNKNOWN_ERROR";
            $type = false;
        }
        return array($type , $errMsg);
    }



function isValidName($name) {
    $pattern = '/^[A-Za-z\s]+$/';
    return preg_match($pattern, $name);
}
function isValidPass($pass) {
    $minLen = 8;
    if (strlen($pass) < $minLen) {
        return false;
    }
    if (!preg_match('/^(?=.*[\W])(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,50}$/', $pass)) {
        return false;
    }else{
        return true;
    }
}
$uploads_dir = "./uploads";
function randomStr($len = 50){
    return bin2hex(random_bytes($len));
}
function isValidImgSize($size,$maxSize = 10) {
    if($size / 1024 /1024 > $maxSize) {
        return false;
    }else{
        return true;
    }
}
$supported_img_types = array("image/png","image/jpeg", "image/jpg") ;
function isValidImgType($type) {
    global $supported_img_types;
    $type = strtolower($type);
    return in_array($type, $supported_img_types);
}
function uploadImg($imgFile,&$newImgPath){
    global $uploads_dir;
    $newImgPath = false;
    
    if(!is_dir($uploads_dir)){
        if(!mkdir($uploads_dir,0755,true)){
            return false;
        }
    }
    if($imgFile["tmp_name"] && $imgFile['error'] == 0 && isValidImgType($imgFile["type"]) && isValidImgSize($imgFile['size'])){
        $imgPath = $uploads_dir."/".randomStr().str_replace("/",".",$imgFile["type"]);
        if(move_uploaded_file($imgFile["tmp_name"],$imgPath)){
            if ($_SESSION['profile_img'] != "./uploads/empty.jpg"){
                unlink($_SESSION['profile_img']);
            }
            $_SESSION['profile_img'] = $imgPath;
            $newImgPath = $imgPath;
            return true;
        }else{
            return false;
        }
    }
}









# SAVE , LOAD date in/from TXT
$txtFilePath = "users.txt";
function myConcat(&$row,$col,$delimiter = ":"){
    if ($row == ""){
        $row = $col;
    }else{
        $row = $row.$delimiter.$col;
    }
}
function saveToFile($lineData){
    global $txtFilePath;
    if (file_exists($txtFilePath)){
        $f = fopen($txtFilePath,'a');
        if ($f){
            fwrite($f,$lineData."\n");
            fclose($f);
            return TRUE;
        }else{
            return FALSE;
        }
    }else{
        $f = fopen($txtFilePath,'w');
        if ($f){
            fwrite($f,$lineData."\n");
            fclose($f);
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
}
function isEmailFound($email){
    global $txtFilePath;
    if (file_exists($txtFilePath)){
        $f = fopen($txtFilePath,"r");
        if ($f){
            while($line = fgets($f)){
                $line = trim($line);
                $emailCol = explode(":", $line)[0];
                if ($emailCol=== $email){
                    fclose($f);
                    return TRUE;
                }
            }
            fclose( $f );
            return FALSE;

        }else{
            fclose( $f );
            error_log("error_in_file");
            return TRUE;
        }
    }else{
        $f = fopen($txtFilePath,'w');
        fclose( $f );
        error_log("file_not_found");
        return TRUE;
    }
}
function getDataByEmail($email){
    global $txtFilePath;
    if (isEmailFound($email)){


    
    if (file_exists($txtFilePath)){
        $f = fopen($txtFilePath,"r");
        if ($f){
            while($line = fgets($f)){
                $line = trim($line);
                $lineSplited = explode(":", $line);
                if ($lineSplited[0]=== $email){
                    fclose($f);
                    return array(
                        "email"=>$lineSplited[0],
                        "password" => $lineSplited[1],
                        "name"  => $lineSplited[2],
                        "room_number"=> $lineSplited[3],
                        "ext"=> $lineSplited[4],
                        "profile_img"=> $lineSplited[5]
                    );
                }
            }
            fclose($f);
            return null;
        }else{
            fclose($f);
            return null;
        }
    }else{
        return null;
    }
    }
    else{
        return null;
    }
}
function isValidLogin($email, $password){
    $data = null;
    $data = getDataByEmail($email);
    if($data ){
        if(password_verify($password, $data["password"])){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }

}
?>