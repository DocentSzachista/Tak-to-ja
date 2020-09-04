<?php
                $pdo=Database::connect();
                    $query = "SELECT * FROM sbe_parents";
                    $results=$pdo->query($query);
                    //loop
                    foreach ($results as $row){
                ?>
                        <option value="<?php echo $row["id"];?>"><?php echo $row["firstname"]." ".$row['lastname'];?></option>
                <?php
                    }
                ?>