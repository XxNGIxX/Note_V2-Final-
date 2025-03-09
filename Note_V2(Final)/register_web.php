<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name =  $_POST["username"];
    $email =  $_POST["email"];
    $pwd =  $_POST["password"];
    $con_pwd =  $_POST["con_password"];
    $conn = mysqli_connect("localhost", "root", "", "suspicious_web_db");
     
    $user_sql = "SELECT email FROM user WHERE email='" . $email . "'";
    $rs_user = mysqli_query($conn, $user_sql);
    $user_num_rows = mysqli_num_rows($rs_user);
    if ($user_num_rows  > 0) {
        echo "<script>
                alert('อีเมลนี้ถูกใช้ไปแล้ว กรุณาใช้อีเมลอื่น!');
                window.location = 'register_web.php';
              </script>";
        die();
    } 

    $user_sql = "SELECT email FROM user WHERE username='" . $user_name . "'";
    $rs_user = mysqli_query($conn, $user_sql);
    $user_num_rows = mysqli_num_rows($rs_user);
    if ($user_num_rows  > 0) {
        echo "<script>
                alert('ชื่อ Username นี้ถูกใช้ไปเเล้ว กรุณาใช้ชื่อ Usernameอื่น!');
                window.location = 'register_web.php';
              </script>";
        die();
    } 

    $insert_sql = "INSERT INTO user(username, email, password) VALUES('$user_name', '$email', '$pwd')";
    $result = mysqli_query($conn, $insert_sql);
    header('location:login.php');

    mysqli_close($conn);
} 
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <div class="curved-shape1"></div>
        <div class="curved-shape2"></div>
        <div class="register-form">
            <h2>Register</h2>
            <form action="" method="POST">
                <div class="input-box">
                    <input type="text" id="email" name="email" required>
                    <label for="email">Email</label>
                    <i class='bx bxs-envelope'></i>
                </div>
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
                <div class="input-box">
                    <input type="password" id="con_password" name="con_password" required>
                    <label for="con_password">Confirm Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="input-box">
                    <button class="btn" type="submit">Register</button>
                </div>
                <div class="link">
                    <p>Already have an account?<a href="login.php" class="a">Log in</a></p>
                </div>
                <!-- Element สำหรับแสดงข้อความข้อผิดพลาด -->
                <p id="error-message" class="error-message"></p>
            </form>
        </div>
        <div class="info-content2 register">
            <h2>WELCOME</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, provident.</p>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('register-form');
               
                form.addEventListener('submit', (event) => {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('con_password').value;
    
            
                    if (password !== confirmPassword){
                    event.preventDefault();
                    alert("รหัสไม่ตรงกัน");
                        }                       
                });
            });
        </script>
    </div>
</body>
</html>

