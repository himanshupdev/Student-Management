<?php
require_once __DIR__ . "/db.php";

function syncXML($conn) {
    $result = $conn->query("SELECT * FROM students");
    if (!$result) {
        error_log("DB Error in syncXML: " . $conn->error);
        return false;
    }

    $xml = new DOMDocument("1.0", "UTF-8");
    $xml->formatOutput = true;

    $root = $xml->createElement("students");

    while ($row = $result->fetch_assoc()) {
        $student = $xml->createElement("student");

        $student->appendChild($xml->createElement("roll_no", htmlspecialchars($row['roll_no'])));
        $student->appendChild($xml->createElement("name", htmlspecialchars($row['name'])));
        $student->appendChild($xml->createElement("course", htmlspecialchars($row['course'])));
        $student->appendChild($xml->createElement("marks", $row['marks']));

        $root->appendChild($student);
    }

    $xml->appendChild($root);
    $xml->save(__DIR__ . "/student_data.xml");
    return true;
}
