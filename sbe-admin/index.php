<?php
require_once 'header.php';
if (isset($_SESSION['userId']) && isset($_SESSION['userName'])) {
  header("Location: ./includes/php/main.php");
}
?>

  <form action="includes/php/login.php" method="post" class="form-signin">
    <img class="mb-4" src="includes/assets/logo_1.svg" alt="" width="144" height="144">
    <h1 class="h3 mb-3 font-weight-normal">Zaloguj sie</h1>
    <label for="inputLogin" class="sr-only">Login</label>
    <input type="text" name="login" id="inputLogin" class="form-control" placeholder="Login" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <input type="text" value="admin" style="display: none;"/>
    <button class="btn btn-lg btn-primary btn-block" name="login-submit" type="submit">Zaloguj</button>
  </form>
<?php
require_once 'footer.php';
?>