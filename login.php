<?php
include 'config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input fields
    if (empty($email) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Check if the user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Create session and redirect to dashboard
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Invalid credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <!-- Add FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if (isset($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>
        <form action="login.php" method="POST" class="form">
            <!-- Email Input with Icon -->
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            
            <!-- Password Input with Icon -->
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
        <p class="redirect">Don't have an account? <a href="signup.php">Sign up here</a></p>
        <?php if (isset($_GET['signup_success'])) { echo "<p class='success-message'>Account created successfully! Please log in.</p>"; } ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
