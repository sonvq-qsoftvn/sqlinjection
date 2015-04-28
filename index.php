<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>User Management System - SQL Injection QSoft</title>
        <meta name="description" content="Custom Login Form Styling with CSS3" />
        <meta name="keywords" content="css3, login, form, custom, input, submit, button, html5, placeholder" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script src="js/modernizr.custom.63321.js"></script>

        <style>
            @import url(http://fonts.googleapis.com/css?family=Ubuntu:400,700);
            body {
                background: #563c55 url(images/blurred.jpg) no-repeat center top;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                background-size: cover;
            }
            .container > header h1,
            .container > header h2 {
                color: #fff;
                text-shadow: 0 1px 1px rgba(0,0,0,0.7);
            }
        </style>
    </head>
    <body>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hostname = "localhost"; // Host name 
            $usernamehost = "root"; // Mysql username 
            $passwordhost = ""; // Mysql password 
            $dbname = "sqlinjection"; // Database name 
            // Create connection
            $conn = mysqli_connect($hostname, $usernamehost, $passwordhost, $dbname);
            // Check connection
            if (!$conn) {
                $errorMsg = "Connection failed: " . mysqli_connect_error();
            }
            // username and password sent from form 
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM user WHERE username='$username' and password='$password'";

            //if ($result = mysqli_multi_query($conn, $sql)) {
            if ($result = mysqli_query($conn, $sql)) {
                $count = mysqli_num_rows($result);
                if ($count == 1) {
                    if ($username == "quangsonpro") {
                        header("Location: http://localhost/sqlinjection/loginednormal.php");
                    } else {
                        header("Location: http://localhost/sqlinjection/logined.php");
                    }
                } else {
                    $errorMsg = "Wrong username or password";
                }
            } else {
                $errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            mysqli_close($conn);
        }
        ?>
        <div class="container">

            <header>

                <h1><strong>User Management System</strong></h1>

                <div class="support-note">
                    <span class="note-ie">Sorry, only modern browsers.</span>
                </div>
                <h2 style="color: red; font-size: 18px;"><?php if (isset($errorMsg)) echo $errorMsg; ?></h2>
            </header>

            <section class="main">
                <form class="form-3" method="POST" action="">
                    <p class="clearfix">
                        <label for="login">Username</label>
                        <input type="text" name="username" id="username" placeholder="Username">
                    </p>
                    <p class="clearfix">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password"> 
                    </p>
                    <p class="clearfix">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember me</label>
                    </p>
                    <p class="clearfix">
                        <input type="submit" name="submit" value="Sign in">
                    </p>       
                </form>​
            </section>

        </div>
    </body>
</html>