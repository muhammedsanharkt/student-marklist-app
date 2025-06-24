<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "school";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$nameErr = $subjectErr = $marksErr = "";
$name = $subject = $marks = "";
$success = "";

$success = "";
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success = "Student record added successfully!";
}


// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $valid = true;

    if (empty($_POST['student_name'])) {
        $nameErr = "Student name is required";
        $valid = false;
    } else {
        $name = strtoupper(trim($_POST['student_name']));
        if (!preg_match("/^[A-Z ]+$/", $name)) {
            $nameErr = "Only letters and spaces allowed";
            $valid = false;
        }
    }

    if (empty($_POST['subject'])) {
        $subjectErr = "Subject is required";
        $valid = false;
    } else {
        $subject = strtoupper(trim($_POST['subject']));
        if (!preg_match("/^[A-Z ]+$/", $subject)) {
            $subjectErr = "Only letters and spaces allowed";
            $valid = false;
        }
    }

    if (empty($_POST['marks'])) {
        $marksErr = "Marks are required";
        $valid = false;
    } else {
        $marks = trim($_POST['marks']);
        if (!is_numeric($marks) || $marks < 0 || $marks > 100) {
            $marksErr = "Enter valid marks between 0 and 100";
            $valid = false;
        }
    }

    if ($valid) {
        $insert = "INSERT INTO students_marks (STUDENT_NAME, SUBJECT, MARKS)
                   VALUES ('$name', '$subject', $marks)";
        if ($conn->query($insert) === TRUE) {
    // Redirect to the same page (avoids form resubmission on refresh)
    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
    exit();
}

    }
}

$sql = "SELECT * FROM students_marks";
$result = $conn->query($sql);
?>

<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Mark List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    .error-msg { color: red; font-size: 0.875rem; }
    
  </style>
</head>
<body class="bg-light text-dark d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php">School Management</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto me-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>

    <a class="btn btn-success ms-auto me-1" href="login.php">Switch Account</a>
    <a class="btn btn-warning" href="registration.php">register</a>
    
  </div>
  </nav>

<div class="container my-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="card-title text-center mb-4">Student Records</h2>
      <p>User details: <span class="text-danger"><?= htmlspecialchars($_SESSION["username"]) ?></span></p>

      <?php if ($success): ?>
        <div id="successMsg" class="alert alert-info text-center"><?= $success ?></div>
      <?php endif; ?>

      <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Subject</th>
                <th>Marks</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row["id"] ?></td>
                <td><?= htmlspecialchars($row["STUDENT_NAME"]) ?></td>
                <td><?= htmlspecialchars($row["SUBJECT"]) ?></td>
                <td><?= htmlspecialchars($row["MARKS"]) ?></td>
                <td>
                  <a href="edit.php?id=<?= $row["id"] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
                  <a href="delete.php?id=<?= $row["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-danger text-center">No data found!</p>
      <?php endif; ?>

      <div class="text-center mt-4">
        <a href="admin-individual-marks.php" class="btn btn-primary">View Individual Students</a>
        <a href="admin-subject-wise.php" class="btn btn-secondary">View Subject-wise Results</a>
        <a href="adminoverall.php" class="btn btn-info">View Overall Ranking</a>
      </div>

      <hr class="my-5"/>
      <h4 class="text-center">Add Student Marks</h4>

      <form method="POST" action="" class="row g-3 mt-3">
        <div class="col-md-4">
          <label for="student_name" class="form-label">Student Name</label>
          <input type="text" class="form-control text-uppercase" id="student_name" name="student_name" value="<?= htmlspecialchars($name) ?>" required>
          <div class="error-msg"><?= $nameErr ?></div>
        </div>
        <div class="col-md-4">
          <label for="subject" class="form-label">Subject</label>
          <input type="text" class="form-control text-uppercase" id="subject" name="subject" value="<?= htmlspecialchars($subject) ?>" required>
          <div class="error-msg"><?= $subjectErr ?></div>
        </div>
        <div class="col-md-4">
          <label for="marks" class="form-label">Marks</label>
          <input type="number" class="form-control" id="marks" name="marks" value="<?= htmlspecialchars($marks) ?>" required>
          <div class="error-msg"><?= $marksErr ?></div>
        </div>
        <div class="col-12 text-center mt-3">
          <button type="submit" name="submit" class="btn btn-success">Add Record</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Auto-hide success message
  setTimeout(() => {
    const msg = document.getElementById('successMsg');
    if (msg) msg.style.display = 'none';
  }, 3000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
