<?php

require 'connect_database.php';

if(isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer et exécuter la requête SQL
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Check if a user was found
    if($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère les données de l'utilisateur
        if (password_verify($password, $user['password'])) {
            // Mot de passe correct, démarrez la session
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['iduser'] = $user['id']; // Assurez-vous que la colonne `id` existe
            $_SESSION['email'] = $user['email'];
            // header("Location: profile.php");
            // exit();
            echo $_SESSION['iduser'];
            echo $_SESSION['email'];
        } else {
            // Mot de passe incorrect
            echo "<div class='alert alert-danger'>Invalid email or password.</div>";
        }
    } else {
        // Utilisateur non trouvé
        echo "<div class='alert alert-danger'>Invalid email or password.</div>";
    }
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