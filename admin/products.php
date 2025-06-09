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

    // Handle product deletion (HARD DELETE)
    if (isset($_GET['delete_id'])) {
        $product_id = (int)$_GET['delete_id'];
        
        // First get the image path so we can delete the file
        $stmt = $conn->prepare("SELECT image_url FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        // Delete the product from database
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        
        if ($stmt->execute()) {
            // If deletion was successful, delete the associated image file
            if (!empty($product['image_url'])) {
                $image_path = '../uploads/' . $product['image_url'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
            header("Location: products.php?success=Product deleted permanently");
        } else {
            header("Location: products.php?error=Failed to delete product");
        }
        exit();
    }





    
    // Pagination setup
    $items_per_page = 15;
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($current_page < 1) $current_page = 1;

    // Count total products
    $count_sql = "SELECT COUNT(*) as total FROM products";
    $count_result = $conn->query($count_sql);
    $total_items = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_items / $items_per_page);

    // Adjust current page if it's beyond total pages
    if ($current_page > $total_pages && $total_pages > 0) {
        $current_page = $total_pages;
    }

    // Calculate offset
    $offset = ($current_page - 1) * $items_per_page;

    // Fetch products with pagination
    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            ORDER BY p.created_at DESC
            LIMIT $items_per_page OFFSET $offset";
    $result = $conn->query($sql);
    $products = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Resources/icons-and-logo/E-logo-correct.webp" type="image/x-icon">
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
                        <a href="products.php?delete_id=<?= $product['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to PERMANENTLY delete this product?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php if ($current_page > 1): ?>
                <a href="products.php?page=1">&laquo; First</a>
                <a href="products.php?page=<?= $current_page - 1 ?>">&lsaquo; Prev</a>
            <?php else: ?>
                <span class="disabled">&laquo; First</span>
                <span class="disabled">&lsaquo; Prev</span>
            <?php endif; ?>

            <?php 
            // Show page numbers (limit to 5 around current page)
            $start_page = max(1, $current_page - 2);
            $end_page = min($total_pages, $current_page + 2);
            
            for ($i = $start_page; $i <= $end_page; $i++): ?>
                <?php if ($i == $current_page): ?>
                    <span class="current"><?= $i ?></span>
                <?php else: ?>
                    <a href="products.php?page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="products.php?page=<?= $current_page + 1 ?>">Next &rsaquo;</a>
                <a href="products.php?page=<?= $total_pages ?>">Last &raquo;</a>
            <?php else: ?>
                <span class="disabled">Next &rsaquo;</span>
                <span class="disabled">Last &raquo;</span>
            <?php endif; ?>
        </div>
    </div>

    <script src="./admin_script/products.js"></script>
</body>
</html>