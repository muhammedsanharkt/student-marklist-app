<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "school";

// DB Connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get record by ID
$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM students_marks WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Invalid record ID.");
}
$row = $result->fetch_assoc();

// Update
if (isset($_POST['update'])) {
    $name = strtoupper(trim($_POST['student_name']));
    $subject = strtoupper(trim($_POST['subject']));
    $marks = trim($_POST['marks']);

    $update = "UPDATE students_marks SET STUDENT_NAME='$name', SUBJECT='$subject', MARKS=$marks WHERE id=$id";
    if ($conn->query($update) === TRUE) {
        echo "<script>window.location.href='home.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error updating: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Record</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <h3 class="text-center mb-4">Edit Student Record</h3>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Student Name</label>
          <input type="text" name="student_name" class="form-control text-uppercase" value="<?= htmlspecialchars($row['STUDENT_NAME']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Subject</label>
          <input type="text" name="subject" class="form-control text-uppercase" value="<?= htmlspecialchars($row['SUBJECT']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Marks</label>
          <input type="number" name="marks" class="form-control" value="<?= htmlspecialchars($row['MARKS']) ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="home.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>

</body>
</html>
