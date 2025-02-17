<?php
    function getRooms(&$options,$room_id = 0){
        if ($room_id == 0){
        $rooms = pdo_select("room");
        if ($rooms) {
            foreach ($rooms as $room) {
                // echo "<option value='". $room["id"] ."'>". $room['name']. "</option>";
                $options.="<option value='". $room["id"] ."'>". $room['name']. "</option>";
            }
        }
        }else{
            $room = pdo_select("room",array("id"=> $room_id),false);
            $options ="<option value='". $room["id"] ."'>". $room['name']. "</option>";
        }
    }
    function getRoomsArr($room_id = 0){
        $options= [];
        if ($room_id == 0){
        $rooms = pdo_select("room");
        if ($rooms) {
            foreach ($rooms as $room) {
                // echo "<option value='". $room["id"] ."'>". $room['name']. "</option>";
                $options [] = array("id" => $room["id"],"name" => $room["name"]);
            }
        }
        }else{
            $room = pdo_select("room",array("id"=> $room_id),false);
            $options = array("id" => $room["id"],"name" => $room["name"]);
        }
        return $options;
    }
    function registerUser($email , $password , $name , $room_id,$ext , $profile_img = null){
        //pdo_insert
        //mysql> insert into user VALUES( 1,"as@as.as","$/yN78RYN1ze","Ahmed Salah",1,123,null);
        if (in_array($room_id,array_keys(getRoomsArr()))){
        $assoc = array(
            "email" => $email,
            "password"=> password_hash($password, PASSWORD_DEFAULT),
            "name"=> $name,
            "room_id"=> $room_id,
            "ext" => $ext ,
            "profile_img"=> $profile_img
        );
        return pdo_insert("user",columns_values: $assoc);
    }else{
        return -1;
    }
    }
    function isEmailFoundinDB($email){
        try{
        $user = pdo_select("user",array("email"=> $email),false);
        if($user){

            return $user['id'];
        }else{
            return false;
        }
        }catch (Exception $e){
            return false;
        }
    }
?>