<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>User Management System - SQL Injection QSoft</title>
        
        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="assets/css/styles.css" />
        
    </head>
    
    <body>
	
		<?php
            $hostname 		= "localhost"; // Host name 
            $usernamehost 	= "root"; // Mysql username 
            $passwordhost 	= ""; // Mysql password 
            $dbname 		= "sqlinjection"; // Database name 

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == "mysqli") {
                // Create connection
                $conn = new mysqli($hostname, $usernamehost, $passwordhost, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // username and password sent from form 
                $username = $_POST['username'];
                $password = $_POST['password'];

                // prepare and bind
                $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? and password = ?");
                // "ss' is a format string, each "s" means string
                // i - integer
                // d - double
                // s - string
                // b - BLOB
                $stmt->bind_param("ss", $username, $password);

                $stmt->execute();
                $stmt->store_result();
                
                if($stmt->num_rows == 1) {
                    header("Location: http://localhost/sqlinjection/loginednormal.php");
                } else {
                    $errorMsg = "Wrong username/password";
                }

                $stmt->close();
                $conn->close();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == "pdo") {
                try {
                    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $usernamehost, $passwordhost);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // username and password sent from form 
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    // prepare sql and bind parameters
                    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username and password = :password");
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);

                    $stmt->execute();
                    
                    if($stmt->rowCount() == 1) {
                        header("Location: http://localhost/sqlinjection/loginednormal.php");
                    } else {
                        $errorMsg = "Wrong username/password";
                    }

                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                $conn = null;
            }
		?>

		<div id="formContainer">
			<form style="text-align: center;" id="login" method="POST" action="">
				<a href="#" id="flipToRecover" class="flipLink">Forgot?</a>
                <h2 style="color: red; font-size: 18px; margin-top: -40px; margin-bottom: 20px;"><?php if (isset($errorMsg)) echo $errorMsg; ?></h2>
				<input type="text" name="username" id="loginEmail" placeholder="Username" />
				<input style="display:none">
				<input type="password" name="password" id="loginPass" placeholder="Password" />
				<input type="submit" name="submit" value="pdo" />
			</form>
			<form id="recover" method="POST" action="">
				<a href="#" id="flipToLogin" class="flipLink">Forgot?</a>
                <h2 style="color: red; font-size: 18px; margin-top: -40px; margin-bottom: 20px;"><?php if (isset($errorMsg)) echo $errorMsg; ?></h2>
				<input type="text" name="username" id="loginEmail" placeholder="Username" />
				<input style="display:none">
				<input type="password" name="password" id="loginPass" placeholder="Password" />
				<input type="submit" name="submit" value="mysqli" />
			</form>
		</div>

        <footer>
	        <h2><i>Tutorial:</i> SQL INJECTION</h2>
            <a class="tzine" href="">Quangsonpro @ 2015</a>
        </footer>
        
        <!-- JavaScript includes -->
		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script src="assets/js/script.js"></script>

    </body>
</html>

