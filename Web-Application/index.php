<?php

define('STUDENT_DATABASE', 'storage.json');

$students = [];

if (!file_exists(STUDENT_DATABASE)) {
    file_put_contents(STUDENT_DATABASE, json_encode($students));
}

$students = json_decode(file_get_contents(STUDENT_DATABASE), true);

if (isset($_POST['action']) && ($_POST['action'] === 'add-student')) {

    $registration = $_POST['registrationNumber'];
    foreach ($students as $student) {
        if ($registration === $student['registration']) {
            echo 'Duplicate Registration Numbers are NOT allowed!';
            echo <<<HTML
                <meta http-equiv="refresh" content="2; url='/index.php'" />
                HTML;
            return $students;
        }
    }
    $students[] = [
        'registration' => $_POST['registrationNumber'],
        'name' => $_POST['name'],
        'grade' => $_POST['grade'],
        'classroom' => $_POST['classroom'],
    ];

    $studentJson = json_encode($students);
    file_put_contents(STUDENT_DATABASE, $studentJson);
}

if (isset($_POST['action']) && ($_POST['action'] === 'delete-student')) {
    $studentIndex = (int)$_POST['studentIndex'];
    unset($students[$studentIndex]);
    $students = array_values($students);
    $studentJson = json_encode($students);
    file_put_contents(STUDENT_DATABASE, $studentJson);
}

?>

<html>
<head>
    <title>Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="font-family: Arial, sans-serif;">
<div class="container">
    <h2>Student Registration System</h2>
<form action="index.php" method="post" name="add-student">
    <input type="hidden" name="studentIndex" value="#" />
    <input type="hidden" name="action" value="add-student" />
    <div class="mb-3">
        <label for="registration_number" class="form-label">Registration Number:</label>
        <input type="number" class="form-control" name="registrationNumber" placeholder="Registration" required>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" name="name" class="form-control" placeholder="Enter name" required>
    </div>

    <div class="mb-3">
        <label for="grade" class="form-lable">Grade:</label>
        <select class="form-select" name="grade" aria-label="Default select example">
        <?php for ($i = 0; $i <= 10; $i++):?>
            <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="classroom" class="form-label">Classroom:</label>
        <select class="form-select" name="classroom" aria-label="Default select example">
            <option value="selected">...</option>
            <option value="English">English</option>
            <option value="Mathematics">Mathematics</option>
            <option value="Biology">Biology</option>
            <option value="Economics">Economics</option>
            <option value="Chemistry">Chemistry</option>
            <option value="Physics">Physics</option>
        </select>
    </div>

    <input type="submit" value="Add">
</form>
<h2 class="mb-3">List of Students</h2>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Registration Number</th>
        <th scope="col">Name</th>
        <th scope="col">Grade</th>
        <th scope="col">Classroom</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $key => $_POST) : ?>
        <tr>
            <td><?= $_POST['registration'] ?></td>
            <td><?= $_POST['name'] ?></td>
            <td><?= $_POST['grade'] ?></td>
            <td><?= $_POST['classroom'] ?></td>
            <td>
                <a href="edit_page.php?registration=<?= $_POST['registration'] ?>" class="btn btn-success">Edit
                </a>
            </td>
            <td>
                <button type="button" class="btn btn-danger">Delete
                    <input type="hidden" name="studentClickedKey" value="<?= $key ?>" />
                </button>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
</div>

<script>
    let table = document.querySelector('table')
    let form = document.querySelector('form')

    let inputStudentIndex = form.querySelector('input[name=studentIndex]')
    let inputAction = form.querySelector('input[name=action]')

    table.addEventListener('click', function(event) {
        if (event.target.tagName === 'BUTTON') {
            let key = event.target.querySelector('input[name=studentClickedKey]').value

            inputStudentIndex.value = key
            inputAction.value = 'delete-student'

            form.submit()

        }
    })
</script>
</body>
</html>
