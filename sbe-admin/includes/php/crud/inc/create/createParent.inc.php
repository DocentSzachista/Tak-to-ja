<?php

require '../connectDB_CRUD.php';
require '../inc/functions.php';
if (!empty($_POST)) {
    $login = $_POST['login'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $birthyear = $_POST['birthyear'];
    $team = $_POST['dropdown'];
    $parentFirstname = $_POST['parentFirstname'];
    $parentLastname = $_POST['parentLastname'];
    $parentPassword = $_POST['parentPassword'];
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
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT email FROM sbe_parents WHERE email =?";
        $query = $pdo->prepare($sql);
        $query->execute([$email]);
        if ($query->rowCount() > 0) {
            $sql = "SELECT id FROM sbe_parents WHERE email = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$email]);
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $parentId = $row['id'];
            Database::disconnect();
        } else {
            $parentPassword = password_hash($parentPassword, PASSWORD_DEFAULT);

            $sql = "INSERT INTO sbe_parents (firstname, lastname, phone, email, password) values(?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute(array($parentFirstname, $parentLastname, $phone, $email, $parentPassword));
            $sql = "SELECT id FROM sbe_parents WHERE email = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$email]);
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $parentId = $row['id'];
        }
        $sqlINSERT = "INSERT INTO sbe_students (login,email,phone,firstname,lastname, password, birthday, team, id_parent_key, ischild) values(?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
        $sqlUserExist = "SELECT login FROM sbe_students WHERE email = ? ";
        $arrayOfInputs = array($login, $email, $phone, $firstname, $lastname, $password, $birthyear, $team, $parentId, "1");
        $userType = "students";
        addUser($sqlINSERT, $sqlUserExist, $arrayOfInputs);
        //fragment z create additionals
        $sql = "SELECT id FROM sbe_students WHERE login=?";
        $query = $pdo->prepare($sql);
        $query->execute(array($login));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $student_id = $row['id'];

        $sqlINSERT = "INSERT INTO sbe_informations (address,photo_permission,self_reliance,invoice,end_of_contract, student_id) values(?, ?, ?, ?, ?, ?)";
        $arrayOfInputs = array($address, $photoPermission, $selfReliance, $invoice, $endOfContract, $student_id);
        $userType = "students";
        // funkcja dodająca użytkownika do bazy. Podajesz comendę zawierającej co gdzie wrzucasz, comendę gdzie 
        //zawierasz którą kolumnę tabel sprawdzasz czy użytkownik istnieje 
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $q = $pdo->prepare($sqlINSERT);
        $q->execute($arrayOfInputs);
        include('addAttendance.php');
        Database::disconnect();
        header("Location: ../../main.php?p=$userType");
    }
}
?>

<div class="container">

    <div class="span10 offset1">
        <div class="row">
            <h3>Utwórz profile</h3>
        </div>
        </br>
        </br>
        <form class="form-horizontal" action="" method="post">
            <!--parent -->
            <h3>Rodzic</h3>
            <hr style="width: 100%; height: 1px; background-color:lightgray;" />
            <!-- start of rows -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Hasło</label>
                    <input type="text" id="parentInputPassword" name="parentPassword" class="form-control" value="<?php echo !empty($parentPassword) ? $parentPassword : ''; ?>" required readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Imię</label>
                    <input type="text" id="parentFirstname" name="parentFirstname" class="form-control" value="<?php echo !empty($parentFirstname) ? $parentFirstname : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Nazwisko</label>
                    <input type="text" id="parentLastname" name="parentLastname" class="form-control" value="<?php echo !empty($parentLastname) ? $parentLastname : ''; ?>" required>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo !empty($email) ? $email : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Numer Telefonu</label>
                    <input type="text" id="phoneInput" name="phone" class="form-control" value="<?php echo !empty($phone) ? $phone : ''; ?>" required>
                </div>
            </div>

            <!-- end of rows -->
            </br>
            <h3>Uczeń</h3>
            <hr style="width: 100%; height: 1px; background-color:lightgray;" />

            <!-- student -->
            <!-- start of rows -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Login</label>
                    <input type="text" id="userlogin" name="login" class="form-control" value="<?php echo !empty($login) ? $login : ''; ?>" required readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Hasło</label>
                    <input type="text" id="inputPassword" name="password" class="form-control" value="<?php echo !empty($password) ? $password : ''; ?>" required readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Imię</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo !empty($firstname) ? $firstname : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Nazwisko</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo !empty($lastname) ? $lastname : ''; ?>" required>
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
            <div class="form-row">
                <div class="form-actions" style="margin-bottom:1.5rem;">
                    <button type="submit" class="btn btn-success" id="createProfile"><span data-feather="plus-circle"></span> Stwórz</button>
                    <a class="btn btn-primary" href="./create.php?p=createUser"><span data-feather="arrow-left"></span> Wstecz</a>
                </div>
            </div>
            <!--end of input boxes -->
        </form>
    </div>
    <!-- random login script -->
    <script src="../../../js/userlogin.js"></script>
    <script src="../../../js/scripts.js"></script>
</div>
<!-- /container -->