<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="includes/css/strona_glowna_ucznia_dziecko.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />

  <title>Strona Główna Rodzica</title>
  <?php
  $today = date('Y-m-d');
  $now = date("h:i:sa");
  $sqlStudents = "SELECT * FROM sbe_students WHERE id_parent_key=?";
  $studentsData = selectTeamLess($sqlStudents, array($userData['id']), $pdo, true);
  $nextLessonData = array();
  $lastLessonData = array();

  foreach ($studentsData as $row) {
    $sqlTeams = "SELECT * FROM sbe_teams WHERE team_name=?";
    $teamsData = selectTeamLess($sqlTeams, array($row['team']), $pdo, false);

    $sqlNextLesson = "SELECT * FROM sbe_lesson WHERE team_id=? AND ( date=? AND lesson_time >= ? OR date>?) ORDER BY date, lesson_time ASC LIMIT 1";
    $nextLessonDatas = selectTeamLess($sqlNextLesson, array($teamsData['id'], $today, $now, $today), $pdo, true);
    $nextLessonData = array_unique(array_merge($nextLessonData, $nextLessonDatas), SORT_REGULAR);

    $sqlLatestLesson = "SELECT * FROM sbe_lesson WHERE team_id=? AND ((date=? AND lesson_time < ?) OR date < ?) ORDER BY date DESC, lesson_time DESC";
    $lastLessonDataPrep = selectTeamLess($sqlLatestLesson, array($teamsData['id'], $today, $now, $today), $pdo, true);
    $lastLessonData = array_unique(array_merge($lastLessonData, $lastLessonDataPrep), SORT_REGULAR);
  }
  usort($nextLessonData, "sortAsc");
  usort($lastLessonData, "sortDesc");

  $sqlNews = 'SELECT * FROM sbe_news WHERE id=?';
  $newsData = selectTeamLess($sqlNews, array(1), $pdo, false);

  ?>
</head>

<body>
  <?php
  include('menu.php'); ?>
  <?php
  if (!empty($newsData['content'])) {
    echo "<div id='pasekNews'><p id='tekstNews'>";
    echo $newsData['content'];
    echo "</p>
     </div>";
  }
  ?>

  <div class="topBox">
    <div class="nextClass">
      Następna lekcja:
      <?php
      foreach ($nextLessonData as $nextLesson) {
        echo $nextLesson['date'] . " | " . $nextLesson['lesson_time'] . " | ";
      }
      ?>
    </div>
  </div>

  <div class="topBox">
    <div id="currentProject">
      <?php
      $teamsArray = array();
      foreach ($studentsData as $row) {
        $sqlTeams = "SELECT * FROM sbe_teams WHERE team_name=?";
        $teamsData = selectTeamLess($sqlTeams, array($row['team']), $pdo, true);
        $teamsArray = array_unique(array_merge($teamsArray, $teamsData), SORT_REGULAR);
      }
      foreach ($teamsArray as $teams) {
        echo $teams['team_name'] . " : " . $teams['goal'] . " : " . $teams['end_date'] . " | ";
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

  <div class="pasek" onclick="homework()">
    <!-- Elementy rozwijają po nacisnięciu w ten div -->
    <div id="zadanieDomowe">
      <img class="dolnyPasekObraz" src="includes/assets/IKONY_strona_glowna/home_white.png" />

      <span class="dolnyPasekTekst">Wyzwanie domowe</span>
    </div>
  </div>
  <div id="homeworkDrop">
    <div class="sumUp">
      <p id="sumUpHomework">
        <?php
        foreach ($lastLessonData as $lastLes) {
          if (!empty($lastLes['challenge'])) {
            echo $lastLes['challenge'] . " | ";
          }
        }

        ?>
      </p>
    </div>
  </div>

  <div class="pasek" onclick="lastClass()">
    <div id="ostatniaLekcja">
      <img class="dolnyPasekObraz" src="includes/assets/IKONY_strona_glowna/last_class_white.png" />

      <span class="dolnyPasekTekst">Ostatnia lekcja</span>
    </div>
  </div>
  <div id="lastClassDrop">
    <div class="sumUp">
      <p class="sumUpClass">
        <?php
        foreach ($lastLessonData as $lastLes) {
          if (!empty($lastLes['topic'])) {
            echo $lastLes['topic'] . " | ";
          }
        }

        ?></p>
    </div>

    <div class="sumUp">
      <p class="sumUpClass">
        <?php
        foreach ($lastLessonData as $lastLes) {
          if (!empty($lastLes['additional'])) {
            echo $lastLes['additional'] . " | ";
          }
        }

        ?></p>
    </div>
  </div>

  <script src="includes/js/scripts.js"></script>
</body>

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