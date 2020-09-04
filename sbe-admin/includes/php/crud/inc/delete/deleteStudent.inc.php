<?php
require '../connectDB_CRUD.php';
require '../inc/functions.php';
$id = 0;

if (!empty($_GET['id'])) 
{
    $id = $_REQUEST['id'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM sbe_students where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $isChild=$data['ischild'];
    $parentId=$data['id_parent_key'];

    if (!empty($_POST)) 
    {
        $sql = "DELETE FROM sbe_informations WHERE student_id=?";
        deleteUser($sql, $id);
        $sql = "DELETE FROM sbe_students WHERE id = ?";
        deleteUser($sql, $id);
        if($isChild==1)
        {
        $sql="SELECT id_parent_key FROM sbe_students WHERE id_parent_key = ?";
        $query=$pdo->prepare($sql);
        $query->execute(array($parentId));
        $id= $query->fetch(PDO::FETCH_ASSOC);
        print_r($id);
        if(empty($id))
            {
                $sql="DELETE FROM sbe_parents WHERE id=?";
                deleteUser($sql, $parentId);
            }
        }
        header("Location: ../../main.php?p=students");

    }
    
}


?>

<div class="container">
    <div class="span10 offset1">
        <div class="row">
            <h3>Na pewno chcesz usunac <?php echo $data['firstname'] . " " . $data['lastname']; ?>?</h3>
        </div>
        <form class="form-horizontal" action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Tak</button>
                <a class="btn btn-primary" href="../../main.php?p=students">Nie</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->
</body>

</html>
