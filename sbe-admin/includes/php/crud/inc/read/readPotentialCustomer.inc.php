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
    $sql = "SELECT * FROM sbe_potential_customers WHERE id = ?";
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
            <!-- start of rows -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstname">Imię i Nazwisko</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $data['firstname'] . " " . $data['lastname'] ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Numer Telefonu</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $data['phone']; ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Adres</label>
                    <input type="text" name="city" class="form-control" value="<?php echo $data['city']; ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Rok urodzenia</label>
                    <input type="number" name="birthday" class="form-control" value="<?php echo $data['birthday']; ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Zajęcia jakimi jest zainteresowany</label>
                    <input type="text"" name=" activity" class="form-control" value="<?php echo $data['activity']; ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Miejsce zajęć</label>
                    <input type="text" name="school" class="form-control" value="<?php echo $data['school']; ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Miejsce kontaktu</label>
                    <input type="text" name="place-of-contact" class="form-control" value="<?php echo $data['place_of_contact']; ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Rodzaj kontaktu</label>
                    <input type="text" name="type-of-contact" class="form-control" value="<?php echo $data['type_of_contact']; ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-7">
                    <label>Dodatkowe informacje</label>
                    <textarea type="text" name="additional-info" class="form-control" value="" readonly><?php echo $data['additional_info']; ?></textarea>
                </div>
            </div>
            <!-- end of rows -->
        </form>
        <!-- end of rows -->
        <div class="form-actions">
            <a class="btn btn-primary" href="../../main.php?p=potcustomers"><span data-feather="arrow-left"></span> Wstecz</a>
        </div>
    </div>
</div>