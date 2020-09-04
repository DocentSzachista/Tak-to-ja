<?php

require '../connectDB_CRUD.php';
require '../inc/functions.php';
if (!empty($_POST)) {
    // keep track post values twórz zmienne
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $school = $_POST['school'];
    $birthday = $_POST['birthday'];
    $activity = $_POST['activity'];
    $placeOfContact = $_POST['place-of-contact'];
    $typeOfContact = $_POST['type-of-contact'];
    $additional = $_POST['additional-info'];
    $city = $_POST['city'];
    // validate input
    $valid = true;
    // insert data
    if ($valid) {
        $sqlINSERT = "INSERT INTO sbe_potential_customers (firstname, lastname, email, phone, city, school, birthday, activity, place_of_contact, type_of_contact, additional_info)
         values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // $sqlUserExist = "SELECT phone FROM sbe_potential_customers WHERE phone= '$phone";
        $arrayOfInputs = array($firstname, $lastname, $email, $phone, $city, $school, $birthday, $activity, $placeOfContact, $typeOfContact, $additional);
        $userType = "potcustomers";
        // funkcja dodająca użytkownika do bazy. Podajesz comendę zawierającej co gdzie wrzucasz, comendę gdzie 
        //zawierasz którą kolumnę tabel sprawdzasz czy użytkownik istnieje 
        addFutureUser($sqlINSERT, $arrayOfInputs);
        header("Location: ../../main.php?p=$userType");
    }
}
?>
<div class="container">
    <div class="span10 offset1">

        <div class="row">
            <h3>Potencjalny Klient</h3>
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
                    <label>Adres</label>
                    <input type="text" name="city" class="form-control" value="<?php echo !empty($city) ? $city : ''; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Rok urodzenia</label>
                    <input type="number" name="birthday" class="form-control" value="<?php echo !empty($birthday) ? $birthday : ''; ?>">
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
                    <input type="text" name="place-of-contact" class="form-control" value="<?php echo !empty($placeOfContact) ? $placeOfContact : ''; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Rodzaj kontaktu</label>
                    <input type="text" name="type-of-contact" class="form-control" value="<?php echo !empty($typeOfContact) ? $typeOfContact : ''; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-7">
                    <label>Dodatkowe informacje</label>
                    <textarea type="text" name="additional-info" class="form-control" value="<?php echo !empty($additional) ? $additional : ''; ?>"></textarea>
                </div>
            </div>
            <!-- end of rows -->
            <div class="form-actions">
                <button type="submit" id="createProfile" class="btn btn-success"><span data-feather="plus-circle"></span> Stwórz</button>
                <a class="btn btn-primary" href="../../main.php?p=potcustomers"><span data-feather="arrow-left"></span> Wstecz</a>
            </div>
        </form>
    </div>
</div> <!-- /container -->
<script src="../../../js/scripts.js"></script>
