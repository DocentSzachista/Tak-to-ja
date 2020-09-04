<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link href="../../../css/dashboard.css" rel="stylesheet" />
  <title>Sky Blue - Platforma Edukacyjna</title>
</head>
<body>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Panel Administratora</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <form action="../../logout.php" method="post">
          <button class="btn btn-primary btn-md" href="#">Wyloguj</a>
        </form>
      </li>
    </ul>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="../../main.php?p=dashboard">
                <span data-feather="home"></span>
                Strona Glowna <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../main.php?p=news">
                <span data-feather="file"></span>
                Ogloszenia
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../main.php?p=teachers">
                <span data-feather="users"></span>
                Nauczyciele
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../main.php?p=students">
                <span data-feather="users"></span>
                Uczniowie
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../main.php?p=teams">
                <span data-feather="bar-chart-2"></span>
                Grupy
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../main.php?p=potcustomers">
                <span data-feather="clipboard"></span>
                Potencjalni Klienci
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../main.php?p=calendar">
                <span data-feather="calendar"></span>
                Kalendarz
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <main role="main" class="main col-md-9 ml-sm-auto col-lg-10 px-md-4">