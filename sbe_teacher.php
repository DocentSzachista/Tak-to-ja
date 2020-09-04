<?php
require_once 'header.php';
$userType = "teachers";
if (isset($_SESSION['userId']) && isset($_SESSION['userName'])) {
  header("Location: ./main.php");
}
?>
<div class="wrapper text-center">
  <form action="includes/php/login.php" method="post" class="form-signin">
    <img class="mb-4" src="includes/assets/logo.svg" alt="" width="144" height="144">
    <h1 class="h3 mb-3 font-weight-normal">Zaloguj sie</h1>
    <label for="inputLogin" class="sr-only">Login</label>
    
    <input type="text" name="login" id="inputLogin" class="form-control" placeholder="Login" required >

    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password-teach" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" name="login-submit" value="teacher" type="submit">Zaloguj się</button>
  </form>
</div>
<?php
require_once 'footer.php';
?>