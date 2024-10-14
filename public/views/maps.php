<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/maps.css"/>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css"/>
    <script src="https://kit.fontawesome.com/b192b1ab6f.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/sorting.js" defer></script>

    <title>Map Depot</title>
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
</head>

<body>

    <div class="base-container">

        <div class="flex-row-left-center header">
            <img class="logo" src="public/img/logo.svg">

            <input placeholder="Search">
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
                            echo '<button type="submit" class="default-button base-font login-icon last" formaction="login"><i class="fa-solid fa-right-to-bracket"></i> SIGN IN</button>';
                        }

                    ?>

                </form>
            </div>
            
            <div class="maps-container">





                <div class="maps-css">
                    <?php foreach ($maps as $map):?>
                    
                        <a href="map_info?id=<?=$map->getId();?>">
                            <div id="<?=$map->getId();?>">
                                <img src="public/uploads/<?= $map->getImage(); ?>">
                                <div>
                                    <h2 class="base-font bold" style="color: white;"><?= $map->getTitle(); ?></h2>

                                    <div class="info-section">
                                        <h4 class="fa-solid fa-heart"  style="color: white;"> <?= $map->getLiked(); ?></h4>
                                        <h4 class="fa-solid fa-user"  style="color: white;"> <?= $map->getUploader(); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>

<template id="map-template">
    <a href="">
        <div id="">
            <img src="">
            <div>
                <h2 class="base-font bold" style="color: white;">title</h2>
                 <div class="info-section">
                    <h4 class="fa-solid fa-heart map-likes" style="color: white;"> likes</h4>
                    <h4 class="fa-solid fa-user map-uploader" style="color: white;"> uploader</h4>

                </div>
            </div>
        </div>
    </a>
</template>