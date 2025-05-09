<?php
    // index.php
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (file_exists('./includes/config.php')) {
        require_once('./includes/config.php');
    } else {
        die('Config file not found!');
    }

    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    function isAdmin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }

    function redirectIfNotAdmin() {
        if (!isAdmin()) {
            header("Location: ../index.php");
            exit();
        }
    }

    // Get cart count
    $cart_count = 0;
    if (isLoggedIn()) {
        $user_id = getUserId();
        $sql = "SELECT SUM(quantity) AS total FROM cart WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart_count = $result->fetch_assoc()['total'] ?? 0;
    }


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="./Resources/icons-and-logo/E-logo-correct.webp"
      type="image/x-icon"
    />

    <!-- link to css -->
    <link rel="stylesheet" href="./style/styles.css" />

    <title>EzyCart</title>
  </head>
  <body>
<!-- Header section starts -->
    <header>
        <nav class="header_container">
            <div class="logo_container">
                <a href="./index.php">
                    <img src="./Resources/icons-and-logo/EzyCart-originall-logo.jpg" alt="EzyCart logo" />
                </a>
            </div>
            <div class="search">
                <form id="searchForm" action="./pages/searchResults.php" method="GET">
                    <select name="category" id="categorySelect" onchange="redirectToCategory()">
                        <option value="0">All</option>
                        <?php
                        // Fetch categories from database
                        $sql = "SELECT id, name FROM categories";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}' data-category-id='{$row['id']}'>{$row['name']}</option>";
                        }
                        ?>
                    </select>
                    <!-- <input type="hidden" id="selectedCategoryId" name="category_id" value=""> -->
                    <input type="text" name="query" placeholder="Search products..." />
                    <button type="submit"><img src="./Resources/icons-and-logo/searchIcon.png" alt="search icon"></button>
                </form>
            </div>
            <div class="order_container">
                <div class="delivery">
                    <span>
                        <img class="location" src="./Resources/icons-and-logo/locationIcon.png" alt="location icon" />
                    </span>
                    <div>
                        <p>Deliver to</p>
                        <span>Ethiopia</span>
                    </div>
                </div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Show logout link if user is logged in -->
                    <?php if (isAdmin()): ?>
                        <a href="./admin/dashboard.php">
                            <div>
                                <h4>Admin</h4>
                            </div>
                        </a>
                    <?php endif; ?>
                    <a href="./pages/logout.php">
                        <div>
                            <h4>Logout</h4>
                        </div>
                    </a>
                <?php else: ?>
                    <!-- Show sign-in and sign-up links if user is not logged in -->
                    <a href="./pages/signIn.php">
                        <div>
                            <h4>Sign In</h4>
                        </div>
                    </a>
                    <a href="./pages/signUp.php">
                        <div>
                            <h4>Sign Up</h4>
                        </div>
                    </a>
                <?php endif; ?>
                <a href="./pages/cart.php">
                    <div class="count_cart">
                        <span class="count"><?php echo $cart_count; ?></span>
                        <img class="cart" src="./Resources/icons-and-logo/cart-icon-svg111.svg" alt="cart icon" />
                    </div>
                </a>
            </div>
            <div class="header_drop_down">
                <img src="./Resources/icons-and-logo/menu.png" alt="menu icon">
            </div>
            <div class="hidden-content">
                <?php if(isset($_SESSION['user_id'])): ?>
                <a href="./pages/logout.php">Log Out</a>
                <?php else: ?>
                <a href="./pages/signIn.php">Sign In</a>
                <a href="./pages/signUp.php">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
