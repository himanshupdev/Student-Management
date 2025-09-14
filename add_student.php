<?php
session_start();
require_once __DIR__ . "/includes/db.php";
require_once __DIR__ . "/includes/auth.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $roll_no = $_POST["roll_no"];
    $name = $_POST["name"];
    $course = $_POST["course"];
    $marks = intval($_POST["marks"]);

    $stmt = $conn->prepare("INSERT INTO students (roll_no, name, course, marks, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $roll_no, $name, $course, $marks, $user_id);

    if ($stmt->execute()) {
        // ✅ Sync XML after adding
        require_once __DIR__ . "/includes/xml_sync.php";
        syncXML($conn);

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Failed to add student: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include __DIR__ . "/includes/navbar.php"; ?>
    <h2>Add Student</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
        <div class="mb-3"><label>Roll No</label><input type="text" name="roll_no" class="form-control" required></div>
        <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
        <div class="mb-3"><label>Course</label><input type="text" name="course" class="form-control" required></div>
        <div class="mb-3"><label>Marks</label><input type="number" name="marks" class="form-control" required></div>
        <button class="btn btn-success">Add</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
