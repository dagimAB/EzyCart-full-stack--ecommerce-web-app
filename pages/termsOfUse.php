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
    <title>Terms of Use</title>
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

    <h1 class="termsOfUse_header">Terms of Use - EzyCart</h1>

      <div class="termsOfUse_container">
        <section class="terms-section">
            <h1>Welcome to EzyCart</h1>
            <p>By accessing or using our website, you agree to comply with and be bound by the following terms and conditions. Please read them carefully.</p>

            <h2>1. Use of the Website</h2>
            <p>You agree to use the website for lawful purposes only and in a way that does not infringe the rights of others or restrict their use and enjoyment of the website.</p>

            <h2>2. Account Responsibilities</h2>
            <p>You are responsible for maintaining the confidentiality of your account information and for all activities that occur under your account.</p>

            <h2>3. Prohibited Activities</h2>
            <ul>
                <li>Using the website for fraudulent purposes.</li>
                <li>Uploading or transmitting viruses or malicious code.</li>
                <li>Interfering with the website's functionality or security.</li>
            </ul>

            <h2>4. Intellectual Property</h2>
            <p>All content on this website, including text, graphics, logos, and images, is the property of EzyCart and protected by copyright laws. You may not reproduce or distribute any content without our written permission.</p>

            <h2>5. Limitation of Liability</h2>
            <p>EzyCart is not liable for any damages arising from the use or inability to use the website, including but not limited to direct, indirect, incidental, or consequential damages.</p>

            <h2>6. Changes to Terms</h2>
            <p>We reserve the right to update or modify these terms at any time without prior notice. Your continued use of the website constitutes acceptance of the revised terms.</p>

            <h2>Contact Us</h2>
            <p>If you have any questions about these Terms of Use, please contact us at:</p>
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