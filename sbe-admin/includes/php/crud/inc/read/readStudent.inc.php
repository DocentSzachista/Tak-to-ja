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
    $sql = "SELECT * FROM sbe_students where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);

    if ($data['ischild'] == '1') {
        $sql = "SELECT * FROM sbe_parents WHERE id=?";
        $query = $pdo->prepare($sql);
        $query->execute(array($data['id_parent_key']));
        $parentData = $query->fetch(PDO::FETCH_ASSOC);
    }
    $sql = "SELECT * FROM sbe_informations where student_id = ?";
    $querys = $pdo->prepare($sql);
    $querys->execute(array($id));
    $datas = $querys->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>
<!-- start of container -->
<div class="container">
    <div class="span10 offset1">
        <div class="row">
            <h3>Dane <?php echo $data['firstname'] . " " . $data['lastname']; ?></h3>

        </div>
        <br />
        <form>
            <!--parent -->
            <?php
            if ($data['ischild'] == '1') { ?>
                <h3>Rodzic</h3>
                <hr style="width: 100%; height: 1px; background-color:lightgray;" />
                <!-- start of rows -->
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Hasło</label>
                        <input type="text" id="parentInputPassword" name="parentPassword" class="form-control" value='<?php echo !empty($parentPassword) ? $parentPassword : ''; ?>' required readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Imię</label>
                        <input type="text" id="parentFirstname" name="parentFirstname" class="form-control" value='<?php echo !empty($parentData['firstname']) ? $parentData['firstname'] : ''; ?>' readonly required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Nazwisko</label>
                        <input type='text' id="parentLastname" name="parentLastname" class="form-control" value='<?php echo !empty($parentData['lastname']) ? $parentData['lastname'] : ''; ?>' readonly required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Email</label>
                        <input type="email" id="email" name="email" class="form-control" value='<?php echo !empty($parentData['email']) ? $parentData['email'] : ''; ?>' readonly required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Numer Telefonu</label>
                        <input type="text" name="phone" class="form-control" value='<?php echo !empty($parentData['phone']) ? $parentData['phone'] : ''; ?>' readonly required>
                    </div>
                </div>
                <!-- end of rows -->
                </br>
            <?php
            } ?>
            <h3>Uczeń</h3>
            <hr style="width: 100%; height: 1px; background-color:lightgray;" />

            <!-- student -->
            <!-- start of rows -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Login</label>
                    <input type="text" id="userlogin" name="login" class="form-control" value="<?php echo !empty($data['login']) ? $data['login'] : ''; ?>" required readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Hasło</label>
                    <input type="text" id="inputPassword" name="password" class="form-control" value="<?php echo !empty($data['password']) ? $data['password'] : ''; ?>" required readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Imię</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo !empty($data['firstname']) ? $data['firstname'] : ''; ?>" required readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Nazwisko</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo !empty($data['lastname']) ? $data['lastname'] : ''; ?>" required readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="team">Grupa</label>
                    <input type="text" id="team" name="team" class="form-control" value="<?php echo !empty($data['team']) ? $data['team'] : ''; ?>" required readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Adres</label>
                    <input type="text" name="address" class="form-control" value="<?php echo !empty($datas['address']) ? $datas['address'] : ''; ?>" required readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Koniec Umowy</label>
                    <input type="date" name="end-of-contract" class="form-control" value="<?php echo !empty($datas['end_of_contract']) ? $datas['end_of_contract'] : ''; ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="invoice" class="form-check-input" value="<?php echo !empty($datas['photo_permission']) ? $datas['photo_permission'] : ''; ?>" disabled>
                        <label class="form-check-label">Zgoda na zdjęcia</label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="self-reliance" class="form-check-input" value="<?php echo !empty($datas['self_reliance']) ? $datas['self_reliance'] : ''; ?>" disabled>
                        <label class="form-check-label">Zgoda na powrot</label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="invoice" class="form-check-input" value="<?php echo !empty($datas['invoice']) ? $datas['invoice'] : ''; ?>" disabled>
                        <label class="form-check-label">Faktura</label>

                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-actions" style="margin-bottom:1.5rem;">
                    <a class="btn btn-primary" href="../../main.php?p=students"><span data-feather="arrow-left"></span> Wstecz</a>
                </div>
            </div>
        </form>
        <!-- end of rows -->
    </div>
    <script src="../../../js/checkboxes.js"></script>

</div>
<!-- end of container -->