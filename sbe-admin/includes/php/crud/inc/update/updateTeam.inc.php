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
    /*/ keep track post values
    $start_date = $_POST['start'];
    $frequency = $_POST['frequency'];
    $end_date = $_POST['end'];
    $amount = $_POST['amount'];
    */
    $email = $_POST['email'];
    $team_name = $_POST['team_name'];
    $team_time = $_POST['team_time'];
    $end_time = $_POST['end_time'];
    $color = $_POST['color'];
    
    $email_2 =$_POST['email_2'];
    $email_replacement=$_POST['email_replace'];
    $sql = "SELECT * FROM sbe_teachers where email = ?";
    $leader_id = searchUser($email, $sql, 'id');
    $leader_id2= searchUser($email_2, $sql, 'id');
    $leader_id_replacement = searchUser($email_replacement, $sql, 'id');
    $valid = true;
    if ($valid) {
        $sqlUserExist = "SELECT team_name FROM sbe_teams WHERE team_name= ?";
       // Do poprawienia potem żeby była możliwość automatycznej zmiany zajęć
       // $sqlINSERT = "UPDATE sbe_teams set leader_id=?, team_name=?,   start_date=?, end_date=?,rec_pattern=? , team_time=?, end_time=?, color=?, leader2_id=?, leader3_id=? WHERE id = ?";
       // $arrayOfInputs = array($leader_id, $team_name,  $start_date, $end_date, $frequency, $team_time, $end_time, $color, $leader_id2, $leader_id_replacement,$id);



        $sqlINSERT = "UPDATE sbe_teams set leader_id=?, team_name=?, team_time=?, end_time=?, color=?, leader2_id=?, leader_3id =? WHERE id = ?";
        $arrayOfInputs = array($leader_id, $team_name,  $team_time, $end_time, $color, $leader_id2, $leader_id_replacement, $id);
        $userType = "teams";
        addFutureUser($sqlINSERT, $arrayOfInputs);
        header("Location: ../../main.php?p=$userType");
    }
} else {
    $pdo = Database::connect();

    /*
        $sql = 'SELECT sbe_teams.id as team_id, sbe_teams.start_date as start_date ,sbe_teams.amount as amount, sbe_teams.end_date as end_date, sbe_teams.team_time as team_time,  
        sbe_teams.end_time as end_time, sbe_teams.color as color ,sbe_teams.rec_pattern as frequency, 
        sbe_teams.team_name as team_name, sbe_teams.leader_id, sbe_teachers.firstname, sbe_teachers.lastname, sbe_teachers.email as email  
        FROM sbe_teams 
        INNER JOIN sbe_teachers ON sbe_teams.leader_id=sbe_teachers.id 
        WHERE sbe_teams.id=?';
    */
    //tu też jointa dodać
    $sql = 'SELECT sbe_teams.id as team_id, sbe_teams.team_time as team_time,  
    sbe_teams.end_time as end_time, sbe_teams.color as color , 
    sbe_teams.team_name as team_name, sbe_teams.leader_id, sbe_teams.leader2_id AS id3, sbe_teams.leader_3id AS replacement,  sbe_teachers.email as email  
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
    $leader_id2=$data['id3'];
    $leader_id_replacement=$data['replacement'];
    // TODO: Wykminić czemu nie wyrzuca dwóch maili tak jak powinno var_dump($data);
    $sql = 'SELECT email FROM sbe_teachers WHERE id=? OR id=?';
    $q = $pdo->prepare($sql);
    $q->execute([$leader_id_replacement, $leader_id2 ]);
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $email_2=$data['email'];
    $email_replacement=$data['email'];
    
    
     
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
                    <label for="emailInput">Email nauczyciela drugiego </label>
                    <input type="text" id="firstname" name="email_2" class="form-control" value="<?php echo !empty($email_2) ? $email_2 : ''; ?>" >
                </div>
                <div class="form-group col-md-3">
                    <label for="emailInput">Email nauczyciela zastępującego</label>
                    <input type="email" id="emailInput" name="email_replace" class="form-control" value="<?php echo !empty($email_replacement) ? $email_replacement : ''; ?>" >
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