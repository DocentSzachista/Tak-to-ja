<?php
require 'crud/connectDB_CRUD.php';
require 'crud/inc/functions.php';
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM sbe_lesson";
$q = $pdo->prepare($sql);
$q2 = $pdo->prepare($sql);
$q->execute();
$q2->execute();
$data = $q->fetch(PDO::FETCH_ASSOC);
$iteration = $q2->fetchAll();
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
        addFutureUser($sqlINSERT,  $arrayOfInputs);
        header("Refresh:0");
    }
}
if (isset($_POST['delete-lesson'])) {
    if (!empty($_POST['lesson_id'])) {
        $id = $_POST['lesson_id'];
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
<main role="main" class="main col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <form method="post">
        <div>
            <div id='calendar'></div>
        </div>
    </form>
    <!-- Modal Add-->
    <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dodaj wydarzenie</h5>
                    <button href="#" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                        <input type="text" id="lesson_id" name="lesson_id" style="display:none;" class="form-control">
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
                    left: 'prev,next today addUser',
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
                    var lessonId = info.event.id;
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

                },
                editable: false,
                dayMaxEvents: true, // allow "more" link when too many events
                events: [

                    <?php foreach ($iteration as $row) {

                        $id = $row['team_id'];

                        $sql = "SELECT * FROM sbe_teams where id = ?";
                        $querys = $pdo->prepare($sql);
                        $querys->execute(array($id));
                        $teamInfo = $querys->fetch(PDO::FETCH_ASSOC);

                        $sqlAttendance = "SELECT * FROM sbe_attendance WHERE lesson_id=?";
                        $q = $pdo->prepare($sqlAttendance);
                        $q->execute(array($row['id']));
                        $dataAttendance = $q->fetchAll();
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
                            $sqlStudentName = "SELECT * FROM sbe_students WHERE id=?";
                            $array = array($lessonRow['student_id']);
                            $q = $pdo->prepare($sqlStudentName);
                            $q->execute($array);
                            $studentNameData = $q->fetch(PDO::FETCH_ASSOC);;

                            echo $lessonRow['id'] . ":" .  $studentNameData['firstname'] . " " . $studentNameData['lastname'] . ":" . $lessonRow['participated'] . ";";
                        }
                        echo "',},";
                    }
                    ?>
                ]
            });



            calendar.render();

        });
    </script>
</main>