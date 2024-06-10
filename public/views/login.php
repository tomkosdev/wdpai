<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="public/css/login.css">
</head>
<body>



    <div class="header-content">
        <div class="links">
            <img src="public/img/logo.svg" alt="Logo" class="logo">
            <a href="public/views/home.html">HOME</a>
            <a href="public/views/signup.html">SIGN UP</a>
            <!--<a href="login.php">Log in</a>-->
        </div>
    </div>

    <div class="container">
        <form class="login-form" action="login" method="POST">
            <h2>Log In</h2>

            <div class="message">
                <?php   if(isset($messages)){
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <br>

            <input type="text" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>


<!--            <label for="email" class="sr-only">Email</label>-->
<!--            <input type="text" id="email" name="email" placeholder="Email" required>-->
<!--            <label for="password" class="sr-only">Password</label>-->
<!--            <input type="password" id="password" name="password" placeholder="Password" required>-->

            <button type="submit">Log In</button>
            <p class="signup-link">Don’t have an account? <a href="public/views/signup.html">Sign up.</a></p>
        </form>
    </div>
</body>
</html>
