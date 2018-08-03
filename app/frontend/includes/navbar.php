
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="index.php">App Name</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Services</a>
      </li>
    </ul>
    <?php if ($user->isLoggedIn()): ?>
      <p>>Hello,  <?php echo $user->data()->name;?></p>
    <ul class="nav navbar-nav nav-item navbar-right">
      <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
    <?php else: ?>
    <ul class="nav navbar-nav nav-item navbar-right">
      <li><a href="register.php"><span class="glyphicon glyphicon-user"></span>Register</a></li>
      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span>Log-in</a></li>
    </ul>
  <?php endif; ?>
  </div>
</nav>
