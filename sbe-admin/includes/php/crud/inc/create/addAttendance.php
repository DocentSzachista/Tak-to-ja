<?php
$sql= "SELECT * FROM sbe_teams WHERE team_name=:name";
        $sth=$pdo->prepare($sql);
        $sth->bindParam(':name', $team, PDO::PARAM_STR);
        $sth->execute();
        $result= $sth->fetch(PDO::FETCH_ASSOC);
        $teamId=$result['id'];
        
            $sql="SELECT id FROM sbe_lesson WHERE team_id= :name";
            $sth=$pdo->prepare($sql);
            $sth->bindParam(':name', $teamId, PDO::PARAM_INT);
            $sth->execute();
            $result= $sth->fetchAll();
            foreach($result as $row)
            {
                $sql="INSERT INTO sbe_attendance (lesson_id, student_id) VALUES (?,?)";
                $arrayOfInputs=array($row['id'], $student_id);
                addFutureUser($sql, $arrayOfInputs);
            }
?>
