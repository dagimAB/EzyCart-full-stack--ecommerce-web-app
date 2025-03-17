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
    <title>About-us</title>
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


    <h1 class="aboutUs_header">About Us - EzyCart</h1>

    <div class=" aboutUs_container">
        <section class="about-section">
            <h1>Welcome to EzyCart</h1>
            <p>EzyCart is your one-stop online shopping destination, offering convenience, variety, and value. Our mission is to revolutionize the shopping experience with cutting-edge technology and unparalleled customer service.</p>
          </section>
          
        <section class="mission-vision">
            <div class="card">
                <h2>Our Mission</h2>
                <p>To make online shopping seamless, accessible, and enjoyable for everyone, everywhere in Ethiopia.</p>
            </div>

            <div class="card">
                <h2>Our Vision</h2>
                <p>To be the most trusted and innovative e-commerce platform, empowering customers worldwide.</p>
            </div>
        </section>

        <section class="team-section">
            <h2>Meet Our Team</h2>
            <div class="team">
                <div class="team-member">
                    <h3>Dagim Abraham</h3>
                    <p>Founder & CEO</p>
                </div>
                <div class="team-member">
                    <h3>Dagim Tadese</h3>
                    <p>Head of Operations</p>
                </div>
                <div class="team-member">
                    <h3>Biniam Cheru</h3>
                    <p>Lead Developer</p>
                </div>
                
                <div class="team-member">
                    <h3>Bitsuan Abate</h3>
                    <p>Developer</p>
                </div>
            </div>
        </section>
    </div>

      <?php
        // including footer.php
        include_once '../includes/footer.php';
      ?>
</body>
</html>