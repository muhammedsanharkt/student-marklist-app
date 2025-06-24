<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Subject-wise Results</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

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

// Grouping data by subject and sorting
$sql = "SELECT * FROM students_marks ORDER BY SUBJECT, MARKS DESC";
$result = $conn->query($sql);
?>

<div class="container my-5">
  <h2 class="text-center mb-4">Subject-wise Results</h2>
  <div class="row g-4">

<?php
if ($result && $result->num_rows > 0) {
  $subjects = [];

  while ($row = $result->fetch_assoc()) {
    $subjects[$row['SUBJECT']][] = $row;
  }

  foreach ($subjects as $subject => $students) {
    echo "<div class='col-md-6 col-lg-4'>";
    echo "<div class='card shadow-sm h-100'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center text-primary'>" . htmlspecialchars($subject) . "</h5>";
    echo "<table class='table table-bordered table-striped table-sm mt-3'>
            <thead class='table-light'>
              <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Marks</th>
              </tr>
            </thead>
            <tbody>";

    $serial = 1;
    foreach ($students as $s) {
      echo "<tr>
              <td>$serial</td>
              <td>" . htmlspecialchars($s['STUDENT_NAME']) . "</td>
              <td>" . htmlspecialchars($s['MARKS']) . "</td>
            </tr>";
      $serial++;
    }

    echo "</tbody></table>";
    echo "</div></div></div>"; // card + col
  }

} else {
  echo "<p class='text-danger'>No subject data available.</p>";
}

$conn->close();
?>

  </div>
  <div class="text-center mt-4">
    <a href="adminpage.php" class="btn btn-success text-white">Go Back</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
