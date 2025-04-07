<?php


require __DIR__ . '/../login and register test/connect_database.php';

session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['iduser'];


if (!$user_id) {
    echo "User not found.";
    exit();
}

// Get all products from the database
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// add product to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $image = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];
    $folder = "../login and register test/images" . $image;
    $uploaded = move_uploaded_file($temp_name, $folder);
    if ($uploaded) {
        echo "Image uploaded successfully";
    } else {
        echo "Failed to upload image";
    }
    $product_price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO products (user_id, product_name, product_description, product_image, product_price) 
                                    VALUES (:user_id, :name, :description, :image, :price)");
    // Bind parameters
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':name', $product_name);
    $stmt->bindParam(':description', $product_description);
    $stmt->bindParam(':image', $folder);
    $stmt->bindParam(':price', $product_price);
    $stmt->execute();

    
}


// display product from database
$stmt = $conn->prepare("SELECT * FROM products WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);










?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-card {
            margin-bottom: 20px;
        }
        .product-card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-5">

        <!-- Formulaire d'ajout d'un produit -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Nom du produit</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="form-group">
                <label for="description">Description du produit</label>
                <textarea class="form-control" id="product_description" name="product_description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Prix du produit</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="image">Image du produit</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le produit</button>
        </form>




        <h1 class="text-center mb-4">Ajouter un produit</h1>
        <div class="row">

        <?php
    // Display all products
foreach ($products as $product) {


    // Display the product image

    echo '<div class="col-md-4">' ;
            echo '<div class="card product-card">';
                echo '<img src=" '.$product['product_image'].'" class="card-img-top" alt="Product Image">';
                echo '<div class="card-body">';
                    echo '<h5 class="card-title">'. htmlspecialchars($product['product_name']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($product['product_description']) . '</p>';
                    echo '<p class="card-text"><strong>'. htmlspecialchars($product['product_price']) . '€</strong></p>';
                    echo '<a href="#" class="btn btn-primary">Voir plus</a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';


}
?>


            <!-- Exemple de carte produit -->
            <!-- <div class="col-md-4">
                <div class="card product-card">
                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">Nom du produit</h5>
                        <p class="card-text">Description courte du produit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <p class="card-text"><strong>Prix: 19.99€</strong></p>
                        <a href="#" class="btn btn-primary">Voir plus</a>
                    </div>
                </div>
            </div> -->
            <!-- Répétez cette structure pour d'autres produits -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>