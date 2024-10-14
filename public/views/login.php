<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/login.css">
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
    <title>Map Depot</title>
</head>

<body>
    <div class="flex-center start-background">
        <div class="start-container">

            <img class="logo" src="public/img/logo.svg">

        
            <form class="flex-center" action="login" method="POST">
                <h2>Log In</h2>
                <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo "<p class='warning-box base-font'>".$message."</p>";
                        }
                    }
                ?>
                <br>
                <input class="base-font" type="email" name="email" placeholder="Email address" required>
                <input class="base-font password-hidden" type="password" name="password" placeholder="Password" required>
            
                <p class="base-font"><a href="password">Forgot password?</a></p>
                <br>

                <button type="submit">Log In</button>
            </form>
            <p class="signup-link">Don't have an account? <a href="register">Sign up here.</a></p>


        </div>
    </div>
</body>
