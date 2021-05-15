<?php
session_start();


$server = "localhost";
$username_db = "root";
$pass_db = "";
$database = "iniwebsite";

$conn = mysqli_connect($server, $username_db, $pass_db, $database);

$err = "";
$username = "";
$remember = "";

if(isset($cookie_username = $_COOKIE['cookie_username'])){
    $cookie_name = $_COOKIE['cookie_username'];
    $cookie_name = $_COOKIE['cookie_password'];

    $sql1 = "select * from iniwebsite where uname = '$cookie_username'";
    $q1 = mysqli_query($conn, $sql1);
    $r1 = mysqli_fetch_array($q1);
    if($r1['passwrod '] == $cookie_password){
        $_SESSION['session_username'] = $cookie_username;
        $_SESSION['session_password'] = $cookie_password;
    }
}

if (isset($_POST['submitlog'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = $_POST['remember'];

    if($username == '' or $password == ''){
        $err .= "<li>Please Write Down Your Username and Password!</li>";
    } else{
        $sql1 = "select * from iniwebssite where uname = '$username'";
        $q1 = mysqli_query($conn, $sql1);
        $r1 = mysqli_fetch_array($q1);

        if($r1['username'] == ''){
            $err .= "<li>Username <b>$username</b> not found</li>";
        } elseif($r1['password'] != md5($password)){
            $err .= "<li>Password Incorrect</li>";
        }

        if(empty($err)){
            $_SESSION['session_username'] = $username;
            $_SESSION['session_password'] = md5($password);
            

            if($remember == 1){
                $cookie_name = "cookie_username";
                $cookie_value = $username;
                $cookie_time = time() + (60*60*24);
                setcookie($cookie_name, $cookie_value, $cookie_time,"/");
            
                $cookie_name = "cookie_password";
                $cookie_value = $password;
                $cookie_time = time() + (60*60*24);
                setcookie($cookie_name, $cookie_value, $cookie_time,"/");
            }
            header("location:beranda.php");

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In Your Account</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

        <section class="signin">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="signup-form">
                        <h2 class="form-title">Sign In</h2>
                        <div class="form-group">
                            <input type="text" class="form-input" name="username" id="username" placeholder="Username"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="password" id="password" placeholder="Password"/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="remember" id="remember" class="agree-term" value="1" <?php if($remember == '1') echo "checked"?> />
                            <label><span><span></span></span>Remember Me</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submitlog" id="submitlog" class="form-submit" value="Sign up"/>
                        </div>
                    </form>
                </div>
            </div>
        </section>


    </div>


    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>