<?php
require '../connectDB_CRUD.php';
require '../inc/functions.php';
$id = 0;

if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM sbe_teams where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
}
if (!empty($_POST)) {
    $sql = "DELETE FROM sbe_teams WHERE id = ?";
    deleteUser($sql, $id);
    header("Location: ../../main.php?p=teams");
}
?>
<div class="container">

    <div class="span10 offset1">
        <div class="row">
            <h3>Na pewno chcesz usunac <?php echo $data['team_name']; ?>?</h3>
        </div>
        <form class="form-horizontal" action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Tak</button>
                <a class="btn btn-primary" href="../../main.php?p=teams">Nie</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->
