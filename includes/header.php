<?php
  include '../includes/functions.php';

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

    <!-- Header section starts -->
    <header>
      <nav class="header_container">
        <div class="logo_container">
          <a href="../index.php">
            <img
              src="../Resources/icons-and-logo/EzyCart-originall-logo.jpg"
              alt="amazon logo"
            />
          </a>
        </div>
        <!-- <div class="search">
          <select name="" id="">
            <option value="">All</option>
            <option value="">Electronics</option>
            <option value="">Men's Cloths</option>
            <option value="">Women's Cloths</option>
            <option value="">Jewelry</option>
            <option value="">Cars</option>
            <option value="">Kitchen Products</option>
            <option value="">Beauty Products</option>
            <option value="">Toy Items</option>
          </select>
          <input type="text" placeholder="search product" />
          <img src="../Resources/icons-and-logo/searchIcon.png" alt="">
        </div> -->



        <div class="order_container">
          <div class="delivery">
            <span>
              <img
                class="location"
                src="../Resources/icons-and-logo/locationIcon.png"
                alt="loc"
              />
            </span>
            <div>
              <p>Deliver to</p>
              <span>Ethiopia</span>
            </div>
          </div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Show logout link if user is logged in -->
                    <?php if (isAdmin()): ?>
                        <a href="../admin/dashboard.php">
                            <div>
                                <h4>Admin</h4>
                            </div>
                        </a>
                    <?php endif; ?>
                    <a href="../pages/logout.php">
                        <div>
                            <h4>Logout</h4>
                        </div>
                    </a>
                <?php else: ?>
                    <!-- Show sign-in and sign-up links if user is not logged in -->
                    <a href="../pages/signIn.php">
                        <div>
                            <h4>Sign In</h4>
                        </div>
                    </a>
                    <a href="../pages/signUp.php">
                        <div>
                            <h4>Sign Up</h4>
                        </div>
                    </a>
                <?php endif; ?>

                <a href="../pages/cart.php">
                    <div class="count_cart">
                        <span class="count"><?php echo $cart_count; ?></span>
                        <img class="cart" src="../Resources/icons-and-logo/cart-icon-svg111.svg" alt="cart icon" />
                    </div>
                </a>
        </div>

        <div class="header_drop_down">
          <img src="../Resources/icons-and-logo/menu.png" alt="">
        </div>
      </nav>
      <div class="hidden-content">
          <?php if(isset($_SESSION['user_id'])): ?>
          <a href="../pages/logout.php">Log out</a>
          <?php else: ?>
          <a href="../pages/signIn.php">Sign In</a>
          <a href="../pages/signUp.php">Sign Up</a>
          <?php endif; ?>
      </div>
    </header>
    <!-- Header section ends -->