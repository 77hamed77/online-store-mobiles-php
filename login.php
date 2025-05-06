<?php
session_start();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleLogin.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <title>login | online store</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

        <?php
        include("php/config.php");
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['pass']);

        if(isset($_POST['submit'])){

            if(!empty($email) && !empty($password)){
                // verify email 
                if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' and pass = '{$password}'");
                    if (mysqli_num_rows($check_user) > 0) {
                        $row = mysqli_fetch_assoc($check_user);
    
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['email'] = $row['email'];
    
                        echo "<div>
                        <p>Login Success!</p>
                        </div> <br>";
                        echo "<a href='profile.php'><button class='btn'>Go To Profile</button></a>";
                    }
                    else {
                        echo "<div>
                        <p>Email or Password is Incorrect!</p>
                        </div> <br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
                    }
                    
                }
                else{
                    echo "<div>
                    <p>enter valid email address!</p>
                    </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
                }
            }
            else{
                echo "<div>
                    <p>All input fields are required!</p>
                    </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
            }

        }
        else{
        ?> 
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" autocomplete="off" id="email" required>
                </div>
                
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" autocomplete="off" id="password" required>
                </div>

                <div class="field ">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>

                <div class="links">
                    Don't have account ? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>


    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>