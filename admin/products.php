<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
redirectIfNotAdmin();

// Handle product status toggle
if (isset($_GET['toggle_status'])) {
    $product_id = (int)$_GET['toggle_status'];
    $stmt = $conn->prepare("UPDATE products SET is_active = NOT is_active WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    header("Location: products.php");
    exit();
}

// Handle product deletion (soft delete)
if (isset($_GET['delete_id'])) {
    $product_id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("UPDATE products SET is_active = FALSE WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    header("Location: products.php?success=Product deactivated");
    exit();
}

// Fetch all active products with category info
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.is_active = TRUE
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="./admin_styles/products.css">
</head>
<body>
    <?php include './admin_header.php'; ?>
    
    <div class="container">
        <div class="header">
            <h1>Product Management</h1>
            <a href="add_product.php" class="btn btn-primary">Add New Product</a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>

        <div class="product-filters">
            <input type="text" id="search-input" placeholder="Search products...">
            <select id="category-filter">
                <option value="">All Categories</option>
                <?php
                $categories = $conn->query("SELECT * FROM categories");
                while ($cat = $categories->fetch_assoc()): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr data-id="<?= $product['id'] ?>" data-category="<?= $product['category_id'] ?>">
                    <td><?= $product['id'] ?></td>
                    <td>
                        <?php if ($product['image_url']): ?>
                        <img src="../uploads/<?= $product['image_url'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                        <?php else: ?>
                        <div class="no-image">No Image</div>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td>$<?= number_format($product['price'], 2) ?></td>
                    <td class="<?= $product['stock_quantity'] <= 5 ? 'low-stock' : '' ?>">
                        <?= $product['stock_quantity'] ?>
                    </td>
                    <td><?= $product['category_name'] ? htmlspecialchars($product['category_name']) : 'Uncategorized' ?></td>
                    <td>
                        <span class="status-badge <?= $product['is_active'] ? 'active' : 'inactive' ?>">
                            <?= $product['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td class="actions">
                        <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-edit">Edit</a>
                        <a href="products.php?toggle_status=<?= $product['id'] ?>" class="btn btn-status">
                            <?= $product['is_active'] ? 'Deactivate' : 'Activate' ?>
                        </a>
                        <a href="products.php?delete_id=<?= $product['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <script src="./admin_script/products.js"></script>
</body>
</html>