<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
          <?php
          $conn = new mysqli("localhost", "root", "", "school");
          $errorMessage = "";
          $successMessage = "";

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $username = $_POST["username"];
              $email    = $_POST["email"];
              $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

              try {
                  // Enable mysqli exceptions
                  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                  $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("sss", $username, $email, $password);
                  $stmt->execute();

                  $successMessage = "Registration successful!";
              } catch (mysqli_sql_exception $e) {
                  if (str_contains($e->getMessage(), "Duplicate entry")) {
                      if (str_contains($e->getMessage(), "username")) {
                          $errorMessage = "Username already exists. Please choose another.";
                      } elseif (str_contains($e->getMessage(), "email")) {
                          $errorMessage = "Email is already registered.";
                      } else {
                          $errorMessage = "Duplicate entry found.";
                      }
                  } else {
                      $errorMessage = "Error: Something went wrong. Please try again.";
                  }
              }
          }
          ?>

          <?php if ($errorMessage): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
          <?php endif; ?>

          <?php if ($successMessage): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
          <?php endif; ?>

          <form method="post" novalidate>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required placeholder="Enter username">
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required placeholder="Enter email">
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required placeholder="Enter password">
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

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
