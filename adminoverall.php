<?php
$conn = new mysqli("localhost", "root", "", "school");

$sql = "SELECT STUDENT_NAME, SUM(MARKS) AS total_marks
        FROM students_marks
        GROUP BY STUDENT_NAME
        ORDER BY total_marks DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Overall Student Ranking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

<div class="container my-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="text-center mb-4">Overall Student Ranking</h2>

      <?php if ($result->num_rows > 0): ?>
      <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>Rank</th>
            <th>Student Name</th>
            <th>Total Marks</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $rank = 1;
          while ($row = $result->fetch_assoc()):
          ?>
          <tr>
            <td><?= $rank++ ?></td>
            <td><?= htmlspecialchars($row["STUDENT_NAME"]) ?></td>
            <td><?= $row["total_marks"] ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <?php else: ?>
        <p class="text-danger text-center">No data found!</p>
      <?php endif; ?>
    </div>
  </div>
  <div class="text-center mt-4">
    <a href="adminpage.php" class="btn btn-success text-white">Go Back</a>
  </div>
</div>

</body>
</html>
