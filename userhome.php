
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
    <a class="btn btn-warning" href="registration.php">Register</a>
  </div>
</nav>

<div class="container my-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="card-title text-center mb-4">Student Records</h2>
      <p>User details: <span class="text-danger"><?= htmlspecialchars($_SESSION["username"]) ?></span></p>


      <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Subject</th>
                <th>Marks</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row["id"] ?></td>
                <td><?= htmlspecialchars($row["STUDENT_NAME"]) ?></td>
                <td><?= htmlspecialchars($row["SUBJECT"]) ?></td>
                <td><?= htmlspecialchars($row["MARKS"]) ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-danger text-center">No data found!</p>
      <?php endif; ?>

      <div class="text-center mt-4">
        <a href="individual-student.php" class="btn btn-primary">View Individual Students</a>
        <a href="subject.php" class="btn btn-secondary">View Subject-wise Results</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
