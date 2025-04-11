<?php
include '../includes/functions.php';

// Get search parameters
$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Build SQL query
$sql = "SELECT p.* FROM products p WHERE 1=1";
$params = [];
$types = "";

if (!empty($query)) {
    $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
    $params[] = "%$query%";
    $params[] = "%$query%";
    $types .= "ss";
}

if ($category_id > 0) {
    $sql .= " AND p.category_id = ?";
    $params[] = $category_id;
    $types .= "i";
}

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Resources/icons-and-logo/E-logo-correct.webp" type="image/x-icon">
    <link rel="stylesheet" href="../style/styles.css">
    <title>Search Results</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <br><br><br>
    <div class="search-results-container">
        <h2>Search Results</h2>
        <p class="search-meta">
            <?php 
            echo !empty($query) ? "Search term: \"$query\"" : ""; 
            echo ($category_id > 0 && !empty($query)) ? " in " : "";
            echo ($category_id > 0) ? "Category: " . getCategoryName($category_id) : "";
            ?>
        </p>
        
        <div class="products_container list">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="card_container">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="description"><p><?php echo htmlspecialchars($product['description']); ?></p></div><br/>
                        <div class="price">Price: $<?php echo number_format($product['price'], 2); ?></div>
                        <form action="../api/add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="button">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-results">No products found matching your search criteria.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once '../includes/footer.php'; ?>
</body>
</html>