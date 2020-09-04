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
    $team = $_POST['dropdown'];
    $year = $_POST['birthday'];
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
    // validate input
    $valid = true;
    // insert data
    if ($valid) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sqlINSERT = "INSERT INTO sbe_students (login,email,phone,firstname,lastname, password, team) values(?, ?, ?, ?, ?, ?, ?)";
        $sqlUserExist = "SELECT email FROM sbe_students WHERE login= '$login'";
        $arrayOfInputs = array($login, $email, $phone, $firstname, $lastname, $password, $team);
        $userType = "students";
        //zawierasz którą kolumnę tabel sprawdzasz czy użytkownik istnieje 
        addUser($sqlINSERT, $sqlUserExist, $arrayOfInputs);
        $sql = "SELECT id FROM sbe_students WHERE login=?";
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $pdo->prepare($sql);
        $query->execute(array($login));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $student_id = $row['id'];
        $sqlINSERT = "INSERT INTO sbe_informations (address,photo_permission,self_reliance,invoice,end_of_contract, student_id) values(?, ?, ?, ?, ?, ?)";
        $arrayOfInputs = array($address, $photoPermission, $selfReliance, $invoice, $endOfContract, $student_id);
        $userType = "students";
        $q = $pdo->prepare($sqlINSERT);
        $q->execute($arrayOfInputs);
        //tutaj zaczyna się dodawanie obecności ;
        include('addAttendance.php');
        Database::disconnect();
        header("Location: ../../main.php?p=$userType");
    }
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
                    <label for="firstname">Imię </label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $data['firstname']; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="lastname"> Nazwisko</label>
                    <input type="text" id="firstname" name="lastname" class="form-control" value="<?php echo $data['lastname']; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Numer Telefonu</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $data['phone']; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Rok urodzenia</label>
                    <input type="number" name="birthday" class="form-control" value="<?php echo $data['birthday']; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="team">Grupa</label>
                    <?php
                    include("../methods/dropdown.php");
                    ?>
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
        </form>
        <!-- end of rows -->
        <div class="form-actions">
            <a class="btn btn-primary" href="../../main.php?p=potcustomers"><span data-feather="arrow-left"></span> Wstecz</a>
        </div>
    </div>
</div>