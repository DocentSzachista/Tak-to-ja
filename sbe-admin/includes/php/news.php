<?php
require 'crud/connectDB_CRUD.php';
require 'crud/inc/functions.php';

if (isset($_POST['news-submit'])) {
    $newsContent = $_POST['news-content'];

    $sqlNews = "UPDATE sbe_news SET content = ? WHERE id = ?";
    $arrayOfInputs = array($newsContent, 1);
    addFutureUser($sqlNews,  $arrayOfInputs);
}

$pdo = Database::connect();
$sql = "SELECT * FROM sbe_news where id = 1";
$querys = $pdo->prepare($sql);
$querys->execute();
$datas = $querys->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
?>
<main role="main" class="main col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="container">
        <div class="span10 offset1">
            <div class="row">
                <br />

                <h3>Ogłoszenie</h3>
            </div>

            <form action="" method="POST">
                <div class="form-row align-items-center">
                    <div class="col-md-4">
                        <br />

                        <label class="sr-only" for="inlineFormInput">Ogłoszenie</label>
                        <input type="text" name="news-content" class="form-control mb-6" id="inlineFormInput" placeholder="<?php echo $datas['content']; ?>">
                    </div>

                </div>
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <button type="submit" name="news-submit" class="btn btn-primary mb-2">Submit</button>
                    </div>


                </div>
            </form>
        </div>
    </div>
</main>