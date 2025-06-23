<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "school";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student data
$id = $_GET['id'];
$sql = "SELECT * FROM students_marks WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Update logic
if (isset($_POST['update'])) {
    $name = $_POST['student_name'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    $update = "UPDATE students_marks SET STUDENT_NAME='$name', SUBJECT='$subject', MARKS=$marks WHERE id=$id";

    if ($conn->query($update) === TRUE) {
        echo "<script> window.location.href='view-marks.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error updating: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="text-center mb-4">Edit Student Record</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Student Name</label>
                    <input type="text" name="student_name" class="form-control" value="<?= htmlspecialchars($row['STUDENT_NAME']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" value="<?= htmlspecialchars($row['SUBJECT']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Marks</label>
                    <input type="number" name="marks" class="form-control" value="<?= htmlspecialchars($row['MARKS']) ?>" required>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="view-marks.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
