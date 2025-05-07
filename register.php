<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleLogin.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <title>Register | online store</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <?php
            include("php/config.php");
            if (isset($_POST['submit'])) {
                $username = trim($_POST['username']);
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);

                if(!empty($username) && !empty($email) && !empty($password)){
                    // verify password
                    if(strlen($password) < 6){
                        echo "<div class='message'>
                        <p>length password must be a bigger than 6</p>
                        </div> <br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
                    }
                    else{
                    // verify email 
                        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                            $verify_query = mysqli_query($conn, "SELECT email  FROM users WHERE email = '{$email}'");

                            if (mysqli_num_rows($verify_query) != 0) {
                                echo "<div class='message'>
                                <p>This email is used, Try another One please!</p>
                                </div> <br>";
                                echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
                            }
                            else {
                                $insert = mysqli_query($conn, "INSERT INTO users(username,email,pass) VALUES('{$username}','{$email}','{$password}')");

                                if ($insert) {
                                    echo "  <div class='message'>
                                        <p>Registration successfully!</p>
                                        </div> <br>";
                                    echo "<a href='login.php'><button class='btn'>Login Now</button></a>";
                                } else {
                                    echo "Can't register - Error occurred";
                                }
                            }
                        }
                        else{
                            echo "<div class='message'>
                                <p>enter valid email address!</p>
                            </div> <br>";
                            echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
                        }
                    }
                }
                else{
                    echo "<div class='message'>
                        <p>All input fields are required!</p>
                        </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
                }                    
            }
            else{
            ?>


            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" autocomplete="off" id="username" required>
                </div>

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
                    Already a member ? <a href="login.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php }?>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>