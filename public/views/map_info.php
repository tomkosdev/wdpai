<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/maps.css"/>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css"/>
    <script src="https://kit.fontawesome.com/b192b1ab6f.js" crossorigin="anonymous"></script>
    <title>Map Depot - <?= $map->getTitle(); ?></title>
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
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
                        if ($_SESSION['role'] !== 3) {
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
            
            <div class="maps-container">
                <div class="flex-center">
                    
                    <?
                        if(isset($messages)){
                            foreach($messages as $message) {
                                echo "<br><p class='warning-box base-font'>".$message."</p><br>";
                            }
                        }
                    ?>

                    <img src="public/uploads/<?= $map->getImage(); ?>">

                    <div class="flex-center">
                        <h3 class="base-font bold" style="color: white;">Map name: <?= $map->getTitle(); ?></h3>

                        <div class="info-section">

                        </div>
                        <br>
                        <br>
                        <p class="base-font" style="color: white;">Map description: <?= $map->getDescription(); ?></p>
                        <br><br>

                    </div>


                    <form action="download" method="POST">
                        <input type="hidden" name="map_name" value=<?=$map->getPk3file();?>>
                        <button type="submit" class="download-button">DOWNLOAD</button>
                    </form>

                    <form method="post">
                        <?php



                            if ($_SESSION['role'] !== 3) {

                                if (is_null($is_liked)) {
                                    echo '<button type="submit" class="like-button base-font" formaction="like_map?id='.$map->getId().'">LIKE</button>';
                                }
                                else {
                                    echo '<button type="submit" class="del-button base-font" formaction="remove_like?id='.$map->getId().'">UNLIKE</button>';
                                }
                            }
                            echo '<br>';
                            if ($_SESSION['role'] === 1) {
                                echo '<button type="submit" class="del-button base-font" formaction="remove_map?id='.$map->getId().'">REMOVE</button>';
                            }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>