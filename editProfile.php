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
    <title>Edit Profile | online store</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="profile.php">Logo</a></p>
        </div>

        <div class="right-links">
            <a href="">Change Profile</a>
            <a href="php/logout.php"> <button class="btn">Log out</button> </a>
        </div>
    </div>

    <div class="container">
        <div class="box form-box">
        <?php
        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            // $email = $_POST['email'];
            // $password = $_POST['password'];
            $id = $_SESSION['id'];
            $edit_query = mysqli_query($conn,"UPDATE users set username = '{$username}' WHERE id = '{$id}' ");
            if($edit_query){
                echo "  <div class='message'>
                    <p>Ok Updated your data successfully!</p>
                    </div> <br>";
                    echo "<a href='profile.php'><button class='btn'>Go To ProFile</button></a>";
            }else{
                echo "<div class='message'>
                        <p>Wrong in Update your data!</p>
                        </div> <br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
            }
        }
        else{
            
            $email = $_SESSION['email'];
            $query = mysqli_query($conn , "SELECT * FROM users WHERE email = '{$email}' ");

            while($result = mysqli_fetch_assoc($query)){
                $_SESSION['username'] = $result['username'];
                // $_SESSION['email'] = $result['email'];
                // $_SESSION['password'] = $result['pass'];
            }
        ?>
            <header>Change Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" autocomplete="off" id="username" value="<?php echo $_SESSION['username']; ?>" required>
                </div>
<!-- 
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" autocomplete="off" id="email" value="<?php echo $_SESSION['email']; ?>" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" autocomplete="off" id="password" value="<?php echo $_SESSION['password']; ?>" required>
                </div> -->

                <div class="field ">
                    <input type="submit" class="btn" name="submit" value="Update">
                </div>

            </form>
        </div>
        <?php } ?>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>