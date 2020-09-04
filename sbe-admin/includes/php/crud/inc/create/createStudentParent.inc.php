<?php

require '../connectDB_CRUD.php';
require '../inc/functions.php';
if (!empty($_POST)) {
    // keep track post values twórz zmienne
    $login = $_POST['login'];
    $phone = $_POST['phone'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $team = $_POST['dropParent'];
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
    $valid = true;
    $parentId=$_POST['dropdown'];
    echo $parentId;
    // insert data
    if ($valid) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM sbe_parents WHERE id =?";
        $query = $pdo->prepare($sql);
        $query->execute(array($parentId));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $email = $row['email'];
        $sqlINSERT = "INSERT INTO sbe_students (login,email,phone,firstname,lastname, password, team, id_parent_key, ischild) values(?, ?, ?, ?, ?, ?, ?, ?,?)";
        
        $arrayOfInputs = array($login, $email, $phone, $firstname, $lastname, $password, $team, $parentId, "1");
        addFutureUser($sqlINSERT, $arrayOfInputs);
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
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Email</label>
                    <?php
                    include("../methods/dropdown.php");
                    ?>
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
                    <label for="phoneInput">Telefon</label>
                    <input type="text" id="phoneInput" name="phone" class="form-control" value="<?php echo !empty($phone) ? $phone : ''; ?>" required>
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