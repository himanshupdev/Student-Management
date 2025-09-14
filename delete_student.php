<?php
session_start();
require_once __DIR__ . "/includes/db.php";
require_once __DIR__ . "/includes/auth.php";

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = intval($_GET['id']);

// Delete student
$stmt = $conn->prepare("DELETE FROM students WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $_SESSION["user_id"]);

if ($stmt->execute()) {
    // ✅ After deletion, re-sync XML
    require_once __DIR__ . "/includes/xml_sync.php";
    syncXML($conn);

    header("Location: dashboard.php");
    exit;
} else {
    echo "Failed to delete student.";
}
