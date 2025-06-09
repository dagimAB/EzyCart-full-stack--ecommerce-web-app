<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
redirectIfNotAdmin();

// Initialize variables
$error = $success = '';
$product = [];
$categories = [];

// Fetch product data when ID is provided
if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if (!$product) {
        header("Location: products.php?error=Product not found");
        exit();
    }
}

// Fetch categories for dropdown
$category_result = $conn->query("SELECT * FROM categories");
while ($row = $category_result->fetch_assoc()) {
    $categories[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    try {
        // Validate inputs
        $required = ['name', 'description', 'price', 'stock_quantity', 'category_id'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("All fields marked with * are required");
            }
        }

        $product_id = (int)$_POST['product_id'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = (float)$_POST['price'];
        $stock = (int)$_POST['stock_quantity'];
        $category_id = (int)$_POST['category_id'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        // Handle image upload
        $image_url = $product['image_url'] ?? '';
        if (!empty($_FILES['image']['name'])) {
            $upload_dir = '../Resources/images/';
            $file_name = basename($_FILES['image']['name']);
            $target_path = $upload_dir . $file_name;
            $imageFileType = strtolower(pathinfo($target_path, PATHINFO_EXTENSION));

            // Validate image
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'avif'];
            if (!in_array($imageFileType, $allowed_types)) {
                throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed");
            }
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $image_url = $upload_dir . $file_name;
            } else {
                throw new Exception("Failed to upload image");
            }
        }

        // Update product in database
        $stmt = $conn->prepare("UPDATE products SET 
            name = ?,
            description = ?,
            price = ?,
            stock_quantity = ?,
            category_id = ?,
            image_url = ?,
            is_active = ?
            WHERE id = ?");

        $stmt->bind_param("ssdiissi", 
            $name,
            $description,
            $price,
            $stock,
            $category_id,
            $image_url,
            $is_active,
            $product_id
        );

        if (!$stmt->execute()) {
            throw new Exception("Error updating product: " . $stmt->error);
        }

        header("Location: products.php?success=Product updated successfully");
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="./admin_styles/products.css">
</head>
<body>
    <?php include './admin_header.php'; ?>

    <div class="container">
        <div class="header">
            <h1>Edit Product</h1>
            <a href="products.php" class="btn btn-primary">Back to Products</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="edit_product.php" method="POST" enctype="multipart/form-data" class="product-form">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?? '' ?>">

            <div class="form-group">
                <label for="name">Product Name *</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($product['name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea name="description" required rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price ($) *</label>
                    <input type="number" step="0.01" name="price" required value="<?= $product['price'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="stock_quantity">Stock Quantity *</label>
                    <input type="number" name="stock_quantity" required value="<?= $product['stock_quantity'] ?? '' ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select name="category_id" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" 
                                <?= ($category['id'] == ($product['category_id'] ?? '')) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <div class="status-toggle">
                        <input type="checkbox" name="is_active" id="is_active" 
                            <?= ($product['is_active'] ?? 0) ? 'checked' : '' ?>>
                        <label for="is_active" class="toggle-label"></label>
                        <span><?= ($product['is_active'] ?? 0) ? 'Active' : 'Inactive' ?></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" name="image" accept="image/*">
                <?php if (!empty($product['image_url'])): ?>
                    <div class="current-image">
                        <img src="../uploads/<?= $product['image_url'] ?>" alt="Current Image" style="max-width: 200px; margin-top: 10px;">
                        <p>Current Image: <?= $product['image_url'] ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" name="update_product" class="btn btn-save">Update Product</button>
        </form>
    </div>
</body>
</html>