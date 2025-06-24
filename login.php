<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg">
        <div class="card-header bg-success text-white text-center">
          <h4>User Login</h4>
        </div>
        <div class="card-body">
          <?php
          session_start();
          $conn = new mysqli("localhost", "root", "", "school");

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $username = $_POST["username"];
              $password = $_POST["password"];

              $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
              $stmt->bind_param("s", $username);
              $stmt->execute();
              $user = $stmt->get_result()->fetch_assoc();

              if ($user && password_verify($password, $user["password"])) {
                  $_SESSION["user_id"] = $user["id"];
                  $_SESSION["username"] = $user["username"];
                  $_SESSION["role"] = $user["role"];

                  // Redirect based on role
                  if ($user["role"] === "admin") {
                      header("Location: adminpage.php");
                  } else {
                      header("Location: userhome.php");
                  }
                  exit;
              } else {
                  echo '<div class="alert alert-danger">Invalid login credentials!</div>';
              }
          }
          ?>

          <form method="post">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required placeholder="Enter username">
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-success w-100">Login</button>
          </form>
        </div>
        <div class="card-footer text-center">
          <a class="btn btn-outline-primary me-2" href="home.php">Go to Home Page</a>
          <a class="btn btn-outline-secondary" href="registration.php">Go to Registration</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
