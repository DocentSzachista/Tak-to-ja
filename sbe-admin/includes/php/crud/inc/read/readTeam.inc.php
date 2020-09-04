<?php
require '../connectDB_CRUD.php';
$id = null;
if (!empty($_GET['id'])) {
  $id = $_REQUEST['id'];
}

if (null == $id) {
  header("Location: ../../../main.php");
} else {
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //sql statement tam gdzie id=? to sobie wybiera?
  $sql = "SELECT * FROM sbe_teams where id  = ?";
  $q = $pdo->prepare($sql);
  $q->execute(array($id));
  $data = $q->fetch(PDO::FETCH_ASSOC);
  $sql = "SELECT * FROM sbe_teachers WHERE id=?";
  $q = $pdo->prepare($sql);
  $q->execute(array($data['leader_id']));
  $teacherData = $q->fetch(PDO::FETCH_ASSOC);
  $sql = "SELECT * FROM sbe_students where team = ?";
  $result = readData(array($data['team_name']), $sql);
}
?>
<div class="container">
  <div class="span10 offset1">
    <div class="row">
      </br>
      <h3> Nauczyciel </h3>
      <hr style="width: 100%; height: 1px; background-color:lightgray;" />
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label>Imię</label>
        <input type="text" class="form-control" value='<?php echo !empty($teacherData['firstname']) ? $teacherData['firstname'] : ''; ?>' readonly required>
      </div>
      <div class="form-group col-md-3">
        <label>Nazwisko</label>
        <input type='text' class="form-control" value='<?php echo !empty($teacherData['lastname']) ? $teacherData['lastname'] : ''; ?>' readonly required>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label>Numer telefonu</label>
        <input type="text" class="form-control" value='<?php echo !empty($teacherData['phone']) ? $teacherData['phone'] : ''; ?>' readonly required>
      </div>
      <div class="form-group col-md-3">
        <label>Email</label>
        <input type='text' class="form-control" value='<?php echo !empty($teacherData['email']) ? $teacherData['email'] : ''; ?>' readonly required>
        <br>
        <br>
      </div>
    </div>
    <div class="row">
      <h3>Uczestnicy grupy <?php echo $data['team_name']; ?></h3>
      <hr style="width: 100%; height: 1px; background-color:lightgray;" />
    </div>
    <br />
    <!-- start of container -->
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Login</th>
            <th> Email</th>
            <th>Imie i Nazwisko</th>
            <th> Numer Telefonu</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($result as $row) {
            echo '<tr>';
            echo '<td>' . $row['login'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['firstname'] . " " . $row["lastname"];
            echo '<td>' . $row['phone'];

            echo '</tr>';
          }
          //Database::disconnect(); //kończymy połączenie
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- end of container -->
<?php
function readData($array, $sql)
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $q = $pdo->prepare($sql);
  $q->execute($array);
  return $q->fetchAll();
}

?>