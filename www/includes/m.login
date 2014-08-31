<div id="body">
  <div class="welcome">
    <h1>Welcome to Klattr.</h1>

    <h2>Login!</h2>
    <br /><br />
    <img src="/gfx/hr.png" width="350"/>
    <form name="Login" action="/do_login.php" method="post">
      <div class="form_line"><div class="form_text">Username:</div> <input type="text" class="gen_input" name="username"></div>
      <div class="form_line"><div class="form_text">Password:</div> <input type="password" class="gen_input" name="password"></div>
      <div class="form_line"><div class="form_text" style="font-size:10px; top:0px;"><a href="forgot_password.php" style="margin-right:10px;">Forgot your password?</a> Keep me signed in.</div><input type="checkbox" name="stay_signed_in" value="yes" class="checkbox_login" checked></div>
      <div class="form_line"><input type="submit" class="submit_login" value="Sign In!"></div>
    </form>
    <h2>Don't have a Klattr Account?</h2> <h3>Sign Up!</h3>
    <br /><br />
    <img src="/gfx/hr.png" width="350" />
    <form name="SignUp" action="/do_signup.php" method="post">
      <div class="form_line"><div class="form_text">Full Name:</div> <input type="text" class="gen_input" name="name"></div>
      <div class="form_line"><div class="form_text">Email Address:</div> <input type="text" class="gen_input" name="email"></div>
      <div class="form_line"><div class="form_text">Password:</div> <input type="password" class="gen_input" name="password"></div>
      <input type="hidden" class="gen_input" name="username">
      <div class="form_line"><input type="submit" class="submit_signup" value="Sign Up!"></div>
    </form>
  <div>
</div>
