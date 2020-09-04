<?php
session_start();
require_once '../../session.php';
?>
<?php
include('../../header.php');
?>
<?php
if (isset($_GET['p']) && $_GET['p'] == "student") {
  include('../inc/read/readStudent.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "teacher") {
  include('../inc/read/readTeacher.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "team") {
  include('../inc/read/readTeam.inc.php');
} elseif (isset($_GET['p']) && $_GET['p'] == "potCustomer") {
  include('../inc/read/readPotentialCustomer.inc.php');
}
?>
<?php
include('../../footer.php');
?>
 