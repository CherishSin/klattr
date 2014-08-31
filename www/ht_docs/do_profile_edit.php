<?php
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
  $profileUname = $uname; 
  $sql = "SELECT Handle, Name, Profile_Text, Website_Addr, Avatar, ID FROM Users WHERE Handle='$profileUname' AND BINARY(Handle) = BINARY('$profileUname')";
  $sql_result = mysqli_query($con,$sql);
  $row = mysqli_fetch_array($sql_result);
  $profileUname = $row['Handle'];
  $profileRname = $row['Name'];
  $profileProfile = $row['Profile_Text'];
  $profileURL = $row['Website_Addr'];
  $profileID = $row[ID];
  if ($row['Avatar'] === "" || $row['Avatar'] === NULL) {
    $profileUserPic = "/gfx/default_user.png";
  } else {
    $profileUserPic = $profileUname . ".jpeg";
  }

  $page = "edit_profile";
?>
<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body onload="validatePasswordReset(Exists)">
    <script>
      Exists = 0;
    </script>
    <?php include "/data/klattr.com/www/includes/header"; ?>
<div id="body">
  <div class="body_center" style="top:10px;">
    <div class="user_banner">
      <img id="user_pic_main" src="<?php echo $profileUserPic;  ?>" onmouseover="editstyle('user_pic_main')" onmouseout="normalstyle('user_pic_main')" onclick="showeditor('edit_profile_picture')">
  
      <h4><?php echo $profileUname; ?></h4>
      <div id="user_text" style="" onmouseover="editstyle('user_text')" onmouseout="normalstyle('user_text')" onclick="showeditor('edit_profile_text')">
<?php
  if ($profileProfile == "") { 
    echo "<div class=\"mute_text\">Click to add Profile Text.</div>";
  } else {
    echo $profileProfile;
  }
  echo "<div class=\"profile_link\"><a href=\"" . $profileURL . "\" class=\"profile\">" . $profileURL . "</a></div>";
?>
  
      </div>
    </div>
    <div class="do_signup" style="top:-30px">
      <h1>Change Password.</h1>
      <form name="SignUp" method="POST" action="/reset_password.php">
      <div>
      <div class="form_line"><div class="form_text">Password:</div>
      <div class="form_val" id="val_pass"></div>
      <input type="password" class="gen_input" name="password" onkeyup="validatePasswordReset(Exists)" onblur="validatePasswordReset(Exists)"></div>
      <div class="form_line"><div class="form_text">Retype password:</div>
      <div class="form_val" id="val_pass2"></div>
      <input type="password" class="gen_input" name="password2" onkeyup="validatePasswordReset(Exists)" onblur="validatePasswordReset(Exists)"></div>
      </div>
      <div class="form_line">
        <div id="sub_div" style="display:none"><input type="submit" class="submit_signup" style="width:200px;float:right;" value="Reset Password!"></div>
        <input type="button" class="submit_signup" style="width:200px;float:right;" value="Reset Password!" onclick="reset_password()">
      </div>
      </form>
    </div>
    <div class="do_signup" style="top:-60px">
      <h1>Close Account.</h1>
      <form name="DeleteAccount" method="POST" action="/delete_account.php">
        <div class="form_line">
          <div class="form_text">
            If for some reason you'd like to close your account with us, click here.
          </div>
          <input type="submit"  class="cancel_signup" style="width:200px;float:right;" value="Close Account!"> 
          
        </div>
      </form>
    </div>
  </div>
</div>


<div id="dim"></div>
<div class="dialog_wrapper" id="edit_profile_text">
  <div class="dialog">
    <h5>Edit Profile Text & Web Address.</h5>
    <img src="/gfx/hr.png" width="450" height="1"/>
    <Form name="EditProfile" action="/do_profile_text_edit.php" method="post">
      Profile Text:<br>
      <textarea rows="4" cols="60" name="profileText" placeholder="Describe yourself here."><?php echo $profileProfile; ?></textarea><br>
      Web Address:<br>
      <input type="text" class="gen_input_left" name="webAddress" value="<?php echo $profileURL;?>">
      <input type="hidden" name="senduname" value="<?php echo $profileUname; ?>">
      <input type="submit" class="submit_login" style="width:100px;" value="Save It">
      <input type="button" onclick="hideeditor('edit_profile_text')" class="cancel_login" style="width:100px;" value="Cancel">
    </Form>
  </div>
</div>

<div class="dialog_wrapper" id="edit_profile_picture">
  <div class="dialog">
    <h5>Edit Profile Picture</h5>
    <img src="/gfx/hr.png" width="450" height="1"/>
    <form name="EditProfilePicture" enctype="multipart/form-data" action="/do_profile_picture_edit.php" method="post">
      Choose image file:<br>
      <div class="image_edit">
        <img id="image_upload" src="<?php echo $userPic;?>" class="preview_image" /> 
      </div>
      <div class="file_wrapper">
        <button class="btn-file-input">Choose File</button>
        <input type="hidden" name="senduname" value="<?php echo $profileUname; ?>">
        <input id="imgInp" type="file" name="file" accept="image/gif, image/jpeg, image/png" />
      </div>
      <input type="submit" class="submit_login" style="width:100px;" value="Save It">
      <input type="button" onclick="hideeditor('edit_profile_picture')" class="cancel_login" style="width:100px;" value="Cancel">
    </form>
  </div>
</div>
    <?php include "/data/klattr.com/www/includes/footer"; ?>
  </body>
</html>
<?php
} else {
  header( 'Location: https://klattr.com' );
}
?>
