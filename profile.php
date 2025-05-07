<?php 

session_start();
include("php/config.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleLogin.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <title>Profile | online store</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Logo</p>
        </div>

        <div class="right-links">
            <?php
            $email = $_SESSION['email'];
            $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");

            while($result = mysqli_fetch_assoc($query)){
                $_SESSION['username'] = $result['username'];
                $_SESSION['email'] = $result['email'];
                $_SESSION['password'] = $result['pass'];
                $_SESSION['id'] = $result['id'];
            }

            echo "<a href='editProfile.php'>Change Profile</a>";
            ?>
            <!-- <a href="editProfile.php">Change Profile</a> -->
            <a href="php/logout.php"> <button class="btn">Log out</button> </a>
        </div>
    </div>

    <main>
        <div class="main-box">
            <div class="top">
                <div class="box" style="margin: 10px;">
                    <p>Hello <b><?php echo $_SESSION['username'];?></b>, Welcome</p>
                </div>
                <div class="box" style="margin: 10px;">
                    <p>Your Email is <b><?php echo $_SESSION['email'];?></b>, Welcome</p>
                </div>
            </div>
        </div>
    </main>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>