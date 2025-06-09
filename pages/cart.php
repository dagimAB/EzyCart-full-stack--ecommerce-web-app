<?php
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: signIn.php");
    exit();
}

// Fetch cart items for the current user
$user_id = getUserId();
$sql = "SELECT p.id, p.name, p.price, p.image_url, c.quantity 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="../Resources/icons-and-logo/E-logo-correct.webp"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="../style/styles.css" />
    <title>Cart</title>
    <style>
      .footer-wrapper{
        padding: 20px 0;
        display: flex;
        flex-direction: column;
        gap: 20px;
        height: auto;
        align-items: center;
        justify-content: center;
      }
      .container{
        padding:  0;
      }
    </style>
  </head>
  <body>
      <?php
        // including header.php
        include '../includes/header.php';
      ?>

    <article class="cart_article">
        <div class="purchased_product_title">
          <h1>Your Cart</h1>
        </div>
        <br />
    
        <div class="products_container listCard">
            <?php if (empty($cart_items)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="card_container">
                        <img src="<?php echo $item['image_url']; ?>" width="50">
                        <h3><?php echo $item['name']; ?></h3>
                        <div class="price">Price: $<?php echo $item['price']; ?></div>
                        <div class="quantity">Quantity: <?php echo $item['quantity']; ?></div><br>
                        <form action="../api/remove_from_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <button class="remove_cart" type="submit">Remove</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="checkout">
          <div class="total">Total Price: $<?php echo $total; ?></div>
        </div>
        <form action="../api/clear_cart.php" method="POST">
          <div class="clear_cart_button">
            <button id="clearCart" type="submit">Clear Cart</button>
          </div>
        </form>


    </article>



    <div class="form">
      <form action="../api/place_order.php" method="POST">
        <div class="cart_form_div">
          <fieldset>
            <legend>Personal Details</legend>
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
            
            <label for="fname">First Name:</label><br />
            <input type="text" name="first_name" required /><br />
            
            <label for="lname">Last Name:</label><br />
            <input type="text" name="last_name" required /><br />
            
            <label for="phone">Phone Number:</label><br />
            <input type="tel" name="phone" required /><br />
            
            <label for="email">Email:</label><br />
            <input type="email" name="email" required /><br />
            
            <label for="city">City:</label><br />
            <input type="text" name="city" required />
            <br>
            
            <label for="pmethod">Payment Method:</label> 
            <span>TeleBirr</span>
            <input name="payment_method" type="radio" value="TeleBirr" required />
            <span>M-PESA</span>
            <input name="payment_method" type="radio" value="M-PESA" />
            <span>Bank</span>
            <input name="payment_method" type="radio" value="Bank" />
            
            <br /><br />

            <div class="reset_submit">
              <button class="submit" type="submit">Place Order</button>
              <button class="reset" type="reset">Reset</button>
            </div>
          </fieldset>
        </div>
      </form>
    </div>

      <?php
        // including footer.php
        include_once '../includes/footer.php';
      ?>
    <script src="../script/cart.js"></script>
  </body>
</html>
