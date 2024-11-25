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
