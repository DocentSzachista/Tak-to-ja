<?php
session_start();
require_once '../../session.php';
?>
<?php
include('../../header.php');
?>
<?php
if (isset($_GET['p']) && $_GET['p'] == "student") {
  include('../inc/update/updateStudent.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "teacher") {
  include('../inc/update/updateTeacher.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "team") {
  include('../inc/update/updateTeam.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "potCustomer") {
  include('../inc/update/updatePotentialCustomer.inc.php');
}
?>
<?php
include('../../footer.php');
?>
 