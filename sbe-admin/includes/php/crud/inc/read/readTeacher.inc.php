<?php
require '../connectDB_CRUD.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: ../../../main.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //sql statement tam gdzie id=? to sobie wybiera?
    $sql = "SELECT * FROM sbe_teachers where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>
<div class="container">
    <div class="span10 offset1">
        <div class="row">
            <h3>Dane <?php echo $data['firstname'] . " " . $data['lastname']; ?></h3>
        </div>
        <form>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Login</label>
                    <input type="text" class="form-control" value="<?php echo $data['login']; ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Hasło</label>
                    <input type="text" name="password" class="form-control" value="<?php echo $data['password']; ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="firstnameInput">Imię</label>
                    <input type="text" id="firstnameInput" name="firstname" class="form-control" value="<?php echo $data['firstname']; ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="lastnameInput">Nazwisko</label>
                    <input type="text" id="lastnameInput" name="lastname" class="form-control" value="<?php echo $data['lastname']; ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="phoneInput">Numer telefonu</label>
                    <input type="text" id="phoneInput" name="phone" class="form-control" value="<?php echo $data['phone']; ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="emailInput">Email</label>
                    <input type="email" id="emailInput" name="email" class="form-control" value="<?php echo $data['email']; ?>" readonly>
                </div>
            </div>
        </form>
        <!-- end of rows -->
        <div class="form-actions">
            <a class="btn btn-primary" href="../../main.php?p=teachers"><span data-feather="arrow-left"></span> Wstecz</a>
        </div>
    </div>
</div>