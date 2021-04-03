<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home | Eagle Motors, LLC.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/general_styles.css' media='screen'>
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/car_details_styles.css' media='screen'>
        <link href="<?php echo ROOT_URI; ?>public/images/site/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
        <div class='content'>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/header.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/navigation.php'; ?>
            <main>
                <h1>Welcome to Eagle Motors!</h1>
                <div class='main_car_area'>
                    <div class='main_features'>
                        <h2  class='car_name' >DCM Delorean</h2>
                        <p>3 Cup holders</p>
                        <p>Superman doors</p>
                        <p>Fuzzy dice!</p>
                    </div>
                    <button class='own_btn'>Own Today</button>
                    <img class='car_image' src='<?php echo ROOT_URI; ?>images/vehicles/delorean.jpg' alt='delorean'>
                </div>
                <div class='car_details'>
                    <div class='reviews_section'>
                        <h3>DCM Delorean Reviews</h3>
                        <ul>
                            <li>"So fast its almost like traveling in time."  (4/5) </li>
                            <li>"Coolest ride on the road."  (4/5) </li>
                            <li>"I'm feeling Marty McFly."  (5/5) </li>
                            <li>"The most futuristic ride on our day."  (4.5/5) </li>
                            <li>"80's living and I love it!"  (5/5) </li>
                        </ul>
                    </div>
                    <div class="upgrades_section">
                        <h3>Delorean Upgrades</h3>
                        <div class='upgrades_container'>
                            <div class='upgrade_item'>
                                <div class='upgrade_image_container'>
                                    <img src='<?php echo ROOT_URI; ?>public/images/upgrades/flux-cap.png' alt='Flux Capacitor'>
                                </div>
                                <a href='#' title='More info about Flux Capacitor'>Flux Capacitor</a>
                            </div>
                            <div class='upgrade_item'>
                                <div class='upgrade_image_container'>
                                    <img src='<?php echo ROOT_URI; ?>public/images/upgrades/flame.jpg' alt='Flame Decals'>
                                </div>
                                <a href='#' title='More info about Flame Decals'>Flame Decals</a>
                            </div>
                            <div class='upgrade_item'>
                                <div class='upgrade_image_container'>
                                    <img src='<?php echo ROOT_URI; ?>public/images/upgrades/bumper_sticker.jpg' alt='Bumper Stickers'>
                                </div>
                                <a href='#' title='More info about Bumper Stickers'>Bumper Stickers</a>
                            </div>
                            <div class='upgrade_item'>
                                <div class='upgrade_image_container'>
                                    <img src='<?php echo ROOT_URI; ?>public/images/upgrades/hub-cap.jpg' alt='Hub Caps'>
                                </div>
                                <a href='#' title='More info about Hub Caps'>Hub Caps</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>
