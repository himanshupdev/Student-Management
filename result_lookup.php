<?php
// Path to XML file
$xmlFile = __DIR__ . "/student_data.xml";
$student = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = trim($_POST["roll_no"]);

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);

        foreach ($xml->student as $s) {
            if ((string)$s->roll_no === $roll_no) {
                $student = $s;
                break;
            }
        }

        if (!$student) {
            $error = "No student found with Roll No: " . htmlspecialchars($roll_no);
        }
    } else {
        $error = "XML file not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Result Lookup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Check Student Result</h2>
    <form method="post" class="mb-3">
        <div class="mb-3">
            <label>Enter Roll No:</label>
            <input type="text" name="roll_no" class="form-control" required>
        </div>
        <button class="btn btn-primary">Search</button>
    </form>

    <?php if ($student): ?>
        <div class="card p-3">
            <h4>Result Found</h4>
            <p><strong>Roll No:</strong> <?= htmlspecialchars($student->roll_no) ?></p>
            <p><strong>Name:</strong> <?= htmlspecialchars($student->name) ?></p>
            <p><strong>Course:</strong> <?= htmlspecialchars($student->course) ?></p>
            <p><strong>Marks:</strong> <?= htmlspecialchars($student->marks) ?></p>
        </div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
</body>
</html>
