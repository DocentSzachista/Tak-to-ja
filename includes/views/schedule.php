<html>

<head>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="includes/css/PODSTRONA_plan_lekcji.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.js"></script>


    <title>Strona Główna Ucznia</title>
</head>

<body>
    <div class="container-fluid" style="max-width:1048px;">
        <div class="row">
            <main role="main" class="main col ml-sm-auto px-md-4 justify-content-end">
                <?php
                include('menu.php'); ?>

                <div id="planPadding">

                    <div class="plan">

                        <?php
                        require 'sbe-admin/includes/php/crud/inc/functions.php';



                        $pdo = Database::connect();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        //sql statement tam gdzie id=? to sobie wybiera?

                        if ($userType == "student") {
                            $sqlTeam = "SELECT * FROM sbe_teams where team_name=?";
                            $t = $pdo->prepare($sqlTeam);
                            $t->execute(array($userData['team']));
                            $teamData = $t->fetch(PDO::FETCH_ASSOC);

                            $sql = "SELECT * FROM sbe_lesson WHERE team_id=?";
                            $q = $pdo->prepare($sql);
                            $q2 = $pdo->prepare($sql);
                            $q->execute(array($teamData['id']));
                            $q2->execute(array($teamData['id']));
                            $data = $q->fetch(PDO::FETCH_ASSOC);
                            $iteration = $q2->fetchAll();
                        } else if ($userType == "parent") {
                            // $sqlTeam = "SELECT * FROM sbe_teams where team_name=?";
                            $sqlChildren = "SELECT team FROM sbe_students WHERE id_parent_key=?";
                            $m = $pdo->prepare($sqlChildren);
                            $m->execute(array($userData['id']));
                            $childrenData = $m->fetchAll();

                            $iteration = array();
                            // $sqlChildren = "SELECT * FROM sbe_teams where team_name='python_01' or team_name='python_08'";
                            foreach ($childrenData as $row) {
                                $sqlTeam = "SELECT * FROM sbe_teams WHERE team_name=?";
                                $t = $pdo->prepare($sqlTeam);
                                $t->execute(array($row['team']));
                                $teamData = $t->fetch(PDO::FETCH_ASSOC);

                                $sql = "SELECT * FROM sbe_lesson WHERE team_id=?";
                                $q = $pdo->prepare($sql);
                                $q->execute(array($teamData['id']));
                                $iterations = $q->fetchAll();
                                $iteration = array_unique(array_merge($iteration, $iterations), SORT_REGULAR);
                            }
        
                        } else if ($userType == "teacher") {
                            $sqlTeam = "SELECT * FROM sbe_teams where leader_id=?";
                            $t = $pdo->prepare($sqlTeam);
                            $t->execute(array($userData['id']));
                            $teamData = $t->fetchALL();
                            $iteration = array();
                            foreach ($teamData as $row) {
                                $sql = "SELECT * FROM sbe_lesson WHERE team_id=?";
                                $q = $pdo->prepare($sql);
                                $q->execute(array($row['id']));
                                $iterations = $q->fetchAll();
                                $iteration = array_merge($iteration, $iterations);
                            }
                        }



                        if (isset($_POST['update-lesson'])) {
                            $topic = $_POST['topic'];
                            $date = $_POST['date'];
                            $challenge = $_POST['challenge'];
                            $id = $_POST['lesson_id'];
                            $start_time = $_POST['start_time'];
                            $end_time = $_POST['end_time'];
                            $attendanceData = $_POST['attendance'];


                            $valid = true;
                            if ($valid) {
                                $sqlINSERT = "UPDATE sbe_lesson SET topic = ?, date=?, challenge=?, lesson_time=?, end_time=? WHERE id = ?";
                                $arrayOfInputs = array($topic, $date, $challenge, $start_time, $end_time, $id);
                                addFutureUser($sqlINSERT,  $arrayOfInputs);
                                //TODO: Update dla checkboxów
                                foreach ($attendanceData as $key => $value) {
                                    $sqlUPDATE = "UPDATE sbe_attendance SET participated=? WHERE id=?";
                                    $arrayOfInputs = array($value, $key);
                                    addFutureUser($sqlUPDATE, $arrayOfInputs);
                                }
                                header("Refresh:0");
                            }
                        }
                        if (isset($_POST['add-lesson-submit'])) {
                            $newPostTeam = $_POST['team_name-add'];
                            $newPostTopic = $_POST['topic-add'];
                            $newPostDate = $_POST['date-add'];
                            $newPostStart = $_POST['start_time-add'];
                            $newPostChallenge = $_POST['challenge-add'];
                            $newEndTime = $_POST['end_time-add'];
                            $valid = false;

                            $sql = "SELECT * FROM sbe_teams where team_name = ?";
                            $team_id = searchUser($newPostTeam, $sql, 'id');
                            if (!empty($team_id)) {
                                $valid = true;
                            } else {
                                header("Location: main.php?p=error");
                            }
                            if ($valid) {
                                $sqlINSERT = "INSERT INTO sbe_lesson (team_id, topic, date, lesson_time, end_time, challenge) values(?,?,?,?,?,?)";
                                $arrayOfInputs = array($team_id, $newPostTopic, $newPostDate, $newPostStart, $newEndTime, $newPostChallenge);
                                addFutureUser($sqlINSERT, $arrayOfInputs);

                                header("Refresh:0");
                            }
                        }


                        if (isset($_POST['delete-lesson'])) {
                            if (!empty($_POST['id'])) {
                                $id = $_POST['id'];
                                $pdo = Database::connect();
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sql = "SELECT * FROM sbe_lesson where id = ?";
                                $q = $pdo->prepare($sql);
                                $q->execute(array($id));
                                $data = $q->fetch(PDO::FETCH_ASSOC);
                            }

                            if (!empty($_POST)) {
                                $sql = "DELETE FROM sbe_lesson WHERE id = ?";
                                delete($sql, true);
                            }
                        }
                        ?>


                        <div>
                            <div id='calendar'></div>
                        </div>


                        <!-- Modal Add-->
                        <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Dodaj wydarzenie</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Nazwa grupy</label>
                                                <input type="text" id="team_name-add" name="team_name-add" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Temat</label>
                                                <input type="text" id="topic-add" name="topic-add" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Data</label>
                                                <input type="date" id="date-add" name="date-add" class="form-control" required />
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Godzina</label>
                                                <input type="time" id="start_time-add" name="start_time-add" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Godzina</label>
                                                <input type="time" id="end_time-add" name="end_time-add" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Wyzwanie domowe</label>
                                                <textarea class="form-control" name="challenge-add" id="challenge-add"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="submit-lesson" name="add-lesson-submit" class="btn btn-success">Stworz</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Zamknij</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit-->
                        <!-- Modal Edit-->
                        <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edytuj wydarzenie</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body" id="modal-edit-body">
                                            <input type="text" id="lesson_id" name="lesson_id" class="form-control" style="display:none;">
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Temat</label>
                                                <input type="text" id="topic" name="topic" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Data</label>
                                                <input type="date" id="date" name="date" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Godzina</label>
                                                <input type="time" id="start_time" name="start_time" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Godzina</label>
                                                <input type="time" id="end_time" name="end_time" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Wyzwanie domowe</label>
                                                <textarea class="form-control" name="challenge" id="challenge"></textarea>
                                            </div>
                                            <table class="table" id="attendance-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Imie i nazwisko</th>
                                                        <th scope="col">Obecnosc</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="attendance-table-body">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="delete-lesson" name="delete-lesson" class="btn btn-danger">Usun</button>
                                            <button id="submit-lesson" name="update-lesson" class="btn btn-success">Aktualizuj</button>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Zamknij</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Read-->
                        <div class="modal fade" id="ModalRead" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Wydarzenie</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Temat</label>
                                                <input type="text" id="topic-read" class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Data</label>
                                                <input type="date" id="date-read" class="form-control" readonly />
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Godzina</label>
                                                <input type="time" id="start_time-read" class="form-control" readonly />
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Godzina</label>
                                                <input type="time" id="end_time-read" class="form-control" readonly />
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Wyzwanie domowe</label>
                                                <textarea class="form-control" name="challenge" id="challenge-read" readonly></textarea>
                                            </div>
                                            <table class="table" id="attendance-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Imie i nazwisko</th>
                                                        <th scope="col">Obecnosc</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="attendance-read-table-body">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Zamknij</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>






                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var calendarEl = document.getElementById('calendar');

                                var calendar = new FullCalendar.Calendar(calendarEl, {

                                    customButtons: {
                                        addUser: {
                                            text: 'Dodaj wydarzenie',
                                            click: function() {
                                                $('#ModalAdd').modal('show');
                                            }
                                        }
                                    },
                                    headerToolbar: {
                                        left: 'prev,next today <?php
                                                                if ($userType == "teacher") {
                                                                    echo "addUser";
                                                                }
                                                                ?>',
                                        center: 'title',
                                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                                    },
                                    initialDate: new Date(),
                                    navLinks: true,
                                    selectable: true,
                                    selectMirror: true,
                                    select: function(arg) {
                                        calendar.unselect()
                                    },
                                    eventClick: function(info) {

                                        <?php
                                        if ($userType == "teacher") {
                                            echo " var lessonId = info.event.id;
                                            $('#ModalEdit #lesson_id').val(info.event.id);
                                            $('#ModalEdit #topic').val(info.event.extendedProps.topic);
                                            $('#ModalEdit #date').val(info.event.extendedProps.eventDate);
                                            $('#ModalEdit #challenge').val(info.event.extendedProps.chall);
                                            $('#ModalEdit #start_time').val(info.event.extendedProps.lessonTime);
                                            $('#ModalEdit #end_time').val(info.event.extendedProps.endLessonTime);
                        
                                            //spliting data into arrays and making table out of them
                                            var table = ''
                                            var attendanceList = info.event.extendedProps.CustomStudentList;
                                            attendanceList = attendanceList.split(';')
                                            attendanceList.pop()
                                            for (i = 0; i < attendanceList.length; i++) {
                                                var attendanceStudent = attendanceList[i].split(':')
                                                table += '<tr><td>' + attendanceStudent[1] + '</td>' + '<td><input class=clicker-checkbox type=checkbox>' + '<input class=form-check-input name=attendance[' +
                                                    attendanceStudent[0] + '] value=' + attendanceStudent[2] + ' style=display:none;></td></tr>'
                        
                                                //| wrzucić indeks obecności w[] np żeby było attendance[123]
                                            }
                                            table += '</tbody></table>'
                                            $('#attendance-table-body').html(table)
                                            // checkboxes are being checked
                                            $('#ModalEdit').modal('show');

                                            var checkboxArray = document.getElementsByClassName('form-check-input')
                                        var clickCheckbox = document.getElementsByClassName('clicker-checkbox')

                                        for (k = 0; k < clickCheckbox.length; k++) {
                                            if (checkboxArray[k].value == 1) {
                                                clickCheckbox[k].checked = true;
                                            }
                                        }
                                        $('input[type=checkbox]').on('change', function(e) {
                                            if ($(this).prop('checked')) {
                                                $(this).next().val(1);
                                            } else {
                                                $(this).next().val(0);
                                            }
                                        });
                                            
                        ";
                                        } else {
                                            echo "
                                            $('#ModalRead #topic-read').val(info.event.extendedProps.topic);
                                            $('#ModalRead #date-read').val(info.event.extendedProps.eventDate);
                                            $('#ModalRead #challenge-read').val(info.event.extendedProps.chall);
                                            $('#ModalRead #start_time-read').val(info.event.extendedProps.lessonTime);
                                            $('#ModalRead #end_time-read').val(info.event.extendedProps.endLessonTime);
                                            
                                            var table = ''
                                            var attendanceList = info.event.extendedProps.CustomStudentList;
                                            attendanceList = attendanceList.split(';')
                                            attendanceList.pop()
                                            for (i = 0; i < attendanceList.length; i++) {
                                                var attendanceStudent = attendanceList[i].split(':')
                                                table += '<tr><td>' + attendanceStudent[1] + '</td>' + '<td><input class=clicker-checkbox type=checkbox readonly>' + '<input class=form-check-input name=attendance[' +
                                                    attendanceStudent[0] + '] value=' + attendanceStudent[2] + ' style=display:none;></td></tr>'
                        
                                                //| wrzucić indeks obecności w[] np żeby było attendance[123]
                                            }
                                            table += '</tbody></table>'
                                            $('#attendance-read-table-body').html(table)
                                            // checkboxes are being checked
                                            var checkboxArray = document.getElementsByClassName('form-check-input')
                                            var clickCheckbox = document.getElementsByClassName('clicker-checkbox')
                        
                                            for (k = 0; k < clickCheckbox.length; k++) {
                                                if (checkboxArray[k].value == 1) {
                                                    clickCheckbox[k].checked = true;
                                                }
                                            }
                                            $('input[type=checkbox]').on('change', function(e) {
                                                if ($(this).prop('checked')) {
                                                    $(this).next().val(1);
                                                } else {
                                                    $(this).next().val(0);
                                                }
                                            });
                                            $('#ModalRead').modal('show');
                                            ";
                                        }

                                        ?>
                                    },
                                    editable: false,
                                    dayMaxEvents: true, // allow "more" link when too many events
                                    events: [

                                        <?php foreach ($iteration as $row) 
                                        {

                                            $id = $row['team_id'];

                                            $sql = "SELECT * FROM sbe_teams where id = ?";
                                            $querys = $pdo->prepare($sql);
                                            $querys->execute(array($id));
                                            $teamInfo = $querys->fetch(PDO::FETCH_ASSOC);
                                            if ($userType == "student") 
                                            {
                                                $sqlAttendance = "SELECT * FROM sbe_attendance INNER JOIN sbe_students ON sbe_students.id=sbe_attendance.student_id WHERE lesson_id=? AND student_id=?";
                                                $array = array($row['id'], $userData['id']);
                                                $q = $pdo->prepare($sqlAttendance);
                                                $q->execute($array);
                                                $dataAttendance = $q->fetchAll();
                                            }
                                             else if($userType == "parent")
                                            {
                                                $sql = "SELECT id FROM sbe_students WHERE id_parent_key=?";
                                                $m = $pdo->prepare($sql);
                                                $m->execute(array($userData['id']));
                                                $id_student = $m->fetchAll();
                                                $dataAttendance= array();
                                                foreach($id_student as $ids)
                                                {
                                                    $sqlAttendance = "SELECT * FROM sbe_attendance INNER JOIN sbe_students ON sbe_students.id=sbe_attendance.student_id WHERE lesson_id=? AND student_id=?";
                                                    $array = array($row['id'], $ids['id']);
                                                    $q = $pdo->prepare($sqlAttendance);
                                                    $q->execute($array);
                                                    $dataAttendances = $q->fetchAll();
                                                    $dataAttendance=array_merge($dataAttendance, $dataAttendances);
                                                    
                                                }
                                                
                                            }
                                             else if ($userType == "teacher") 
                                            {
                                                $sqlAttendance = "SELECT * FROM sbe_attendance INNER JOIN sbe_students ON sbe_attendance.student_id=sbe_students.id WHERE lesson_id=? ";
                                                $array = array($row['id']);
                                                $q = $pdo->prepare($sqlAttendance);
                                                $q->execute($array);
                                                $dataAttendance = $q->fetchAll();
                                                
                                            }
                                           

                                            Database::disconnect();
                                            $title = $row['topic'];

                                            echo "
    {
        id: '" . $row['id'] . "',
        title: '" . $teamInfo['team_name'] . "',
        start: '" . $row['date'] . "T" . $row['lesson_time'] . "',
        end: '" . $row['date'] . "T" . $teamInfo['end_time'] . "',
        topic: '" . $row['topic'] . "',
        eventDate: '" . $row['date'] . "',
        chall: '" . $row['challenge'] . "',
        color: '" . $teamInfo['color'] . "',
        lessonTime: '" . $row['lesson_time'] . "',
        endLessonTime: '" . $row['end_time'] . "',
        CustomStudentList: '";
                                            foreach ($dataAttendance as $lessonRow) {
                                                    next($lessonRow);
                                                    echo $lessonRow['id'] . ":" .  $lessonRow['firstname']. " ".$lessonRow['lastname'] . ":" . $lessonRow['participated'] . ";";
                                            }
                                            echo "',},";
                                            
                                        }
                                        
                                        ?>
                                    ]
                                });



                                calendar.render();



                            });
                        </script>



                    </div>

                </div>

                <div class="lastClassPadding">
                    <div class="lastClassBox">
                        <a href="?p=user"> <img class="lastClassArrow" src="includes/assets/IKONY_kalendarz/arrow_left_white.png" />

                            <div id="lastClassText">
                                <p>Ostatnia lekcja</p>
                            </div>
                        </a>
                    </div>
                </div>
            </main>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    
</body>

</html>