<?php
require '../connectDB_CRUD.php';
require '../inc/functions.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}
if (null == $id) {
    header("Location: ../../main.php?p=teachers");
}
if (!empty($_POST)) {
    // keep track post values
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    // validate input
    $valid = true;
    if ($valid) {
        $sqlUserExist = "SELECT login FROM sbe_teachers WHERE email= ?";
        $sqlINSERT = "UPDATE sbe_teachers set firstname=?, email = ?, lastname=?, phone=? WHERE id = ?";
        $arrayOfInputs = array( $firstname, $email, $lastname, $phone, $id);
        $userType = "teachers";
        addUser($sqlINSERT, $sqlUserExist, $arrayOfInputs);
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM sbe_teachers where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $email = $data['email'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $phone = $data['phone'];
    $password = $data['password'];
    $login = $data['login'];
    Database::disconnect();
}
?>
<div class="container">
    <div class="span10 offset1">

        <div class="row">
            <h3>Dane <?php echo $data['firstname'] . " " . $data['lastname']; ?></h3>
        </div>
        <form action="" method="post">
            <!-- start of rows -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Login</label>
                    <input type="text" class="form-control" value="<?php echo !empty($login) ? $login : ''; ?>" required readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="firstnameInput">Imię</label>
                    <input type="text" id="firstnameInput" name="firstname" class="form-control" value="<?php echo !empty($firstname) ? $firstname : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="lastnameInput">Nazwisko</label>
                    <input type="text" id="lastnameInput" name="lastname" class="form-control" value="<?php echo !empty($lastname) ? $lastname : ''; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="phoneInput">Numer telefonu</label>
                    <input type="text" id="phoneInput" name="phone" class="form-control" value="<?php echo !empty($phone) ? $phone : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="emailInput">Email</label>
                    <input type="email" id="emailInput" name="email" class="form-control" value="<?php echo !empty($email) ? $email : ''; ?>" required>
                </div>
            </div>
            <!-- end of rows -->
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Aktualizuj</button>
                <a class="btn btn-primary" href="../../main.php?p=teachers"><span data-feather="arrow-left"></span> Wstecz</a>
            </div>
        </form>
    </div>
</div> <!-- /container -->