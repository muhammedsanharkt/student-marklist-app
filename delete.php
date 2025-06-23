<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "school";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'] ?? 0;

if ($id) {
    $sql = "DELETE FROM students_marks WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href='view-marks.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $conn->error . "'); window.location.href='view-marks.php';</script>";
    }
} else {
    echo "<script>alert('Invalid ID'); window.location.href='view-marks.php';</script>";
}
?>
