<?php
$conn = new mysqli("localhost", "root", "", "school");

if (isset($_GET['type']) && isset($_GET['term'])) {
    $type = $_GET['type']; // either 'name' or 'subject'
    $term = $conn->real_escape_string($_GET['term']);

    $column = $type === "name" ? "STUDENT_NAME" : "SUBJECT";
    $sql = "SELECT DISTINCT $column FROM students_marks WHERE $column LIKE '%$term%' LIMIT 10";
    $result = $conn->query($sql);

    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row[$column];
    }

    echo json_encode($suggestions);
}
?>
