<?php
session_start();
require_once __DIR__ . "/includes/db.php";
require_once __DIR__ . "/includes/auth.php";

// Logged in user id
$user_id = $_SESSION["user_id"];

// Handle search
$search = "";
$query = "SELECT * FROM students WHERE user_id=?";

if (isset($_GET['search']) && $_GET['search'] !== "") {
    $search = trim($_GET['search']);
    $query .= " AND (roll_no LIKE ? OR name LIKE ? OR course LIKE ?)";
    $stmt = $conn->prepare($query);
    $like = "%" . $search . "%";
    $stmt->bind_param("isss", $user_id, $like, $like, $like);
} else {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$students = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include __DIR__ . "/includes/navbar.php"; ?>
    <h2>Student Dashboard</h2>

    <!-- 🔎 Search Form -->
    <form method="get" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by Roll No, Name, or Course"
               value="<?php echo htmlspecialchars($search); ?>">
        <button class="btn btn-primary">Search</button>
        <a href="dashboard.php" class="btn btn-secondary ms-2">Reset</a>
    </form>

    <!-- 📋 Student Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Roll No</th>
                <th>Name</th>
                <th>Course</th>
                <th>Marks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($students->num_rows > 0): ?>
                <?php while ($row = $students->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['course']); ?></td>
                        <td><?php echo htmlspecialchars($row['marks']); ?></td>
                        <td>
                            <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_student.php?id=<?php echo $row['id']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this student?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">No students found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="add_student.php" class="btn btn-success">Add New Student</a>
</body>
</html>
