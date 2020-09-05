<?php
require '../connectDB_CRUD.php';
require '../inc/functions.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: ../../main.php?p=potcustomers");
}
if (isset($_POST['update'])) {
    if (!empty($_POST)) {
        // keep track post values
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $school = $_POST['school'];
        $birthday = $_POST['birthday'];
        $activity = $_POST['activity'];
        $placeOfContact = $_POST['place_of_contact'];
        $typeOfContact = $_POST['type_of_contact'];
        $additional = $_POST['additional_info'];
        $city = $_POST['city'];
        // validate input
        $valid = true;
        if ($valid) {
            $sqlINSERT = "UPDATE sbe_potential_customers set firstname=?, lastname=?, email=?, phone=?, city=?, school=?, birthday=?, activity=?, place_of_contact=?, type_of_contact=?, additional_info=? WHERE id = ?";
            $arrayOfInputs = array($firstname, $lastname, $email, $phone, $city, $school, $birthday, $activity, $placeOfContact, $typeOfContact, $additional, $id);
            $userType = "potcustomers";
            addFutureUser($sqlINSERT, $arrayOfInputs, $userType);
        }
    }
} elseif (isset($_POST['createProfile'])) {
    // wrzucenie ucznia (i) rodzica do bazy i stworzenie sbe_informations pod ucznia -> wszystkie potrzebne dane do parenta/studenta sa w ifach
    $userSelect = $_POST['selectUser'];
    $userId = $id;
    // uczen z istniejacym rodzicem
    if ($userSelect == "student") {
        $parentId = $_POST['dropdown'];
        $login = $_POST['userlogin'];
        $password = $_POST['inputPassword'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $birthday = $_POST['birthday'];
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO sbe_students (id_parent_key, login, password, email, phone, firstname, lastname, birthday, ischild) VALUES(?, ?, ?, ?, ?, ?,  ?, ?, ?)";
        $arrayOfInputs = array($parentId, $login, $password, $email, $phone, $firstname, $lastname, $birthday, 1);
        addFutureUser($sql, $arrayOfInputs);
        // uczen dorosly
    } elseif ($userSelect == "adult") {
        $login = $_POST['userlogin'];
        $password = $_POST['inputPassword'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $birthday = $_POST['birthday'];
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO sbe_students (login, password, email, phone, firstname, lastname, birthday, ischild) VALUES (?, ?, ?, ?, ?, ?, ?, ? )";
        $arrayOfInputs = array($login, $password, $email, $phone, $firstname, $lastname, $birthday, 0);
        addFutureUser($sql, $arrayOfInputs);
        // uczen tworzony razem z rodzicem
    } elseif ($userSelect == "studentParent") {
        $login = $_POST['userlogin'];
        $password = $_POST['inputPassword'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $birthday = $_POST['birthday'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        if (empty($email)) {
            $email = $_POST['parentEmail'];
        }
        $parentPhone = $_POST['parentPhone'];
        $parentPassword = $_POST['parentInputPassword'];
        $parentFirstname = $_POST['parentFirstname'];
        $parentLastname = $_POST['parentLastname'];
        $parentPassword = password_hash($parentPassword, PASSWORD_DEFAULT);

        $sqlParent = "INSERT INTO sbe_parents (firstname, lastname, phone, email, password) values(?, ?, ?, ?, ?)";
        $arrayOfInputs = array($parentFirstname, $parentLastname, $phone, $email, $password);
        $pdo = Database::connect();
        addFutureUser($sqlParent,  $arrayOfInputs);
        $sql = "SELECT * FROM sbe_parents WHERE email =?";
        $query = $pdo->prepare($sql);
        $query->execute(array($email));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $parentId = $row['id'];
        $sql = "INSERT INTO sbe_students (id_parent_key, login, password, email, phone, firstname, lastname, birthday, ischild) VALUES(?, ?, ?, ?, ?, ?,  ?, ?, ?)";
        $arrayOfInputs = array($parentId, $login, $password, $email, $phone, $firstname, $lastname, $birthday, 1);
        addFutureUser($sql, $arrayOfInputs);
    }
    $pdo = Database::connect();
    $sqlLatestStudent = "SELECT * FROM sbe_students WHERE login=?";
    $array = array($login);
    $q = $pdo->prepare($sqlLatestStudent);
    $q->execute($array);
    $studentLatestId = $q->fetch(PDO::FETCH_ASSOC);
    $studentId = $studentLatestId['id'];

    $sqlInfo = "INSERT INTO sbe_informations (student_id) VALUES(?)";
    $arrayOfInputs = array($studentId);
    addFutureUser($sqlInfo, $arrayOfInputs);

    deleteUser("DELETE FROM sbe_potential_customers WHERE id=? ", $id);
    header("Location: ../../main.php?");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM sbe_potential_customers WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $email = $data['email'];
    $phone = $data['phone'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $school = $data['school'];
    $birthday = $data['birthday'];
    $activity = $data['activity'];
    $placeOfContact = $data['place_of_contact'];
    $typeOfContact = $data['type_of_contact'];
    $additional = $data['additional_info'];
    $city = $data['city'];
    Database::disconnect();
}
?>
<div class="container">
    <div class="span10 offset1">
        <div class="row">
            <h3>Dane <?php echo $firstname . " " . $lastname; ?></h3>
        </div>
        <form action="" method="post">
            <!-- start of rows -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="firstname">Imię</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo !empty($firstname) ? $firstname : ''; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="lastname">Nazwisko</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo !empty($lastname) ? $lastname : ''; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo !empty($email) ? $email : ''; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Numer Telefonu</label>
                    <input type="text" id="phoneInput" name="phone" class="form-control" value="<?php echo !empty($phone) ? $phone : ''; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Miejscowość</label>
                    <input type="text" name="city" class="form-control" value="<?php echo !empty($city) ? $city : ''; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Rok urodzenia</label>
                    <input type="text" name="birthday" class="form-control" value="<?php echo !empty($birthday) ? $birthday : ''; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Zajęcia jakimi jest zainteresowany</label>
                    <input type="text"" name=" activity" class="form-control" value="<?php echo !empty($activity) ? $activity : ''; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Miejsce zajęć</label>
                    <input type="text" name="school" class="form-control" value="<?php echo !empty($school) ? $school : ''; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Miejsce kontaktu</label>
                    <input type="text" name="place_of_contact" class="form-control" value="<?php echo !empty($placeOfContact) ? $placeOfContact : ''; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Rodzaj kontaktu</label>
                    <input type="text" name="type_of_contact" class="form-control" value="<?php echo !empty($typeOfContact) ? $typeOfContact : ''; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-7">
                    <label>Dodatkowe informacje</label>
                    <textarea type="text" name="additional_info" class="form-control" value="<?php echo !empty($additional) ? $additional : ''; ?>"><?php echo !empty($additional) ? $additional : ''; ?></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <input id="transfer-user" class="form-check-control" type="checkbox" />
                    <label class="form-check-label" for="transfer-user">Przenieś ucznia</label>
                </div>
            </div>
            <div id="transferUserPanel" style="display:none;">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="selectUser">Wybierz typ ucznia</label>
                        <select class="form-control" id="selectUser" name="selectUser">
                            <option value="adult">Dorosły</option>
                            <option value="studentParent">Z rodzicem</option>
                            <option value="student">Z istniejącym rodzicem</option>
                        </select>
                    </div>
                </div>
                <div class="form-row" style="display:none;">
                    <div class="form-group col-md-3">
                        <label>Login</label>
                        <input type="text" id="userlogin" name="userlogin" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Haslo</label>
                        <input type="text" id="inputPassword" name="inputPassword" class="form-control">
                    </div>
                </div>
                <div class="form-row" id="parentsEmail" style="display:none">
                    <div class="form-group col-md-3">
                        <?php
                        include("../methods/dropdown.php");
                        ?>
                    </div>
                </div>
                <div id="createParent" style="display:none">
                    <div class="form-row" style="display:none;">
                        <div class="form-group col-md-3">
                            <label>Haslo Rodzica</label>
                            <input type="text" id="parentInputPassword" name="parentInputPassword" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Imię</label>
                            <input type="text" id="parentFirstname" name="parentFirstname" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Nazwisko</label>
                            <input type="text" id="parentLastname" name="parentLastname" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Email</label>
                            <input type="email" id="email" name="parentEmail" class="form-control" value="<?php echo !empty($email) ? $email : ''; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Numer Telefonu</label>
                            <input type="text" id="phoneInput" name="parentPhone" class="form-control" value="<?php echo !empty($phone) ? $phone : ''; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of rows -->
            <div class="form-actions" style="margin-bottom:25px;">
                <button type="submit" name="update" class="btn btn-success">Aktualizuj</button>
                <a class="btn btn-primary" href="../../main.php?p=potcustomers"><span data-feather="arrow-left"></span> Wstecz</a>
                <button type="submit" id="createProfile" name="createProfile" class="btn btn-success" style="display:none;">Przenieś</button>
            </div>
        </form>
    </div>
</div> <!-- /container -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="../../../js/userlogin.js"></script>
<script src="../../../js/userChoice.js"></script>