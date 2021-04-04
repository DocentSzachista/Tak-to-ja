<?php
require '../connectDB_CRUD.php';
require '../inc/functions.php';
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
  $data = getRowQuery($sql, $id);
  /*********************************************************  
  Tutaj przeklej SQL'a z Teacher data oraz zawartość foreach'a
  **********************************************************/
  $sql = "SELECT id, firstname, lastname, email, phone FROM sbe_teachers WHERE id=? OR id=? OR id=?";
  $teacherData= readData(array($data['leader_id'], $data['leader2_id'], $data['leader_3id']), $sql);

  // SELECKA W SQL'u by wybrac trzech nauczycieli zrobiona na debila
  /*
  $sql = "SELECT firstname, lastname, email, phone FROM sbe_teachers WHERE id=?";
  $teacherData= getRowQuery($sql, $data['leader_id']);
  if($data['leader2_id']!=null)
  {
      $sql = "SELECT firstname, lastname, email, phone FROM sbe_teachers WHERE id=?";
      $teacherData2= getRowQuery($sql, $data['leader2_id']);
  }
  if($data['leader_3id']!=null)
  {
      $sql = "SELECT firstname, lastname, email, phone FROM sbe_teachers WHERE id=?";
      $teacherData3= getRowQuery($sql, $data['leader_3id']);
  }
  */
  $sql = "SELECT * FROM sbe_students where team = ?";
  $result = readData(array($data['team_name']), $sql);
}
?>

<div class="container">
  <div class="span10 offset1">
   
<?php 
    $iterate=0;
   foreach($teacherData as $row)
   {
     if($data['leader_3id']==$row['id'])
     {
       ?>
        <div class="row">
      </br>
      <h3> Zastępca </h3>
      <hr style="width: 100%; height: 1px; background-color:lightgray;" />
    </div>
       <?php
     }
     else
     {
       ?>
      <div class="row">
      </br>
      <h3> Nauczyciel <?php echo $iterate+1;?> </h3>
      <hr style="width: 100%; height: 1px; background-color:lightgray;" />
    </div>
    <?php
    $iterate++;
     }
?>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label>Imię</label>
          <input type="text" class="form-control" value='<?php echo !empty($row['firstname']) ? $row['firstname'] : ''; ?>' readonly required>
        </div>
        <div class="form-group col-md-3">
          <label>Nazwisko</label>
          <input type='text' class="form-control" value='<?php echo !empty($row['lastname']) ? $row['lastname'] : ''; ?>' readonly required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label>Numer telefonu</label>
          <input type="text" class="form-control" value='<?php echo !empty($row['phone']) ? $row['phone'] : ''; ?>' readonly required>
        </div>
        
        <div class="form-group col-md-3">
          <label>Email</label>
          <input type='text' class="form-control" value='<?php echo !empty($row['email']) ? $row['email'] : ''; ?>' readonly required>
          <br>
          <br>
        </div>
      </div>
      
<?php
} 
?>
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
  Database::disconnect();
  return $q->fetchAll();
}

?>