<?php
session_start();
require_once '../../session.php';
?>
<?php
include('../../header.php');
?>
<?php
if (isset($_GET['p']) && $_GET['p'] == "student") {
  include('../inc/delete/deleteStudent.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "teacher") {
  include('../inc/delete/deleteTeacher.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "team") {
  include('../inc/delete/deleteTeam.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "potCustomer") {
  include('../inc/delete/deletePotentialCustomer.inc.php');
}
?>
<?php
include('../../footer.php');
?>
 