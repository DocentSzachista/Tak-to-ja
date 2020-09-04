<main role="main" class="main col-md-9 ml-sm-auto col-lg-10 px-md-4">


    <?php
    include './crud/connectDB_CRUD.php';
    function displayAmount($sql)
    {
        $pdo = Database::connect();
        $q = $pdo->prepare($sql);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        echo $data['total'];
    }
    $students = 'SELECT COUNT(id) as total FROM sbe_students';
    $teachers = 'SELECT COUNT(id) as total FROM sbe_teachers';
    $teams = 'SELECT COUNT(id) as total FROM sbe_teams';
    $potCustomers = 'SELECT COUNT(id) as total FROM sbe_potential_customers';
    
    Database::disconnect();
    ?>
    <canvas class="my-2 w-100" id="myChart" width="300" height="150" 
    students="<?php displayAmount($students) ?>" 
    teachers="<?php displayAmount($teachers) ?>" 
    teams="<?php displayAmount($teams) ?>"
    potCustomers = "<?php displayAmount($potCustomers) ?>"
    ></canvas>
</main>