<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="includes/css/PODSTRONA_profil.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" />
  <title>Profil</title>
</head>

<body>
  <?php include('menu.php'); ?>
  <div id="changePasswordPadding">
    <div class="changePassword">

      <div id="changePasswordTitle">
        <p>Zmiana hasła</p>
      </div>
      <?php
      if (isset($_POST['change-password'])) {
        $id = $userData['id'];
        $currentPassword = $_POST['current-password'];
        $newPassword = $_POST['password-new'];
        $checkPassword = $_POST['password-check'];

        if (password_verify($currentPassword, $userData['password'])) {
          if ($newPassword == $checkPassword) {
            $password = $newPassword;
            $password = password_hash($password, PASSWORD_DEFAULT);
            if ($userData['userType'] == 'student') {
              $sqlINSERT = "UPDATE sbe_students SET password=? WHERE id = ?";
            } elseif ($userData['userType'] == 'parent') {
              $sqlINSERT = "UPDATE sbe_parents SET password=? WHERE id = ?";
            } elseif ($userData['userType'] == 'teacher') {
              $sqlINSERT = "UPDATE sbe_teachers SET password=? WHERE id = ?";
            }
            $arrayOfInputs = array($password, $id);
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $q = $pdo->prepare($sqlINSERT);
            $q->execute($arrayOfInputs);
            echo "<div class='alert-success' role='alert'><p>
        Hasło zostało zmienione!</p>
      </div>";
            Database::disconnect();
          } else {
            echo "<div class='alert-wrong-password' role='alert'>
        <p>
        Podane hasła się różnią!/<p>
      </div>";
          }
        } else {
          echo "<div class='alert-wrong-password' role='alert'><p>
      Podano złe hasło!</p>
    </div>";
        }
      }
      ?>

      <div class="input">
        <form action="" method="post">
          <p class="inputBox">
            <input type="text" name="current-password" placeholder="Aktualne hasło" required />
          </p>

          <p class="inputBox">
            <input type="text" name="password-new" placeholder="Nowe hasło" minlength="4" required />
          </p>

          <p class="inputBox">
            <input type="text" name="password-check" placeholder="Powtórz nowe hasło" minlength="4" required />
          </p>

          <input name="change-password" type="submit" value="Potwierdź" />
        </form>
      </div>
    </div>
  </div>

  <div class="lastClassPadding">
    <div class="lastClassBox">
      <a href="?p=user"> <img class="lastClassArrow" src="includes/assets/IKONY_kalendarz/arrow_left_white.png" /> </a>

      <div id="lastClassText">
        <p>Ostatnia lekcja</p>
      </div>

    </div>
  </div>

  <script>
    function myFunction() {
      var x = document.getElementById("hamburger");
      if (x.style.display === "block") {
        x.style.display = "none";
      } else {
        x.style.display = "block";
      }
    }
  </script>
</body>

</html>