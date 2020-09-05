<?php
require '../connectDB_CRUD.php';
require '../inc/functions.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}
if (null == $id) {
    header("Location: ../../main.php");
}
if (!empty($_POST)) {
    // keep track post values
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $team = $_POST['team'];
    //zmienne additionala
    $selfReliance = 0;
    $photoPermission = 0;
    $invoice = 0;
    $address = $_POST['address'];
    if (isset($_POST['photo-permission']))
        $photoPermission = 1;
    if (isset($_POST['self-reliance']))
        $selfReliance = 1;
    if (isset($_POST['invoice']))
        $invoice =  1;
    $endOfContract = $_POST['end-of-contract'];

    $sql = "SELECT * FROM sbe_students WHERE id=?";
    $pdo = Database::connect();
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $query = $q->fetch(PDO::FETCH_ASSOC);
    $teamToCheck = $query['team'];
    // validate input
    $valid = true;
    if ($valid) {
        $sqlINSERT = "UPDATE sbe_students SET email = ?, firstname=?, lastname=?, phone=?, team=? WHERE id = ?";
        $arrayOfInputs = array($email, $firstname, $lastname, $phone, $team, $id);
        addFutureUser($sqlINSERT,  $arrayOfInputs);
        $sqlINSERT = "UPDATE sbe_informations SET address = ?, photo_permission=?, self_reliance=?, invoice=?, end_of_contract=? WHERE student_id = ?";
        $arrayOfInputs = array($address, $photoPermission, $selfReliance, $invoice, $endOfContract, $id);
        addFutureUser($sqlINSERT, $arrayOfInputs);

        if ($team != $teamToCheck) {
            $student_id = $id;
            require_once('../inc/create/addAttendance.php');
        }

        if ($data['ischild'] == 1) {
            $parentFirstName = $_POST['parentFirstname'];
            $parentLastName = $_POST['parentLastname'];
            $parentPhone = $_POST['parent-phone'];
            $parentEmail = $_POST['parent-email'];
            $sqlINSERT = "UPDATE sbe_parents SET firstname=?, lastname=?, phone=?, email = ? WHERE id = ?";
            $arrayOfInputs = array($parentFirstName, $parentLastName, $parentPhone, $parentEmail, $id);
            addFutureUser($sqlINSERT,  $arrayOfInputs);
        }
        header("Location: ../../main.php?p=students");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM sbe_students where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $email = $data['email'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $phone = $data['phone'];
    $login = $data['login'];
    $team = $data['team'];
    $birthyear = $data['birthday'];
    Database::disconnect();
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM sbe_informations where student_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $datas = $q->fetch(PDO::FETCH_ASSOC);
    $address = $datas['address'];
    $photoPermission = $datas['photo_permission'];
    $selfReliance = $datas['self_reliance'];
    $invoice = $datas['invoice'];
    $endOfContract = $datas['end_of_contract'];
    $sql = "SELECT * FROM sbe_parents WHERE id=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($data['id_parent_key']));
    $parentData = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>

<div class="container">
    <div class="span10 offset1">
        <form action="" method="post">
            <?php
            if ($data['ischild'] == 1) {
            ?>
                <div class="row">
                    <h3>Modyfikacja rodzica </h3>
                </div>
                <hr style="width: 100%; height: 1px; background-color:lightgray;" />
                <!-- start of rows -->
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Imię</label>
                        <input type="text" id="parentFirstname" name="parentFirstname" class="form-control" value="<?php echo !empty($parentData['firstname']) ? $parentData['firstname'] : ''; ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Nazwisko</label>
                        <input type="text" id="parentLastname" name="parentLastname" class="form-control" value="<?php echo !empty($parentData['lastname']) ? $parentData['lastname'] : ''; ?>" required>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Email</label>
                        <input type="email" id="email" name="parent-email" class="form-control" value="<?php echo !empty($parentData['email']) ? $parentData['email'] : ''; ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Numer Telefonu</label>
                        <input type="text" id="phoneInput" name="parent-phone" class="form-control" value="<?php echo !empty($parentData['phone']) ? $parentData['phone'] : ''; ?>" required>
                    </div>
                </div>
                <br>
            <?php
            }
            ?>
            <div class="row">
                <h3>Zaktualizuj Ucznia</h3>
            </div>


            <!-- start of rows -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="userlogin">Login</label>
                    <input type="text" id="userlogin" name="login" class="form-control" value="<?php echo !empty($login) ? $login : ''; ?>" required readonly>
                </div>
            </div>
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
                    <label for="emailInput">Email</label>
                    <input type="email" id="emailInput" name="email" class="form-control" value="<?php echo !empty($email) ? $email : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="phoneInput">Numer Telefonu</label>
                    <input type="text" id="phoneInput" name="phone" class="form-control" value="<?php echo !empty($phone) ? $phone : ''; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="team">Grupa</label>
                    <input type="text" id="team" name="team" class="form-control" value="<?php echo !empty($team) ? $team : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="birthyear">Rok urodzenia</label>
                    <input type="number" id="birthyear" name="birthyear" class="form-control" value="<?php echo !empty($birthyear) ? $birthyear : ''; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Adres</label>
                    <input type="text" name="address" class="form-control" value="<?php echo !empty($address) ? $address : ''; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Koniec Umowy</label>

                    <input type="date" name="end-of-contract" class="form-control" value="<?php echo !empty($endOfContract) ? $endOfContract : ''; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="photo-permission" class="form-check-input" value="<?php echo !empty($photoPermission) ? $photoPermission : ''; ?>">
                        <label class="form-check-label">Zgoda na zdjęcia</label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="self-reliance" class="form-check-input" value="<?php echo !empty($selfReliance) ? $selfReliance : ''; ?>">
                        <label class="form-check-label">Zgoda na powrot</label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="invoice" class="form-check-input" value="<?php echo !empty($invoice) ? $invoice : ''; ?>">
                        <label class="form-check-label">Faktura</label>

                    </div>
                </div>
            </div>
            <!-- end of rows -->
            <div class="form-actions">
                <button type="submit" id="createProfile" class="btn btn-success"><span data-feather="plus-circle"></span> Zaktualizuj</button>
                <a class="btn btn-primary" href="../../main.php?p=students"><span data-feather="arrow-left"></span> Wstecz</a>
            </div>
            <script src="../../../js/checkboxes.js"></script>


        </form>

    </div> <!-- /container -->