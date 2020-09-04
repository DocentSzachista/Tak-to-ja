<?php
include('./crud/inc/functions.php');
if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}
$num_per_page = 12;
$start_from = ($page - 1) * $num_per_page;
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main">
  <h2>Nauczyciele</h2>
  <!-- search box  -->
  <form method="post">
    <div class="form-group row">
      <div class="form-group col-md-3">
        <input class="form-control" type="text" name="search" placeholder="Wyszukaj..">
      </div>
      <div class="form-group col-md-4">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit-search"><span data-feather="search"></span> Szukaj</button>
        <a href="./crud/methods/create.php?p=createTeacher" class="btn btn-success"><span data-feather="plus-circle"></span></a>
      </div>
    </div>
  </form>
  <!-- koniec searchboxa -->
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>Login</th>
          <th>Email</th>
          <th>Imię i Nazwisko</th>
          <th>Numer Telefonu</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include 'connectDB_CRUD.php';
        $pdo = Database::connect();
        if (isset($_POST['submit-search'])) {
          $str = "%{$_POST['search']}%";
          $sql = "SELECT * FROM sbe_teachers WHERE CONCAT_WS(firstname, lastname, email, phone) LIKE :keyword LIMIT $start_from,$num_per_page";
          $q = $pdo->prepare($sql);
          $q->bindValue(':keyword', $str, PDO::PARAM_STR);
          $q->execute();
          $result = $q->fetchAll();
        } else {
          $sql = "SELECT * FROM sbe_teachers ORDER BY id DESC LIMIT $start_from, $num_per_page";
          $result = $pdo->query($sql);
        }
        foreach ($result as $row) {    //wypisujemy dane z bazy
          echo '<tr>'; // tutaj wstawiaj kolejne porcje danych jakie Ci trzeba
          echo '<td>' . $row['login'] . '</td>';
          echo '<td>' . $row['email'] . '</td>';
          echo '<td>' . $row['firstname'] . " " . $row["lastname"];
          echo '<td>' . $row['phone'];
          echo '<td width= 250>';
          echo '<a class="btn btn-sm btn-outline-primary" href="./crud/methods/read.php?p=teacher&id=' . $row['id'] . '"><span data-feather="book-open"></span></a>';
          echo ' ';
          echo '<a class="btn btn-outline-success btn-sm" href="./crud/methods/update.php?p=teacher&id=' . $row['id'] . '"><span data-feather="edit"></span></a>';
          echo ' ';
          echo '<a class="btn btn-danger btn-sm" href="./crud/methods/delete.php?p=teacher&id=' . $row['id'] . '"><span data-feather="minus-circle"></span></a>';
          echo '</td>';
          echo '</tr>';
        }
        //Database::disconnect(); //kończymy połączenie
        ?>
      </tbody>
    </table>
    <nav aria-label="Page nagvigation">
      <ul class="pagination">
        <?php
        $page_query = "SELECT COUNT(*) FROM sbe_teachers ";
        $total_pages = pagin($page_query, $num_per_page, $start_from);
        if ($total_pages > 1) {
          for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class=page-item border border-primary><a class=page-link href=?p=teachers&page=$i>" . $i . "</a> </li>";
          }
        }
        ?>
      </ul>
    </nav>

  </div>
</main>