<!-- Header section ends -->

    <!-- first main section(image slider) starts -->
    <section>
      <div class="header_image_slider">
        <div class="image_slider">
          <div class="slider_control_left">
            <img src="./Resources/icons-and-logo/Arrows-Left-Round-icon.png" alt="">
          </div>
          <div class="slider_control_right">
            <img src="./Resources/icons-and-logo/Arrows-right-Round-icon.png" alt="">
          </div>
          <ul>
            <img
              class="headerImg"
              src="./Resources/images/header-background-image.jpg"
              alt=""
            />
            <img
              class="headerImg"
              src="./Resources/images/besutyProducts.jpg"
              alt=""
            />
            <img
              class="headerImg"
              src="./Resources/images/gamingStore.jpg"
              alt=""
            />
            <img
              class="headerImg"
              src="./Resources/images/shopBooks.jpg"
              alt=""
            />
            <img
              class="headerImg"
              src="./Resources/images/kitchenFavorite.jpg"
              alt=""
            />
            <img
              class="headerImg"
              src="./Resources/images/fitness-background-image.jpg"
              alt=""
            />
            <img
              class="headerImg"
              src="./Resources/images/newArrival.jpg"
              alt=""
            />
            <img
              class="headerImg"
              src="./Resources/images/besutyProducts.jpg"
              alt=""
            />
            <img
              class="headerImg"
              src="./Resources/images/toy-background-image.jpg"
              alt=""
            />
          </ul>
        </div>
      </div>
    </section>
    <!-- first main section(image slider) ends -->

    <!-- second main-section(category) starts -->
    <section class="category_section">
      <div class="category_container">
        <!-- first category -->
        <div class="category">
          <a href="./pages/electronics.php">
            <span>
              <h3>Electronics</h3>
            </span>
            <img src="./Resources/images/electronics.avif" alt="electronics" />
            <p>shop now</p>
          </a>
        </div>
        <!-- second category -->
        <div class="category">
          <a href="./pages/mensClothing.php">
            <span>
              <h3>Men's Clothing</h3>
            </span>
            <img
              src="./Resources/images/mensClothing.avif"
              alt="mensClothing"
            />
            <p>shop now</p>
          </a>
        </div>
        <!-- third category -->
        <div class="category">
          <a href="./pages/womensClothing.php">
            <span>
              <h3>Women's Clothing</h3>
            </span>
            <img
              src="./Resources/images/womensClothing.avif"
              alt="womensClothing"
            />
            <p>shop now</p>
          </a>
        </div>
        <!-- fourth category -->
        <div class="category">
          <a href="./pages/jewelry.php">
            <span>
              <h3>Jewelry</h3>
            </span>
            <img src="./Resources/images/jewelery.avif" alt="jewelry" />
            <p>shop now</p>
          </a>
        </div>
        <!-- fifth category -->
        <div class="category">
          <a href="./pages/cars.php">
            <span>
              <h3>Cars</h3>
            </span>
            <img src="./Resources/images/futuristic-car.avif" alt="cars" />
            <p>shop now</p>
          </a>
        </div>
        <!-- sixth category -->
        <div class="category">
          <a href="./pages/kitchenProducts.php">
            <span>
              <h3>Kitchen Products</h3>
            </span>
            <img
              src="./Resources/images/kitchenProduct.jpg"
              alt="kitchen product"
            />
            <p>shop now</p>
          </a>
        </div>
        <!-- seventh category -->
        <div class="category">
          <a href="./pages/beautyProducts.php">
            <span>
              <h3>Beauty Salon Products</h3>
            </span>
            <img
              src="./Resources/images/beauty-product.avif"
              alt="beauty products"
            />
            <p>shop now</p>
          </a>
        </div>
        <!-- eighth category -->
        <div class="category">
          <a href="./pages/toys.php">
            <span>
              <h3>Toy Items</h3>
            </span>
            <img src="./Resources/images/toy-items.avif" alt="toys" />
            <p>shop now</p>
          </a>
        </div>
      </div>
    </section>
    <!-- second main-section(category) ends -->

    <!-- third main-section(products) starts -->
    <section>
      <div class="products_container list">
      </div>
    </section>
    <!-- third main-section(products) ends -->

    <!-- fourth main-section(product slider) starts -->
    <section>
      <div class="product_slider_wrapper">
        <div class="product_slider">
          <h2>Movies To Watch</h2><br>
          <a href="./pages/movies.php">
            <div class="products">
              <img src="./Resources/images/1book-24.jpg" alt="books" />
              <img src="./Resources/images/1movie-teriffier.jpg" alt="movie" />
              <img src="./Resources/images/1movie-2.jpg" alt="movie" />
              <img src="./Resources/images/1movie-4.jpg" alt="movie" />
              <img src="./Resources/images/1movie-5.jpg" alt="movie" />
              <img src="./Resources/images/1movie-6.jpg" alt="movie" />
              <img src="./Resources/images/1movie-7.jpg " alt="movie" />
              <img src="./Resources/images/1movie-8.jpg " alt="movie" />
              <img src="./Resources/images/1movie-9.jpg " alt="movie" />
              <img src="./Resources/images/1movie-10 (2).jpg" alt="movie" />
              <img src="./Resources/images/1movie-15.jpg" alt="movie" />
              <img src="./Resources/images/1movie-16.jpg" alt="movie" />
              <img src="./Resources/images/1movie-14.jpg" alt="movie" />
              <img src="./Resources/images/1movie-17.jpg" alt="movie" />
            </div>
          </a>
        </div>
      </div>
      
      <div class="product_slider_wrapper">
        <div class="product_slider ps_second">
          <h2>Books To Read</h2><br>
          <a href="./pages/books.php">
            <div class="products">
              <img src="./Resources/images/1book-15.jpg" alt="books" />
              <img src="./Resources/images/1book-21.jpg" alt="books" />
              <img src="./Resources/images/1book-26.jpg" alt="books" />
              <img src="./Resources/images/1book2.jpg" alt="books" />
              <img src="./Resources/images/1book5.jpg" alt="books" />
              <img src="./Resources/images/1book6.jpg" alt="books" />
              <img src="./Resources/images/1book7.jpg" alt="books" />
              <img src="./Resources/images/1book8.jpg" alt="books" />
              <img src="./Resources/images/1book9.jpg" alt="books" />
              <img src="./Resources/images/1book10.jpg" alt="books" />
              <img src="./Resources/images/1book11.jpg" alt="books" />
              <img src="./Resources/images/1book13.jpg" alt="books" />
              <img src="./Resources/images/1book-14.jpg" alt="books" />
            </div>
          </a>
        </div>
      </div>
    </section>
    <!-- fourth main-section(product slider) ends -->

    <!-- footer section starts -->
    <footer class="footer-wrapper">
      <div class="container">
            <h1>Company</h1>
            <br>
            <ul>
              <li><a href="./pages/aboutUs.php">About Us</a></li>
              <li><a href="./pages/privacyPolicy.php">Privacy Policy</a></li>
              <li><a href="./pages/termsOfUse.php">Terms of Use</a></li>
            </ul>
        </div>

        <div class="copyright-wrapper">
            Copyright &copy; 2024 EzyCart. All rights reserved.
            <div class="flag-wrapper">
              <img src="./Resources/icons-and-logo/ethiopianFlagIcon.png" />
            </div>
            <div class="footer-country-name">Ethiopia.</div>
        </div>
      </div>
    </footer>
    <!-- footer section ends -->

    <script src="./script/index.js"></script>
  </body>
</html>