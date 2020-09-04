<?php

require '../connectDB_CRUD.php';
require '../inc/functions.php';
if (!empty($_POST)) {
    // keep track post values twórz zmienne
    $team_name = $_POST['team_name'];
    $start_date = $_POST['start'];
    $goal = $_POST['goal'];
    $end_date = $_POST['end'];
    $frequency = $_POST['frequency'];
    $team_time = $_POST['team_time'];
    $amount = $_POST['amount'];
    $end_time = $_POST['end_time'];
    $color = $_POST['color'];

    $email = $_POST['email'];
    $sql = "SELECT * FROM sbe_teachers where email = ?";
    //funkcja doszukująca się nauczyciela w bazie po mailu
    $leader_id = searchUser($email, $sql, 'id');
    if (empty($leader_id)) {
        header("Location: ../../main.php?p=error");
    }
    // validate input
    $valid = true;

    // insert data
    if ($valid) {
        $sqlINSERT = "INSERT INTO sbe_teams (leader_id, team_name, goal, start_date, end_date, team_time, rec_pattern, amount, end_time, color) values(?,?,?, ?, ?, ?, ?, ?, ?, ?)";
        $sqlUserExist = "SELECT team_name FROM sbe_teams WHERE team_name= ?";
        $arrayOfInputs = array($leader_id, $team_name, $goal, $start_date, $end_date,  $team_time, $frequency, $amount, $end_time, $color);
        $userType = "teams";
        //zawierasz którą kolumnę tabel sprawdzasz czy użytkownik istnieje 
        $lastId = addTeam($sqlINSERT, $sqlUserExist, $arrayOfInputs);
        for ($i = 0; $i <= $amount; $i++) {
            $sqlINSERT = "INSERT INTO  sbe_lesson (team_id, date, lesson_time, end_time) values(?,?, ?, ?)";
            $date = new DateTime($start_date);
            $date->add(new DateInterval("P" . $frequency * $i . "D"));
            $stringDate = $date->format('Y-m-d');
            $arrayOfInputs = array($lastId, $stringDate, $team_time, $end_time);
            addFutureUser($sqlINSERT, $arrayOfInputs);
        }
        header("Location: ../../main.php?p=$userType");

    }
}
?>
<div class="container">
    <div class="span10 offset1">

        <div class="row">
            <h3>Stworz Grupe</h3>
        </div>

        <form action="" method="post">
            <!-- start of rows -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="firstname">Nazwa grupy </label>
                    <input type="text" id="firstname" name="team_name" class="form-control" value="<?php echo !empty($team_name) ? $team_name : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="emailInput">Email nauczyciela</label>
                    <input type="email" id="emailInput" name="email" class="form-control" value="<?php echo !empty($email) ? $email : ''; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Początek </label>
                    <input type="date" name="start" class="form-control" value="<?php echo !empty($start_date) ? $start_date : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Koniec</label>
                    <input type="date" name="end" class="form-control" value="<?php echo !empty($end_date) ? $end_date : ''; ?>" required>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Co ile dni?</label>
                    <input type="text" name="frequency" class="form-control" value="<?php echo !empty($frequency) ? $frequency : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Cel</label>
                    <input type="text" name="goal" class="form-control" value="<?php echo !empty($goal) ? $goal : ''; ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Godzina początkowa zajęc</label>
                    <input type="time" name="team_time" class="form-control" value="<?php echo !empty($team_time) ? $team_time : ''; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Godzina końcowa zajęc</label>
                    <input type="time" name="end_time" class="form-control" value="<?php echo !empty($end_time) ? $end_time : ''; ?>" required>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Ilość zajęć</label>
                    <input type="text" name="amount" class="form-control" value="<?php echo !empty($amount) ? $amount : ''; ?>" required>

                </div>
                <div class="form-group col-md-3">
                    <label>Kolor</label>
                    <input type="color" name="color" class="form-control" value="<?php echo !empty($color) ? $color : ''; ?>" required>
                </div>
            </div>

            <!-- end of rows -->
            <div class="form-actions">
                <button type="submit" id="createProfile" class="btn btn-success"><span data-feather="plus-circle"></span> Stwórz</button>
                <a class="btn btn-primary" href="../../main.php?p=teams"><span data-feather="arrow-left"></span> Wstecz</a>
            </div>
        </form>
    </div>
    <script src="../../../js/username.js"></script>

</div> <!-- /container -->
<?php

?>