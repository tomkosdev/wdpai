<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/maps.css"/>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css"/>
    <title>Map Depot</title>
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
    
    <script src="https://kit.fontawesome.com/b192b1ab6f.js" crossorigin="anonymous"></script>

</head>

<body>

    <div class="base-container">

        <div class="flex-row-left-center header">
            <img class="logo" src="public/img/logo.svg">
        </div>

        <div class="lower-container">

            <div class="flex-left-center nav-bar">


                <form class="flex-center">

                    <button type="submit" class="default-button base-font home-icon" formaction="maps"><i class="fa-solid fa-house"></i> HOME</button>
                    <?php
                        if ($_SESSION['role'] !== User::Guest) {
                            echo '<button type="submit" class="default-button base-font add-map-icon" formaction="add_map"><i class="fa-solid fa-plus"></i> ADD A MAP</button>';
                            echo '<button type="submit" class="default-button base-font liked-icon" formaction="liked_maps"><i class="fa-solid fa-heart"></i> MY FAVOURITE</button>';
                            echo '<button type="submit" class="default-button base-font settings-icon" formaction="password2"><i class="fa-solid fa-gear"></i> SETTINGS</button>';
                            echo '<button type="submit" class="default-button base-font logout-icon last" formaction="logout"><i class="fa-solid fa-right-from-bracket"></i> SIGN OUT</button>';
                        }
                        else
                        {
                            echo '<button type="submit" class="default-button base-font home-icon last" formaction="login"><i class="fa-solid fa-right-to-bracket"></i> LOGIN</button>';
                        }

                    ?>

                </form>
            </div>
            
            <div class="maps-container flex-center">

                <form class="flex-center" action="add_map" method="POST" ENCTYPE="multipart/form-data">

                    <h2 class="base-font">ADD NEW MAP</h2>
                    <br>

                    <?php
                        if(isset($messages)){
                            foreach($messages as $message) {
                                echo "<p class='warning-box base-font'>".$message."</p>";
                            }
                        }
                    ?>

                    <input class="base-font" type="text" name="title" placeholder="Name" maxlength="30" required>
                    <input class="base-font" type="text" name="description" placeholder="Description" maxlength="250" required>
                    <!-- <input class="base-font" style="border: 0px; box-shadow: none" type="file" name="file" required> -->
                    <!-- <input class="base-font" style="border: 0px; box-shadow: none" type="file" name="map" accept=".pk3" required> -->


                    <input type="file" style="border: 0px; box-shadow: none" name="image" accept="image/*" required>
                    <input type="file" style="border: 0px; box-shadow: none" name="map" accept=".pk3" required>

                    <!-- <input                                                         type="file" name="map" accept=".pk3"> -->
                    

                    <!-- Download button for the .pk3 file -->

                    <!-- <input type="file" name="image" accept="image/*"> -->
                    <!-- <input type="file" name="map" accept=".pk3"> -->


                    <br><button type="submit" class="default-button base-font last-button">CONFIRM</button>
                </form>
            </div>
        </div>
    </div>
</body>