<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="includes/css/strona_glowna_nauczyciel_dziecko.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />

  <title>Strona Główna Nauczyciela</title>
  <?php


  $today = date('Y-m-d');
  $now = date("h:i:sa");
  $sqlTeam = 'SELECT * from sbe_teams where leader_id =?';
  $teamDatas = selectTeamLess($sqlTeam, array($userData['id']), $pdo, true);
  $nextLessonData = array();

  foreach ($teamDatas as $teamData) {
    $sqlNextLesson = "SELECT * FROM sbe_lesson WHERE team_id=? AND ( date=? AND lesson_time >= ? OR date>?) ORDER BY date, lesson_time ASC LIMIT 1";
    $nextLessonDatas = selectTeamLess($sqlNextLesson, array($teamData['id'], $today, $now, $today), $pdo, true);
    $nextLessonData = array_merge($nextLessonData, $nextLessonDatas);
  }
  usort($nextLessonData, "sortAsc");
  $lastLessonData = array();
  foreach ($teamDatas as $teamData) {
    $sqlLatestLesson = "SELECT * FROM sbe_lesson WHERE team_id=? AND ((date=? AND lesson_time < ?) OR date < ?) ORDER BY date DESC,lesson_time DESC";
    $lastLessonDataPrep = selectTeamLess($sqlLatestLesson, array($teamData['id'], $today, $now, $today), $pdo, true);
    $lastLessonData = array_merge($lastLessonData, $lastLessonDataPrep);
  }
  usort($lastLessonData, "sortDesc");

  $sqlNews = 'SELECT * FROM sbe_news WHERE id=?';
  $newsData = selectTeamLess($sqlNews, array(1), $pdo, false);

  if (isset($_POST['submit-lesson-input-test'])) {
    $id;
    $lastLessonTeamId;
    foreach ($lastLessonData as $row) {
      $id = $row['id'];
      $lastLessonTeamId = $row['team_id'];

      break;
    }
    $lessonTopic = $_POST['lessonTopic'];
    $lessonChallenge = $_POST['lessonChallenge'];
    $lessonAdditional = $_POST['lessonAdditional'];
    $sqlUpdateLesson = "UPDATE sbe_lesson set topic=?,challenge=?, additional=? WHERE id=?";
    $arrayUpdate = array($lessonTopic, $lessonChallenge, $lessonAdditional, $id);
    selectTeamLess($sqlUpdateLesson, $arrayUpdate, $pdo, false);
  }

  Database::disconnect();

  ?>
</head>

<body>
  <?php
  include('menu.php'); ?>
  <?php
  if (!empty($newsData['content'])) {
    echo "<div class='topBoxProject'><div id='currentProject'>";
    echo $newsData['content'];
    echo "</div>
     </div>";
  }
  ?>

  <div class="topBox">
    <div class="nextClass">
      Następna lekcja |
      <?php
      if (!empty($nextLessonData)) {
        $teamid;
        foreach ($nextLessonData as $row) {
          echo $row['date'] . " | " . $row['lesson_time'];
          $teamid = $row['team_id'];
          break;
        }
        $sqlNextTeam = 'SELECT * from sbe_teams where id =?';
        $teamNextData = selectTeamLess($sqlNextTeam, array($teamid), $pdo, false);
        echo " | " . $teamNextData['team_name'];
      } else {
        echo "BRAK";
      }
      ?>
    </div>
  </div>
  <div id="chat">
    <div id="tytulChat">
      <div id="chat">
        <div id="tytulChat">
          <div class="chat">
            <widgetbot class="widgetbot-chat" server="723520331461034015" channel="725296161967046666" width="95%" height="400"></widgetbot>
            <script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="input">
    <form action="" method="POST">
      <p class="inputBox">
        <?php
        if (!empty($lastLessonData)){
          $sqlLastTeam = 'SELECT * from sbe_teams where id =?';
        $teamLastData = selectTeamLess($sqlLastTeam, array($lastLessonTeamId), $pdo, false);
        echo $teamLastData['team_name'];
        } else {
          echo "BRAK";
        }
        

        ?></p>
      <p class="inputBox">
        <input name="lessonTopic" type="text" placeholder="Temat lekcji" /></p>

      <p class="inputBox">
        <input name="lessonChallenge" type="text" placeholder="Wyzwanie domowe" />
      </p>

      <p class="inputBox"><input name="lessonAdditional" type="text" placeholder="Materiały" /></p>

      <input name="submit-lesson-input-test" type="submit" value="Potwierdź" />
    </form>
  </div>
</body>
<script src="includes/js/scripts.js"></script>

</html>
<?php
function selectTeamLess($sql, $array, $pdo, $toAssoc)
{
  $p = $pdo->prepare($sql);
  $p->execute($array);
  if ($toAssoc) {
    return $p->fetchAll();
  } else {
    return $p->fetch(PDO::FETCH_ASSOC);
  }
}

function sortAsc($a, $b)
{
  return strtotime($a["lesson_time"]) - strtotime($b["lesson_time"]);
}
function sortDesc($a, $b)
{
  return strtotime($b['lesson_time']) - strtotime($a["lesson_time"]);
}
?>