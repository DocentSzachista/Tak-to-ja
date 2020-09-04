<!--do headera -->
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
<!-- do headera czy jakiegoś innego pliku -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main">
  <h2>Potencjalni klienci</h2>
  <!-- search box  -->
  <form method="post">
    <div class="form-group row">
      <div class="form-group col-md-3">
        <input class="form-control" type="text" name="search" placeholder="Wyszukaj..">
      </div>
      <div class="form-group col-md-4">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit-search"><span data-feather="search"></span> Szukaj</button>
        <a href="./crud/methods/create.php?p=createPotCustomer" class="btn btn-success"><span data-feather="plus-circle"></span></a>
      </div>
    </div>
  </form>
  <!-- koniec searchboxa -->
  <?php error_reporting(E_ALL); ?>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>Imię i Nazwisko</th>
          <th>Email</th>
          <th>Miasto</th>
          <th>Numer telefonu</th>
          <th>Rodzaj zajęć</th>
          <th>Akcja</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include 'connectDB_CRUD.php';
        //include('search.php');
        $pdo = Database::connect();
        // logika dla search boxa
        if (isset($_POST['submit-search'])) {
          $str = "%{$_POST['search']}%";
          $sql = "SELECT * FROM `sbe_potential_customers`
          WHERE CONCAT_WS(firstname,  lastname, email, school,  activity) LIKE :keyword";
          $q = $pdo->prepare($sql);
          $q->bindValue(':keyword', $str, PDO::PARAM_STR);
          $q->execute();
          $result = $q->fetchAll();
        } else {
          $sql = "SELECT * FROM sbe_potential_customers ORDER BY id DESC LIMIT $start_from, $num_per_page";
          $result = $pdo->query($sql);
        }
        //koniec logiki searchboxa
        foreach ($result as $row) {    //wypisujemy dane z bazy
          echo '<tr>'; // tutaj wstawiaj kolejne porcje danych jakie Ci trzeba
          echo '<td>' . $row['firstname'] . " " . $row["lastname"] . '</td>';
          echo '<td>' . $row['email'] . '</td>';
          echo '<td>' . $row['city'] . '</td>';
          echo '<td>' . $row['phone'] . '</td>';
          echo '<td>' . $row['activity'] . '</td>';
          echo '<td width= 245>';
          echo '<a class="btn btn-sm btn-outline-primary" href="./crud/methods/read.php?p=potCustomer&id=' . $row['id'] . '"><span data-feather="book-open"></span></a>';
          echo ' ';
          echo '<a class="btn btn-sm btn-outline-success" href="./crud/methods/update.php?p=potCustomer&id=' . $row['id'] . '"><span data-feather="edit"></span></a>';
          echo ' ';
          echo '<a class="btn btn-danger btn-sm" href="./crud/methods/delete.php?p=potCustomer&id=' . $row['id'] . '"><span data-feather="minus-circle"></span></a>';
          echo '</td>';
          echo '</tr>';
        }
        Database::disconnect(); //kończymy połączenie
        ?>
      </tbody>
    </table>
    <nav aria-label="Page nagvigation">
      <ul class="pagination">
        <?php
        $page_query = "SELECT COUNT(*) FROM sbe_potential_customers ";
        $total_pages = pagin($page_query, $num_per_page, $start_from);
        if ($total_pages > 1) {
          for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class=page-item border border-primary><a class=page-link href=?p=potcustomers&page=$i>" . $i . "</a> </li>";
          }
        }
        ?>
      </ul>
    </nav>
  </div>
</main>