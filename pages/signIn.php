<?php

  // INCLUDE functions.php
    include '../includes/functions.php';

// Initialize variables
$email = $password = '';
$error_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate email and password
    if (empty($email) || empty($password)) {
        $error_message = "All fields are required!!!.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address!!.";
    } else {
        // Check if the user exists in the database
        $sql = "SELECT id, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $email;

                // Redirect to the homepage or dashboard
                header('Location: ../index.php');
                exit();
            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            $error_message = "Invalid email or password.";
        }

        // Close the statement
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../Resources/icons-and-logo/E-logo-correct.webp" type="image/x-icon" />
    <link rel="stylesheet" href="../style/styles.css" />
    <title>Sign In</title>
    <style>
      .signin-section {
          margin-top: 65px;
        }
      .footer-wrapper {
          padding: 20px 0;
          display: flex;
          flex-direction: column;
          gap: 20px;
          height: auto;
          align-items: center;
          justify-content: center;
        }
      .container {
          padding: 0;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <section class="signin-section">
        <div class="singIn_logo_wrapper">
            <a href="../index.php">
                <img src="../Resources/icons-and-logo/EzyCart-originall-logo.jpg" alt="EzyCart Logo" />
            </a>
        </div>
        <div class="singIn_card">
            <h1>Sign in</h1>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="signIn_form">
                <form id="signInForm" action="signIn.php" method="post">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required />
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                    <span id="togglePassword" class="toggle-password">👁️</span>
                    <button type="submit">Continue</button>
                </form>
            </div>
            <p>
                By continuing, you agree to EzyCart's
                <a href="./termsOfUse.php">Conditions of Use</a> and
                <a href="./privacyPolicy.php">Privacy Notice.</a>
            </p>
        </div>

        <div class="break">
            <p>Don't have an account?</p>
        </div>
        <div class="btn">
            <a href="./signUp.php">
                <button>Create your EzyCart account</button>
            </a>
        </div>
        <br />
    </section>

    <?php include '../includes/footer.php'; ?>
    <script src="../script/signIn.js"></script>
</body>
</html>