<?php

require 'connect_database.php';

if(isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    // Check if a user was found
    if($stmt->rowCount() > 0) {
        // User found, redirect to profile page
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['iduser'] = $stmt->fetchColumn();
        $_SESSION['email'] = $email;
        header("Location: profile.php");
        exit();
    } else {
        // User not found, show error message
        echo "<div class='alert alert-danger'>Invalid email or password.</div>";
    }
} else {
    // If the form is not submitted, show the login form
    echo "<div class='alert alert-info'>Please enter your email and password to login.</div>";
}








?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Login page</title>
</head>
<body>

<div class="container">
    <h1>Login form</h1>

    <form action="login.php" method="post">
        <div class="form-group">
            <label for="email">email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="register.php" class="btn btn-secondary">Register</a>
    </form>
    <br>
</div>



</body>
</html>