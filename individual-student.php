<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Marklist</title>
    <!-- Bootstrap 5 CDN -->
     <style>
        body{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
     </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "school";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>    

<div class="container mt-5">
    <h2 class="text-center mb-5">Individual Marklist</h2>
    <div class="row g-4">

<?php
$sql = "SELECT * FROM students_marks ORDER BY STUDENT_NAME, SUBJECT";
$groupingresult = $conn->query($sql);

if ($groupingresult && $groupingresult->num_rows > 0) {
    $students = [];

    while ($row = $groupingresult->fetch_assoc()) {
        $students[$row['STUDENT_NAME']][] = $row;
    }

    foreach ($students as $student_name => $marks) {
        echo "<div class='col-md-6 col-lg-4'>"; // 2 per row on md, 3 per row on lg
        echo "<div class='card h-100 shadow-sm'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title text-center text-primary'>" . htmlspecialchars($student_name) . "</h5>";
        echo "<div class='table-responsive'>
                <table class='table table-bordered table-striped table-sm mt-3'>
                    <thead class='table-light'>
                        <tr>
                            <th>Subject</th>
                            <th>Marks</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($marks as $mark) {
            echo "<tr>
                    <td>" . htmlspecialchars($mark['SUBJECT']) . "</td>
                    <td>" . htmlspecialchars($mark['MARKS']) . "</td>
                  </tr>";
        }
        echo "  </tbody>
                </table>
              </div>";
        echo "</div>"; // card-body
        echo "</div>"; // card
        echo "</div>"; // col
    }
} else {
    echo "<p class='text-danger'>No records found.</p>";
}

$conn->close();
?>
    </div> <!-- row -->
</div> <!-- container -->
<a href="view-marks.php" class="btn btn-success text-white text-decoration-none">Go Back</a>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
