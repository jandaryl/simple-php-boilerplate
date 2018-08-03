
<div class="container" style="padding-top: 1%; padding-bottom: 5%;">
<h2>Login Form</h2>
  <form action="" method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
    </div>
    <div class="form-group form-check">
    <label for="remember">
      <input type="checkbox" name="remember" id="remember">Remember Me
    </label>
    </div>
     <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
     <input type="submit" value="Log In">
  </form>
</div>
