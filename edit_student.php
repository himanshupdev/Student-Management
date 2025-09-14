<?php
session_start();
require_once __DIR__ . "/includes/db.php";
require_once __DIR__ . "/includes/auth.php";

// Enable debugging (remove in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Fetch student by ID ---
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM students WHERE id=? AND user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo "Student not found.";
    exit;
}

// --- Update Student ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST["roll_no"];
    $name    = $_POST["name"];
    $course  = $_POST["course"];
    $marks   = $_POST["marks"];

    // Detect column types dynamically
    $fields = [
        "roll_no" => $roll_no,
        "name"    => $name,
        "course"  => $course,
        "marks"   => $marks,
        "id"      => $id
    ];

    // Get types from DB schema
    $schema = [];
    $colRes = $conn->query("SHOW COLUMNS FROM students");
    while ($col = $colRes->fetch_assoc()) {
        $schema[$col['Field']] = $col['Type'];
    }

    // Build bind types string
    $bindTypes = "";
    $values = [];
    foreach ($fields as $col => $val) {
        if (!isset($schema[$col])) continue;
        $type = strtolower($schema[$col]);

        if (strpos($type, "int") !== false) {
            $bindTypes .= "i";
            $values[] = (int)$val;
        } elseif (strpos($type, "decimal") !== false || strpos($type, "float") !== false || strpos($type, "double") !== false) {
            $bindTypes .= "d";
            $values[] = (float)$val;
        } else {
            $bindTypes .= "s";
            $values[] = (string)$val;
        }
    }

    // Build SQL dynamically
    $update = "UPDATE students SET roll_no=?, name=?, course=?, marks=? WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param($bindTypes, ...$values);

    if ($stmt->execute()) {
        // Sync XML
        require_once __DIR__ . "/includes/xml_sync.php";
        syncXML($conn);

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Failed to update student: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include __DIR__ . "/includes/navbar.php"; ?>
    <h2>Edit Student</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
        <div class="mb-3"><label>Roll No</label><input type="text" name="roll_no" value="<?php echo htmlspecialchars($student['roll_no']); ?>" class="form-control" required></div>
        <div class="mb-3"><label>Name</label><input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" class="form-control" required></div>
        <div class="mb-3"><label>Course</label><input type="text" name="course" value="<?php echo htmlspecialchars($student['course']); ?>" class="form-control" required></div>
        <div class="mb-3"><label>Marks</label><input type="number" name="marks" value="<?php echo htmlspecialchars($student['marks']); ?>" class="form-control" required></div>
        <button class="btn btn-success">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
