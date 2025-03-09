<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
session_start();

$conn = mysqli_connect("localhost", "root", "", "suspicious_web_db");

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $user_sh = "SELECT * FROM user WHERE username='" . $username . "'";
    $rs_sh = mysqli_query($conn, $user_sh);
    $num_rows = mysqli_num_rows($rs_sh);
    
    if($num_rows > 0){
        $pull_userinfo = mysqli_fetch_assoc($rs_sh);
        $pwd_ch = $pull_userinfo['password'];
            if($pwd_ch == $password){
                $id = $pull_userinfo['user_id'];
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
            die(header('location:ALL-Works.php'));
            }
            else{
            echo "<script>
                    alert('รหัสผิด!');
                    window.location = 'login.php';
                </script>";
            }
    }
    else{
        echo "<script>
                    alert('ชื่อผู้ใช้ผิด!');
                    window.location = 'login.php';
                </script>";
    }     
}
mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <div class="curved-shape"></div>
        <div class="login-form">
            <h2>Login</h2>
            <form action="" method="POST">
                <div class="input-box">
                    <input type="text" id="username" name="username" required>
                    <label for="username">Username</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="linkF">
                    <a href="#">Forgot password?</a>
                </div>
                <div class="input-box">
                    <button class="btn" type="submit">Login</button>
                </div>
                <div class="link">
                    <p>Den't have an account ?<a href="register_web.php" class="a">Sing Up</a></p>
                </div>
            </form>
        </div>
        <div class="info-content Login">
            <h2>WELCOME BACK!</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, provident.</p>
        </div>
    </div>
</body>
</html>