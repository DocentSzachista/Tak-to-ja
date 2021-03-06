<?php
require_once 'header.php';
if (isset($_SESSION['userType']) && $_SESSION['userType'] == "admin") {
    header("Location: ./main.php");
}
?>
<div class="container login-container">
    <form action="./includes/php/login.php" method="POST">
        <div class="row">
            <div class="col-md-6 login-form-1">
                <h3>Uczeń</h3>
                <div class="form-group">
                    <input name="login" id="studentUsername" type="text" class="form-control" placeholder="* Login..." value="" />
                </div>
                <div class="form-group">
                    <input name="password-stud" type="password" id="studentPassword" class="form-control" placeholder="* Haslo..." value="" />
                </div>
                <div class="form-group">
                    <button id="studentLogin" name="login-submit" class="btn btn-primary" value="student" type="submit">Zaloguj się</button>
                </div>

            </div>
            <div class="col-md-6 login-form-2">
                <div class="login-logo">
                    <img src="./includes/assets/logo.svg" alt="" />
                </div>
                <h3>Rodzic</h3>
                <div class="form-group">
                    <input name="email" type="email" id="parentEmail" class="form-control" placeholder="* Email..." value="" />
                </div>
                <div class="form-group">
                    <input name="password-par" type="password" id="parentPassword" class="form-control" placeholder="* Haslo..." value="" />
                </div>
                <div class="form-group">
                    <button id="parentLogin" name="login-submit" class="btn btn-light" value="parent" type="submit">Zaloguj się</button>
                </div>
            </div>
        </div>
    </form>

</div>
<!-- <script type="text/javascript" src="./includes/js/scripts.js"></script> -->
<?php
require_once 'footer.php';
?>