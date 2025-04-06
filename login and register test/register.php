<?php

// include the database connection file
require 'connect_database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
}

// Validate the form data
if (empty($username) || empty($email) || empty($dob) || empty($phone) || empty($address) || empty($city) || empty($gender) || empty($password) || empty($confirm_password)) {
    echo "All fields are required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format";
} elseif ($password!== $confirm_password) {
    echo "Passwords do not match";
} elseif (strlen($password) < 8) {
    echo "Password should be at least 8 characters long";
} 

if(isset($_POST['submit'])){
    $file_name = $_FILES['profile_picture']['name'];
    $temp_name = $_FILES['profile_picture']['tmp_name'];
    $folder = "./images/".$file_name;
    $uploded = move_uploaded_file($temp_name, $folder.$file_name);

    if($uploaded){
        echo "Image uploaded successfully";
    } else {
        echo "Failed to upload image";
    }

}


    // hash the password
    $password = password_hash($password, PASSWORD_BCRYPT);


    // check if the email already exists in the database    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
        echo "Email already exists";
    } else {
        echo "Email is available";
    }


    //fill the table user information using pdo
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, dob, phone, address, city, gender, password, profile_picture) VALUES (:username, :email, :dob, :phone, :address, :city, :gender, :password, :profile_picture)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':profile_picture', $file_name);
        $stmt->execute();
        echo "Registration successful";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
    <h1>register form</h1>

    <form action="" method="post" enctype="multipart/form-data" accept="image/*"> >
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <div class="form-group">
            <label for="gender-status">your gender</label>
            <select class="form-control" id="gender-status" name="gender-status" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="form-groupe">
            <label for="profile_picture"></label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="login.php" class="btn btn-secondary">Login</a>
    </form>
    <br>
</div>



</body>
</html>