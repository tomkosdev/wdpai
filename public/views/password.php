<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="public/css/login.css">
    <title>Map Depot</title>
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
    <!-- <script type="text/javascript" src="./public/js/password.js" defer></script> -->
</head>


<body>
    <div class="flex-center start-background">
        <div class="start-container">

            <img class="logo" src="public/img/logo.svg">
            <h2 class="base-font">Change your password</h2>
            <br>

            <form class="flex-center" action="password" method="POST">
                
                <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo "<p class='warning-box base-font'>".$message."</p>";
                        }
                    }
                ?> 

                <input class="base-font" type="email" name="email" placeholder="Email address" required>
                <input class="base-font password-hidden" type="password" name="new-password" placeholder="New password" required>
                <input class="base-font password-hidden" type="password" name="repeated-password" placeholder="Repeat new password" required>
                <br>
                <button type="submit" class="default-button base-font last-button">Confirm</button>
                <br>
                <p class="login-link">Already have an account? <a href="login">Log in here.</a></p>
            </form>

        </div>
    </div>
</body>