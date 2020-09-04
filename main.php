<?php
session_start();
require_once './includes/php/session.php';
require 'includes/php/dbConnect.inc.php';
require_once './includes/php/student.php';
$userId = $_SESSION['userId'];
$userType = $_SESSION['userType'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($userType == "parent") {
  $sql = "SELECT * FROM sbe_parents WHERE id=?;";
} else if ($userType == "student") {
  $sql = "SELECT * FROM sbe_students WHERE id=?;";
} else if ($userType == "teacher") {
  $sql = "SELECT * FROM sbe_teachers WHERE id=?;";
}
$q = $pdo->prepare($sql);
$q->execute(array($userId));
$userData = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

if ($userType == "student") {
  if (isset($_GET['p']) && $_GET['p'] == "profile") {
    include('./includes/views/userProfile.php');
  } elseif (isset($_GET['p']) && $_GET['p'] == "schedule") {
    include('./includes/views/schedule.php');
  } else {
    include('includes/views/indexStudent.php');
  }
} elseif ($userType == "teacher") {
  if (isset($_GET['p']) && $_GET['p'] == "profile") {
    include('./includes/views/userProfile.php');
  } elseif (isset($_GET['p']) && $_GET['p'] == "schedule") {
    include('./includes/views/schedule.php');
  } else {
    include('includes/views/indexTeacher.php');
  }
} elseif ($userType == "parent") {
  if (isset($_GET['p']) && $_GET['p'] == "profile") {
    include('./includes/views/userProfile.php');
  } elseif (isset($_GET['p']) && $_GET['p'] == "schedule") {
    include('./includes/views/schedule.php');
  } else {
    include('includes/views/indexParent.php');
  }
}
