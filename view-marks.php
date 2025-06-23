<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Mark List</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

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

// Step 1: Fetch all student records
$sql = "SELECT * FROM students_marks";
$result = $conn->query($sql);
?>


<!-- creating tables by the user -->
<?php
if (isset($_POST['submit'])) {
    $name = $_POST['student_name'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    $insert = "INSERT INTO students_marks (STUDENT_NAME, SUBJECT, MARKS)
               VALUES ('$name', '$subject', $marks)";
    
    if ($conn->query($insert) === TRUE) {
        echo "<div class='alert alert-success mt-3'>Student record added successfully!</div>";
        // Optional: refresh the page
        echo "<meta http-equiv='refresh' content='2'>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
    }
}
?>



<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Student Records</h2>

<?php
if ($result->num_rows > 0) {
    echo "<div class='table-responsive'>
            <table class='table table-bordered table-striped table-hover'>
                <thead class='table-dark'>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Subject</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["STUDENT_NAME"] . "</td>
                <td>" . $row["SUBJECT"] . "</td>
                <td>" . $row["MARKS"] . "</td>
              </tr>";
    }
    echo "    </tbody>
            </table>
          </div>";
} else {
    echo "<p class='text-danger'>No data found!</p>";
}
?>

            <div class="text-center mt-4">
                <a href="individual-student.php" class="btn btn-primary">View Individual Students</a>
            </div>
            <div>
                <!-- adding dtudent details by the user -->

<h4 class="mt-5 text-center">Add Student Marks</h4>
<form method="POST" action="" class="row g-3 mt-3">
    <div class="col-md-4">
        <label for="student_name" class="form-label">Student Name</label>
        <input type="text" class="form-control" id="student_name" name="student_name" required>
    </div>
    <div class="col-md-4">
        <label for="subject" class="form-label">Subject</label>
        <input type="text" class="form-control" id="subject" name="subject" required>
    </div>
    <div class="col-md-4">
        <label for="marks" class="form-label">Marks</label>
        <input type="number" class="form-control" id="marks" name="marks" required>
    </div>
    <div class="col-12 text-center mt-3">
        <button type="submit" name="submit" class="btn btn-success">Add Record</button>
    </div>
</form>



            </div>
        </div>
    </div>
</div>


<!-- Bootstrap 5 JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
