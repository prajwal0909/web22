<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validate fields (optional but highly recommended)
    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Hash the password before storing
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username or email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $error_message = "Username or Email already exists.";
        } else {
            // Insert new user into the database
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $password_hash])) {
                // Redirect to login page after successful sign-up
                header("Location: login.php?signup_success=true");
                exit();
            } else {
                $error_message = "Error creating account, please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <!-- Add FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h2>Create an Account</h2>
        <?php if (isset($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>
        <form action="signup.php" method="POST" class="form">
            <!-- Username Input with Icon -->
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            
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
            
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <p class="redirect">Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script src="script.js"></script>
</body>
</html>
