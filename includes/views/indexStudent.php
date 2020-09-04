<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="includes/css/strona_glowna_ucznia_dziecko.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />

  <title>Strona Główna Ucznia</title>

  <?php
  $today = date('Y-M-D');
  $sqlTeam = 'SELECT * from sbe_teams where team_name =?';
  $teamData = selectTeamLess($sqlTeam, array($userData['team']), $pdo);
  $sqlNextLesson = 'SELECT * FROM sbe_lesson WHERE team_id=? AND date > ? ORDER BY date ASC LIMIT 1';
  $nextLessonData = selectTeamLess($sqlNextLesson, array($teamData['id'], $today), $pdo);
  $sqlLatestLesson = 'SELECT * FROM sbe_lesson WHERE team_id=? AND date < ? ORDER BY date DESC LIMIT 1';
  $lastLessonData = selectTeamLess($sqlLatestLesson, array($teamData['id'], $today), $pdo);
  $sqlNews = 'SELECT * FROM sbe_news WHERE id=?';
  $newsData = selectTeamLess($sqlNews, array(1), $pdo);
  Database::disconnect();



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
      Nastepna lekcja
      <?php
      if (!empty($nextLessonData['date'])) {
        echo $nextLessonData['date'] . " " . $nextLessonData['lesson_time'];
      } else {
        echo "BRAK";
      }

      ?>

    </div>
  </div>

  <div class="topBox">
    <div id="currentProject">
      <?php
      if (!empty($teamData['goal'])) {
        echo $teamData['goal'];
      } else {
        echo "BRAK";
      }
      ?>
      |
      <?php
      if (!empty($teamData['end_date'])) {
        echo $teamData['end_date'];
      } else {
        echo "BRAK";
      }
      ?>

    </div>
  </div>

  <div id="chat">
    <div id="tytulChat">
      <div class="chat">
        <widgetbot class="widgetbot-chat" server="723520331461034015" channel="725296161967046666" width="95%" height="400"></widgetbot>
        <script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script>
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
        if (!empty($lastLessonData['challenge'])) {
          echo $lastLessonData['challenge'];
        } else {
          echo "BRAK";
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
      <p class="sumUpClass">Temat ostatniej lekcji:
        <?php
        if (!empty($lastLessonData['topic'])) {
          echo $lastLessonData['topic'];
        } else {
          echo "BRAK";
        }
        ?>
      </p>
    </div>

    <div class="sumUp">
      <p class="sumUpClass">Materiały: 
      <?php
        if (!empty($lastLessonData['additional'])) {
          echo $lastLessonData['additional'];
        } else {
          echo "BRAK";
        }
        ?>
      </p>
    </div>
  </div>
  <script src="includes/js/scripts.js"></script>
</body>

</html>

<?php
function selectTeamLess($sql, $array, $pdo)
{
  $p = $pdo->prepare($sql);
  $p->execute($array);
  return $p->fetch(PDO::FETCH_ASSOC);
}
?>