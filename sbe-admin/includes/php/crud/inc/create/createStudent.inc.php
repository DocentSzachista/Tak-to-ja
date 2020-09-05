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
    $birthyear = $_POST['birthyear'];

    $team = $_POST['dropdown'];
    $selfReliance = 0;
    $photoPermission = 0;
    $invoice=0;
    $address = $_POST['address'];
    if (isset($_POST['photo-permission']))
        $photoPermission = 1;
    if (isset($_POST['self-reliance']))
        $selfReliance = 1;
    if (isset($_POST['invoice']))
        $invoice =  1;
    $endOfContract = $_POST['end-of-contract'];
    $valid = true;

    if ($valid) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sqlINSERT = "INSERT INTO sbe_students (login,email,phone,firstname,lastname,birthday, password, team) values(?,?, ?, ?, ?, ?, ?, ?)";
        $sqlUserExist = "SELECT email FROM sbe_students WHERE email= ?";
        $arrayOfInputs = array($login, $email, $phone, $firstname, $lastname, $birthyear, $password, $team);
        $userType = "students";
        // funkcja dodająca użytkownika do bazy. Podajesz comendę zawierającej co gdzie wrzucasz, comendę gdzie 
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
        // funkcja dodająca użytkownika do bazy. Podajesz comendę zawierającej co gdzie wrzucasz, comendę gdzie 
        //zawierasz którą kolumnę tabel sprawdzasz czy użytkownik istnieje 
        $q = $pdo->prepare($sqlINSERT);
        $q->execute($arrayOfInputs);
        //tutaj zaczyna się dodawanie obecności ;
        include('addAttendance.php');
        Database::disconnect();
        header("Location: ../../main.php?p=$userType");
    }
}
?>


<div class="container">
    <div class="span10 offset1">

        <div class="row">
            <h3>Stworz Ucznia</h3>
        </div>
        <form action="" method="post">
            <!-- start of rows -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="userlogin">Login</label>
                    <input type="text" id="userlogin" name="login" class="form-control" value="<?php echo !empty($login) ? $login : ''; ?>" required readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword">Hasło</label>
                    <input type="text" id="inputPassword" name="password" class="form-control" value="<?php echo !empty($password) ? $password : ''; ?>" required readonly>
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
                    <?php
                    include("../methods/dropdown.php");
                    ?>
                </div>
                <div class="form-group col-md-3">
                    <label>Rok urodzenia</label>
                    <input type="number" name="birthyear" class="form-control" value="<?php echo !empty($birthyear) ? $birthyear : ''; ?>">
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
                <button type="submit" id="createProfile" class="btn btn-success"><span data-feather="plus-circle"></span> Stwórz</button>
                <a class="btn btn-primary" href="./create.php?p=createUser"><span data-feather="arrow-left"></span> Wstecz</a>
            </div>
        </form>
        <script src="../../../js/userlogin.js"></script>
        <script src="../../../js/scripts.js"></script>
    </div> <!-- /container -->