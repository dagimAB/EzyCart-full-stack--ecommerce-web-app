<?php
    try {
        include '../includes/functions.php';
    } catch (Exception $e) {
        // Log the error and display a user-friendly message
        error_log($e->getMessage());
        echo "An error occurred. Please try again later.";
        exit;
    }


// Fetch products from the database
$sql = "SELECT * FROM products WHERE category_id = (SELECT id FROM categories WHERE name = 'Men Clothing')";
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Resources/icons-and-logo/E-logo-correct.webp" type="image/x-icon">
    <link rel="stylesheet" href="../style/styles.css">
    <title>Men's-clothing</title>
</head>
<body>
      <?php
        // including header.php
        include '../includes/header.php';
      ?>


        <div class="products_container list">
            <?php foreach ($products as $product): ?>
                <div class="card_container">
                    <img src="<?php echo $product['image_url']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <div class="description"><p><?php echo $product['description']; ?></p></div><br/>
                    <div class="price">Price: $<?php echo $product['price']; ?></div>
                    <form action="../api/add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" class="button">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

    
      <?php
        // including footer.php
        include_once '../includes/footer.php';
      ?>
    <script src="../script/dropDownButton.js"></script>
</body>
</html>