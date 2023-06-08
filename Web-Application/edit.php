<?php

define('STUDENT_DATABASE', 'storage.json');

$students = [];

if (file_exists(STUDENT_DATABASE)) {
    $studentJson = file_get_contents(STUDENT_DATABASE);
    $students = json_decode($studentJson, true);
}

$studentRegistration = $_POST['registrationNumber'];

$studentFoundKey = null;

foreach ($students as $key => $student) {
    if ($student['registration'] === $studentRegistration) {
        $studentFoundKey = $key;
        $students[$studentFoundKey] = [
            'registration' => $_POST['registrationNumber'],
            'name' => $_POST['name'],
            'grade' => $_POST['grade'],
            'classroom' => $_POST['classroom'],
        ];
    }
}


$studentJson = json_encode($students);
file_put_contents(STUDENT_DATABASE, $studentJson);


echo "Student Updated Successfully!";
echo <<<HTML
<meta http-equiv="refresh" content="2; url='/index.php'" />
HTML;
