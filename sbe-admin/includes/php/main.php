<?php
session_start();
if ($_SESSION['userType'] != "admin") {
  header("Location: ../../../../index.php");
  exit();
}
require_once './session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link href="../css/dashboard.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.js"></script>
  <link href="../css/calendar.css" rel="stylesheet" />
  <script src="../js/calendar.js"></script>
  <title>Sky Blue - Platforma Edukacyjna</title>
</head>

<body>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#"> <span>Panel Administratora</span> </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <form action="logout.php" method="post">
          <button class="btn btn-primary btn-md" href="#">Wyloguj</a>
        </form>
      </li>
    </ul>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <?php include('./navbar.php'); ?>
      <?php
      if (isset($_GET['p']) && $_GET['p'] == "students") {
        include('./crud/index.php');
      } elseif (isset($_GET['p']) && $_GET['p'] == "teachers") {
        include('./crud/teachers_index.php');
      } elseif (isset($_GET['p']) && $_GET['p'] == "teams") {
        include('./crud/teams_index.php');
      } elseif (isset($_GET['p']) && $_GET['p'] == "calendar") {
        include('./calendar.php');
      } elseif (isset($_GET['p']) && $_GET['p'] == "dashboard") {
        include('./dashboard.php');
      } elseif (isset($_GET['p']) && $_GET['p'] == "potcustomers") {
        include('./crud/potentialCustomers_index.php');
      } elseif (isset($_GET['p']) && $_GET['p'] == "news") {
        include('./news.php');
      } else {
        include('./dashboard.php');
      };
      ?>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
  <script src="../js/dashboard.js"></script>
  <script src="../js/checkboxes.js"></script>

</body>

</html>