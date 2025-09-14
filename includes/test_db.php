<?php
// test_db.php -- Put it in project root and open http://localhost/student-result-management/test_db.php
require_once __DIR__ . '/includes/db.php';

if ($conn->connect_errno) {
    echo "DB connection error: " . $conn->connect_error;
    exit;
}

$res = $conn->query("SELECT COUNT(*) AS c FROM users");
if ($res) {
    $row = $res->fetch_assoc();
    echo "DB OK — users table exists. Count: " . $row['c'];
} else {
    echo "DB OK but query failed (maybe users table missing). MySQL error: " . $conn->error;
}
