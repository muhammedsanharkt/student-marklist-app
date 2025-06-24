<?php
// Optional DB connection if you need it elsewhere
$servername = "localhost";
$username = "root";
$password = "";
$database = "school";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Home | School Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    .hero {
      background: linear-gradient(to right, #007bff, #00c6ff);
      color: white;
      padding: 80px 20px;
      text-align: center;
    }
    .section-title {
      font-size: 28px;
      font-weight: bold;
      margin-top: 40px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body class="bg-light text-dark d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php">School Management</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto me-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
      </ul>
    </div>
    <a class="btn btn-success ms-auto me-1" href="login.php">Login</a>
    <a class="btn btn-warning" href="registration.php">Register</a>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h1 class="display-4">Welcome to School Management System</h1>
    <p class="lead mt-3">Easily manage student data, view performance, and control access.</p>
    <a href="login.php" class="btn btn-light btn-lg mt-3">Get Started</a>
  </div>
</section>

<!-- About Section -->
<div class="container my-5">
  <h2 class="section-title text-center">About Us</h2>
  <p class="text-center">Our system helps schools maintain and access student records with ease. Built with simplicity and power in mind, it's designed for admins and teachers to collaborate and improve academic tracking.</p>


  <!-- Contact Section -->
  <h2 class="section-title text-center">Contact Us</h2>
  <p class="text-center">For any support or questions, please contact us at <a href="mailto:support@school.com">support@school.com</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
