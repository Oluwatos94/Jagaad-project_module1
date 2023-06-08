<?php

define('STUDENT_DATABASE', 'storage.json');

$students = [];

if (file_exists(STUDENT_DATABASE)) {
$studentJson = file_get_contents(STUDENT_DATABASE);
$students = json_decode($studentJson, true);
}

$studentRegistration = $_GET['registration'];


$studentFoundKey = null;

foreach ($students as $key => $student) {
    if ($student['registration'] === $studentRegistration) {
        $studentFoundKey = $key;
        break;
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<link rel="stylesheet" href="style.css">

<div class="container">
    <form name="edit-student" method="post" action="edit.php">
        <h2>Edit Student</h2>
        <div class="mb-3">
            <label for="registration_number" class="form-label">Registration Number </label>
            <input type="number" name="registrationNumber" class="form-control" value="<?= $students[$studentFoundKey]['registration'] ?>" placeholder="Registration" readonly required />
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= $students[$studentFoundKey]['name'] ?>" placeholder="Name" required />
        </div>
        <div class="mb-3">
            <label for="grade" class="form-label">Grade</label>
            <select class="form-select" name="grade" aria-label="Default select example">
                <?php
                $selectedGrade = $students[$studentFoundKey]['grade'];
                for ($i = 0; $i <= 10; $i++) {
                    $selected = ($i == $selectedGrade) ? 'selected' : '';
                    echo "<option value='$i' $selected>$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="classroom" class="form-label">Classroom</label>
            <select class="form-select" name="classroom" aria-label="Default select example">
                <?php
                $selectedClassroom = $students[$studentFoundKey]['classroom'];
                $classrooms = ['English', 'Mathematics', 'Biology', 'Economics', 'Chemistry', 'Physics'];
                foreach ($classrooms as $classroom) {
                    $selected = ($classroom == $selectedClassroom) ? 'selected' : '';
                    echo "<option value='$classroom' $selected>$classroom</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>