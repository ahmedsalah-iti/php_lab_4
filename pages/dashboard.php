<pre>
    <!-- DATA: -->
    <?php

// print_r($_POST);
// print_r($_FILES);
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['update_profile_img']) && $_POST['update_profile_img'] == "upload"){
        if (isset($_FILES['profile_img']) && !empty($_FILES['profile_img'])){
            $profileImg = false;
            if (uploadImg($_FILES['profile_img'],$profileImg)){
                $_SESSION['profile_img'] = $profileImg;
                //update to db.
                if(updateProfileImgByEmail($_SESSION['email'],$profileImg)){
                    $_SESSION['profile_img'] = $profileImg;
                }else{
                    header('location: ?err=8&action='.$_GET["action"].'');
                }
            }else{
                //redirect , err failed to upload the img.
                header('location: ?err=8&action='.$_GET["action"].'');
            }
        }
    }
}


?>
</pre>

<div style="margin:auto;" >


<fieldset style="border: 5px solid red; padding: 2%; width: 70%; margin: auto;">
    <legend style="border: 3px solid black; font-size: 30px;">Dashboard</legend>
    <?php
    showMsg(errNum: $showErrors);
?>

<div style="display: flex; /* Enable Flexbox */ align-items: center; /* Vertically align items */"> 
        <div style="flex: 1;">  <h3>hello , <?php echo $_SESSION['name']; ?></h3>
            <h4>Your Email : <?php echo $_SESSION['email']; ?></h4>
            <h4>Your Track : <?php echo $_SESSION['room_name']; ?></h4>
            <h4>Your Ext : <?php echo $_SESSION['ext']; ?></h4>
        </div>
        <div style="margin-left: 20px;">
            <img style="border: 1px solid blue; width: 150px; height: 150px;" src="<?php echo $_SESSION['profile_img']; ?>">
      <form method="POST" enctype="multipart/form-data">
        <label">
            <input type="file" name="profile_img" >
            <input type="submit" value="upload" name="update_profile_img">
        </label>
      </form>
        </div>
    </div>
    
</fieldset>

</div>
