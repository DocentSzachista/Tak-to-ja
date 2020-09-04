<?php

require '../connectDB_CRUD.php';
require '../inc/functions.php';
if (!empty($_POST)) {
    // keep track post values twórz zmienne
    $login = $_POST['login'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    // validate input
    $valid = true;
    // insert data
    if ($valid) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sqlINSERT = "INSERT INTO sbe_teachers (login,email,phone,firstname,lastname, password) values(?, ?, ?, ?, ?, ?)";
        $sqlUserExist = "SELECT email FROM sbe_teachers WHERE email= ?";
        $arrayOfInputs = array($login, $email, $phone, $firstname, $lastname, $password);
        $userType = "teachers";
        // funkcja dodająca użytkownika do bazy. Podajesz comendę zawierającej co gdzie wrzucasz, comendę gdzie 
        //zawierasz którą kolumnę tabel sprawdzasz czy użytkownik istnieje 
        addUser($sqlINSERT, $sqlUserExist, $arrayOfInputs);
        header("Location: ../../main.php?p=$userType");
    }
}
?>


<div class="container">
    <div class="span10 offset1">
        <div class="row">
            <h3>Stworz Nauczyciela</h3>
        </div>
        <form action="" method="post">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="userlogin">Login</label>
                    <input type="text" id="userlogin" name="login" class="form-control" value="<?php echo !empty($login) ? $login : ''; ?>" required readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword">Hasło</label>
                    <input type="text" id="inputPasswordTeacher" name="password" class="form-control" value="<?php echo !empty($password) ? $password : ''; ?>" required readonly>
                </div>
            </div>
            <!-- start of rows -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="firstname">Imię</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo !empty($firstname) ? $firstname : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="lastname">Nazwisko</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo !empty($lastname) ? $lastname : ''; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="phoneInput">Numer Telefonu</label>
                    <input type="text" id="phoneInput" name="phone" class="form-control" value="<?php echo !empty($phone) ? $phone : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="emailInput">Email</label>
                    <input type="email" id="emailInput" name="email" class="form-control" value="<?php echo !empty($email) ? $email : ''; ?>" required>
                </div>
            </div>
            <!-- end of rows -->
            <div class="form-actions">
                <button type="submit" id="createProfile" class="btn btn-success"><span data-feather="plus-circle"></span> Stwórz</button>
                <a class="btn btn-primary" href="../../main.php?p=teachers"><span data-feather="arrow-left"></span> Wstecz</a>
            </div>
        </form>
    </div>
    <script src="../../../js/userlogin.js"></script>
    <script src="../../../js/scripts.js"></script>


</div> <!-- /container -->