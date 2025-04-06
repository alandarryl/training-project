<?php

require 'connect_database.php';
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

// Get user data from the database
$iduser = $_SESSION['iduser'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $_SESSION['iduser']);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}

//manage the image files

$profile_picture = empty($user['profile_picture']) ? 'default.jpg' : $user['profile_picture'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
</head>
<body>

<h1>Profile</h1>

            <div class="container">

            <div class="profile-image">
                <!-- Display the profile picture -->
                <img src="images/<?php echo $profile_picture; ?>" alt="Profile Picture" class="img-fluid rounded-circle">
            </div>

            <div class="profile-info">
                <ul>
                    <li>user id : <?php echo $user['id']; ?></li>
                    <li>username : <?php echo $user['username']; ?></li>
                    <li>email : <?php echo $user['email']; ?></li>
                    <li>address : <?php echo $user['address']; ?></li>
                    <li>city : <?php echo $user['city']; ?></li>
                    <li>gender : <?php echo $user['gender']; ?></li>
                    <li>phone number : <?php echo $user['phone']; ?></li>
                    <li>date of birth : <?php echo $user['date_of_birth']; ?></li>
                </ul>
            </div>

            </div>

</body>
</html>