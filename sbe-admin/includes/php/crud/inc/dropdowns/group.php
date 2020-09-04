<?php
                $pdo=Database::connect();
                    $query = "SELECT * FROM sbe_teams";
                    $results=$pdo->query($query);
                    //loop
                    foreach ($results as $row){
                ?>
                        <option value="<?php echo $row["team_name"];?>"><?php echo $row["team_name"];?></option>
                <?php
                    }
                ?>