<?php
session_start();
require_once '../../session.php';
?>
<?php include("../../header.php"); ?>
<?php
if (isset($_GET['p']) && $_GET['p'] == "singleUser") {
  include('../inc/create/createStudent.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "singleUserParent") {
  include('../inc/create/createStudentParent.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "userParent") {
  include('../inc/create/createParent.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "createUser") {
  include('../inc/create/createChooseUser.html');
} elseif (isset($_GET['p']) && $_GET['p'] == "createTeacher") {
  include('../inc/create/createTeacher.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "createTeam") {
  include('../inc/create/createTeam.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "createPotCustomer") {
  include('../inc/create/createPotentialCustomer.inc.php');
}
?>
<?php include("../../footer.php"); ?>
