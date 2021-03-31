<?php
require '../connectDB_CRUD.php';
require '../inc/functions.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}
if (null == $id) {
    header("Location: ../../main.php?p=teams");
}
if (!empty($_POST)) {
    // keep track post values
    $email = $_POST['email'];
    $team_name = $_POST['team_name'];
    $start_date = $_POST['start'];
   
    $end_date = $_POST['end'];
    $frequency = $_POST['frequency'];
    $team_time = $_POST['team_time'];
    $end_time = $_POST['end_time'];
    $color = $_POST['color'];
    $amount = $_POST['amount'];

    $sql = "SELECT * FROM sbe_teachers where email = ?";
    $leader_id = searchUser($email, $sql, 'id');

    $valid = true;
    if ($valid) {
        $sqlUserExist = "SELECT team_name FROM sbe_teams WHERE team_name= ?";
        $sqlINSERT = "UPDATE sbe_teams set leader_id=?, team_name=?,   start_date=?, end_date=?,rec_pattern=? , team_time=?, end_time=?, color=?  WHERE id = ?";
        $arrayOfInputs = array($leader_id, $team_name,  $start_date, $end_date, $frequency, $team_time, $end_time, $color, $id);
        $userType = "teams";
        addFutureUser($sqlINSERT, $arrayOfInputs);
        header("Location: ../../main.php?p=$userType");
    }
} else {
    $pdo = Database::connect();

    //tu też jointa dodać
    $sql = 'SELECT sbe_teams.id as team_id, sbe_teams.start_date as start_date ,sbe_teams.amount as amount, sbe_teams.end_date as end_date, sbe_teams.team_time as team_time,  
    sbe_teams.end_time as end_time, sbe_teams.color as color ,sbe_teams.rec_pattern as frequency, 
    sbe_teams.team_name as team_name, sbe_teams.leader_id, sbe_teachers.firstname, sbe_teachers.lastname, sbe_teachers.email as email  
    FROM sbe_teams 
    INNER JOIN sbe_teachers ON sbe_teams.leader_id=sbe_teachers.id 
    WHERE sbe_teams.id=?';
    $q = $pdo->prepare($sql);
    $q->execute([$id]);
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $email = $data['email'];
  
    $team_time = $data['team_time'];
    $end_time = $data['end_time'];
    $color = $data['color'];
    $team_name = $data['team_name'];
}
?>
<div class="container">
    <div class="span10 offset1">


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
                    <label>Kolor</label>
                    <input type="color" name="color" class="form-control" value="<?php echo !empty($color) ? $color : ''; ?>" required>
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

            <!-- end of rows -->
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Aktualizuj</button>
                <a class="btn btn-primary" href="../../main.php?p=teams"><span data-feather="arrow-left"></span> Wstecz</a>
            </div>
        </form>
    </div>
</div> <!-- /container -->