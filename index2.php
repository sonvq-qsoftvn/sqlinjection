<!DOCTYPE html>
<html>

    <head>
        <title>User Management System - SQL Injection QSoft</title>
        <meta charset="utf-8">
        <link href="css/index2.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!--webfonts-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,300,600,700' rel='stylesheet' type='text/css'>
        <!--//webfonts-->
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

            $blackList = array("alter", "begin", "cast", "create", "cursor", "declare", "delete",
                "drop", "exec", "execute", "fetch", "insert", "kill", "open",
                "select", "sys", "sysobjects", "syscolumns", "table", "update",
                "<script", "</script", "--", "/*", "*/", "@@", "@");

            for ($i = 0; $i < count($blackList); $i++) {
                if ((strpos(strtolower($username), $blackList[$i]) == true) || (strpos(strtolower($password), $blackList[$i]) == true)) {
                    $hacking = true;
                }
            }

            $sql = "SELECT * FROM user WHERE username='$username' and password='$password'";

            if ($hacking == true) {
                $errorMsg = "Hacking attempted. Nu! Pakachi, I am calling police now!!!";
            } elseif ($result = mysqli_query($conn, $sql)) {
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

        <!-----start-main---->
        <div class="login-form">
            <h1>Sign In</h1>
            <h2><a href="#">Create Account</a></h2>
            <form method="POST" action="" autocomplete="off">
                <h2 style="color: red; font-size: 18px; margin-top: -40px; margin-bottom: 20px;"><?php if (isset($errorMsg)) echo $errorMsg; ?></h2>
                <li>
                    <input tabindex="1" autocomplete="off" type="text" name="username" class="text" placeholder="Username"><a href="#" class=" icon user"></a>
                </li>
                <input style="display:none">
                <li>
                    <input tabindex="2" name="password" type="password" placeholder="Password"><a href="#" class=" icon lock"></a>
                </li>

                <div class ="forgot">
                    <h3><a href="#">Forgot Password?</a></h3>
                    <input type="submit" value="Sign In" > <a href="#" class=" icon arrow"></a>                                                                                                                                                                                                                                 </h4>
                </div>
            </form>
        </div>
        <!--//End-login-form-->
    </body>
</html>