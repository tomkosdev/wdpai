<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/login.css">
    <title>Map Depot</title>
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
    <script type="text/javascript" src="./public/js/register.js" defer></script>
</head>

<body>
    <div class="start-container">
        <form class="flex-center" action="register" method="POST">

            <img class="logo" src="public/img/logo.svg">
            <h2>Sign Up</h2>
            <?php
                if(isset($messages)){
                    foreach($messages as $message) {
                        echo "<p class='warning-box base-font'>".$message."</p>";
                    }
                }
            ?>

            <br>
            <input class="base-font" type="email" name="email" placeholder="Email address" required>
            <input class="base-font" type="text" name="nickname" placeholder="Nickname" required>
            <input class="base-font password-hidden" type="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit" class="default-button base-font last-button">Sign up</button>
            <br>
            <p class="login-link">Already have an account? <a href="login">Log in here.</a></p>

        </form>
    </div>    
</body>