<html>
<head>
    <?php
    include_once "page_parts/head.php";
    ?>

    <script>
        $(document).ready(function () {
            $("#add-lesson").click(function () {

                if (!$("#lesson-field").val().includes($('select[name=lessons-selector]').val())) {
                    $('#lessons-remove-selector').append($('<option>', {
                        value: $('select[name=lessons-selector]').val(),
                        text: $('#lessons-selector').find(":selected").text()
                    }));

                    $("#lesson-field").val($("#lesson-field").val() + " " + $('select[name=lessons-selector]').val());
                }
            });

            $("#remove-lesson").click(function () {
                $("#lesson-field").val($("#lesson-field").val().replace(' ' + $('select[name=lessons-remove-selector]').val(), ''));
                $("#lessons-remove-selector option[value='" + $('select[name=lessons-remove-selector]').val() + "']").remove();
            });
        });
    </script>


</head>
<body class="container">
<?php
include_once "page_parts/header.php";
?>

<?php
include_once "page_parts/login_checker.php";
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $student_number = mysqli_real_escape_string($link, $_POST['student_number']);
    $target = mysqli_real_escape_string($link, $_POST['target']);
    $description = mysqli_real_escape_string($link, $_POST['description']);
    $knowledge = mysqli_real_escape_string($link, $_POST['knowledge']);
    $lessonField = mysqli_real_escape_string($link, $_POST['lesson-field']);
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($student_number) || empty($target) || empty($description) || empty($knowledge)) {
        showAlertDialogMethod("Συμπληρωστε όλα τα πεδία");
        exit();
    }

    add_thesis($link, $title, $user_id, intval($student_number), $target, $description, $knowledge, $lessonField);

}
?>
<div class="page_content">
    <form action="add_thesis.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Τίτλος:</label>
            <input required="required" type="text" class="form-control" id="title" name="title" placeholder="Τίτλος">
        </div>
        <div class="form-group">
            <label for="student_number">Αριθμός Φοιτητών:</label>
            <input required="required" type="number" max="3" min="1" class="form-control" id="student_number"
                   name="student_number"
                   placeholder="Αριθμός Φοιτητών">
        </div>
        <div class="form-group">
            <label for="target">Στόχος Διπλωματικής:</label>
            <input required="required" type="text" class="form-control" id="target" name="target"
                   placeholder="Στόχος Διπλωματικής">
        </div>
        <div class="form-group">
            <label for="description">Συνοπτική Περιγραφή:</label>
            <input required="required" type="text" class="form-control" id="description" name="description"
                   placeholder="Συνοπτική Περιγραφή">
        </div>
        <div class="form-group">
            <label for="knowledge">Προαπαιτούμενες γνώσεις</label>
            <input required="required" type="text" class="form-control" id="knowledge" name="knowledge"
                   placeholder="Προαπαιτούμενες γνώσεις">
        </div>


        <div class="form-group">
            <label for="lessons-selector">Διαθέσιμα Μαθήματα:</label>
            <div class="input-group">
                <select class="form-control" name="lessons-selector" type="text" id="lessons-selector"
                        style="margin-top: 10px;margin-bottom: 10px">
                    <?php
                    $result = getLessonsFromDatabase($link);

                    while ($lesson = $result->fetch_assoc()) {
                        echo '<option value="' . $lesson["id"] . '">' . $lesson["name"] . '</option>';
                    }
                    ?>
                </select>
                <span class="input-group-btn">
                        <button type="button" id="add-lesson" class="btn btn-success form-control">Προσθήκη</button>
                    </span>
            </div>
        </div>

        <div class="form-group">
            <input type="hidden" id="lesson-field" name="lesson-field" value="">
        </div>

        <div class="form-group">
            <label for="lessons-selector">Επιλεγμένα Μαθήματα:</label>
            <div class="input-group">
                <select class="form-control" name="lessons-remove-selector" type="text" id="lessons-remove-selector"
                        style="margin-top: 10px;margin-bottom: 10px">
                </select>
                <span class="input-group-btn">
                        <button type="button" id="remove-lesson" class="btn btn-danger form-control">Αφαίρεση</button>
                    </span>
            </div>
        </div>

        <button type="submit" name="add" id="add" class="btn btn-primary">Προσθήκη</button>

    </form>
</div>
</body>
