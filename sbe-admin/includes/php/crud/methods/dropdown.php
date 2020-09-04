<div class="parent">

    <select class="form-control" name=<?php
    if(isset($usedParent))
    {
        echo"dropParent";
    }
    else
    {
        echo"dropdown";
    }
    ?>>
        <option value="">Wybierz</option>
        <?php
        if ((isset($_GET['p']) && $_GET['p'] == "singleUserParent" OR $_GET['p'] == "potCustomer") && !isset($usedParent)) {
            include('../inc/dropdowns/parent.php');
            $usedParent = true;
        } else if ((isset($_GET['p']) && ($_GET['p'] == "userParent" || $_GET['p'] == "singleUser")) || isset($usedParent)) {
            include('../inc/dropdowns/group.php');
        } else {
            die("Unexpected error has occured");
        }
        ?>
    </select>

</div>