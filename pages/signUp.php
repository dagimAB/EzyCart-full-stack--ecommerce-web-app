<?php
  // INCLUDE functions.php
    include '../includes/functions.php';

// Initialize variables
$first_name = $last_name = $phone = $email = $password = $confirm_password = $city = $dob = '';
$error_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $first_name = trim($_POST['fname']);
    $last_name = trim($_POST['lname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirmPassword']);
    $city = trim($_POST['city']);
    $dob = trim($_POST['dob']);

    // Validate form data
    if (empty($first_name) || empty($last_name) || empty($phone) || empty($email) || empty($password) || empty($confirm_password) || empty($city) || empty($dob)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } elseif (strlen($phone) !== 10 && strlen($phone) !== 13) {
        $error_message = "Phone number must be exactly 10 or 13 characters long.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $error_message = "Password must be at least 8 characters long, contain one uppercase letter, one number, and one special character.";
    } else {
        // Check if the email already exists
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Email already exists.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user into the database
            $sql = "INSERT INTO users (first_name, last_name, phone, email, password, city, date_of_birth) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssssss', $first_name, $last_name, $phone, $email, $hashed_password, $city, $dob);

            if ($stmt->execute()) {
                // Redirect to the sign-in page after successful registration
                header('Location: signIn.php');
                exit();
            } else {
                $error_message = "Something went wrong. Please try again.";
            }

            // Close the statement
            $stmt->close();
        }
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
    <title>Sign Up</title>
    <style>
        .signup-section {
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

    <section class="signup-section">
        <div class="singIn_logo_wrapper">
            <a href="../index.php">
                <img src="../Resources/icons-and-logo/EzyCart-originall-logo.jpg" alt="EzyCart Logo" />
            </a>
            </div>
        <div class="singIn_card signUpCard">
            <h1>Sign up</h1>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="signIn_form">
                <form id="registrationForm" action="signUp.php" method="post">
                    <label for="fname">First Name:</label><br />
                    <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($first_name); ?>" required /><br />
                    <label for="lname">Last Name:</label><br />
                    <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($last_name); ?>" required /><br />
                    <label for="phone">Mobile phone:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required /><br />
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required /><br />
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required /><br />
                    <span id="togglePassword" class="toggle-password">👁️</span><br>
                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required /><br />
                    <span id="togglePassword2" class="toggle-password">👁️</span><br>
                    <label for="city">City:</label><br />
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" required /><br />
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required /><br /><br />
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
            <p>Have already an account?</p>
        </div>
        <div class="btn">
            <a href="./signIn.php">
                <button>Sign In</button>
            </a>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>
    <script src="../script/signUp.js"></script>
</body>
</html>