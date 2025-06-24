<?php
$conn = new mysqli("localhost", "root", "", "school");
$errorMessage = "";
$successMessage = "";

// Prevent resubmission using PRG (Post/Redirect/Get)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $passwordInput = $_POST["password"];

    if (empty($username) || empty($email) || empty($passwordInput)) {
        $errorMessage = "All fields are required.";
    } else {
        $password = password_hash($passwordInput, PASSWORD_BCRYPT);
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $password);
            $stmt->execute();

            // Set session flash message and redirect
            session_start();
            $_SESSION["successMessage"] = "Registration successful!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } catch (mysqli_sql_exception $e) {
            if (str_contains($e->getMessage(), "Duplicate entry")) {
                if (str_contains($e->getMessage(), "username")) {
                    $errorMessage = "Username already exists.";
                } elseif (str_contains($e->getMessage(), "email")) {
                    $errorMessage = "Email is already registered.";
                } else {
                    $errorMessage = "Duplicate entry found.";
                }
            } else {
                $errorMessage = "Something went wrong. Please try again.";
            }
        }
    }
}

// Retrieve flash message
session_start();
if (isset($_SESSION["successMessage"])) {
    $successMessage = $_SESSION["successMessage"];
    unset($_SESSION["successMessage"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .fade-out {
      transition: opacity 1s ease-out;
    }
  </style>
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
          <h4>User Registration</h4>
        </div>
        <div class="card-body">

          <?php if ($errorMessage): ?>
            <div class="alert alert-danger fade-out" id="alertBox"><?php echo $errorMessage; ?></div>
          <?php endif; ?>
          <?php if ($successMessage): ?>
            <div class="alert alert-success fade-out" id="alertBox"><?php echo $successMessage; ?></div>
          <?php endif; ?>

          <form method="post" class="needs-validation" novalidate>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required placeholder="Enter username">
              <div class="invalid-feedback">Please enter a username.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required placeholder="Enter email">
              <div class="invalid-feedback">Please enter a valid email.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required placeholder="Enter password">
              <div class="invalid-feedback">Please enter a password.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
          </form>
        </div>
        <div class="card-footer text-center">
          <a class="btn btn-success" href="login.php">Go to Login Page</a>
          <a class="btn btn-secondary" href="home.php">Go to Home Page</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for fade out and validation -->
<script>
  // Bootstrap validation
  (function () {
    'use strict';
    document.querySelectorAll('.needs-validation').forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();

  // Auto fade out alert
  window.onload = function () {
    const alertBox = document.getElementById("alertBox");
    if (alertBox) {
      setTimeout(() => {
        alertBox.style.opacity = '0';
      }, 4000); // Fade after 4 seconds
    }
  };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
