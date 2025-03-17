<?php
  // INCLUDE functions.php
    include '../includes/functions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../Resources/icons-and-logo/E-logo-correct.webp" type="image/x-icon">
    <link rel="stylesheet" href="../style/styles.css">
    <title>Privacy Policy</title>
        <style>
      body{
        margin-top: 70px;
      }
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


    <h1 class="privacyPolicy_header">Privacy Policy - EzyCart</h1>

    <div class="privacyPolicy_container">
        <section class="policy-section">
            <h1>Our Commitment to Your Privacy</h1>
            <p>Your privacy is important to us. This Privacy Policy outlines how EzyCart collects, uses, and protects your personal information when you use our services.</p>

            <h2>Information We Collect</h2>
            <p>We may collect the following types of information:</p>
            <ul>
                <li>Personal information such as your name, email address, phone number, and shipping address.</li>
                <li>Payment details when you make purchases.</li>
                <li>Browsing behavior, preferences, and interactions with our website.</li>
            </ul>

            <h2>How We Use Your Information</h2>
            <p>Your information is used to:</p>
            <ul>
                <li>Process and fulfill your orders.</li>
                <li>Improve your shopping experience.</li>
                <li>Send promotional emails and updates (with your consent).</li>
                <li>Ensure website functionality and security.</li>
            </ul>

            <h2>How We Protect Your Information</h2>
            <p>We implement a variety of security measures to maintain the safety of your personal information, including encryption, secure servers, and access controls.</p>

            <h2>Your Rights</h2>
            <p>You have the right to:</p>
            <ul>
                <li>Access the personal information we hold about you.</li>
                <li>Request corrections to your personal information.</li>
                <li>Opt out of receiving promotional communications.</li>
                <li>Request the deletion of your personal data.</li>
            </ul>

            <h2>Contact Us</h2>
            <p>If you have any questions about this Privacy Policy, please contact us at:</p>
            <p>Email: support@ezycart.com</p>
            <p>Phone: +251-979-282367</p>
        </section>
    </div>


    
      <?php
        // including footer.php
        include_once '../includes/footer.php';
      ?>
</body>
</html>