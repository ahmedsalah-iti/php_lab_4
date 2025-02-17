<?php

?>
<div style="margin:auto;" >


<fieldset style="border: 5px solid red; padding: 2%; width: 70%; margin: auto;">
    <legend style="border: 3px solid black; font-size: 30px;">Dashboard</legend>
    <?php
    showMsg(errNum: $showErrors);
?>

<div style="display: flex; /* Enable Flexbox */ align-items: center; /* Vertically align items */"> 
        <div style="flex: 1;">  <h3>hello , <?php echo $_SESSION['name']; ?></h3>
            <h4>Your Email : <?php echo $_SESSION['email']; ?></h4>
            <h4>Your RoomNumber : <?php echo $_SESSION['room_number']; ?></h4>
            <h4>Your Ext : <?php echo $_SESSION['ext']; ?></h4>
        </div>
        <div style="margin-left: 20px;">
            <img style="border: 1px solid blue; width: 150px; height: 150px;" src="<?php echo $_SESSION['profile_img']; ?>">
        </div>
    </div>
    
</fieldset>

</div>
