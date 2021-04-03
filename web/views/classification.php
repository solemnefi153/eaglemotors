<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $classificationName; ?> vehicles | Eagle Motors, LLC.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/general_styles.css' media='screen'>
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/vehicles_by_classifications.css' media='screen'>
        <link href="<?php echo ROOT_URI; ?>public/images/site/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
        <div class='content'>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/header.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/navigation.php'; ?>
            <main>
                <h1><?php echo $classificationName; ?> vehicles</h1>
                <?php 
                    if(isset($message)){
                        require ABS_ROOT_FILE_PATH . '/views/snipets/notification_area.php'; 
                    }
                ?>
                <?php 
                    //Creates a unordered list of vechicles and their information from a specific classificaiton. 
                    if(isset($vehicles)){
                        $html = "<ul id='inv-display'>";
                        $no_found_image_th_link = ROOT_URI . "images/vehicles/no-image-tn.png";
                        foreach ($vehicles as $vehicle) {
                            $html .=  "<li>";
                            $html .=  "<a href='" . ROOT_URI . "controllers/vehicles?action=view_vehicle_details&invId=$vehicle[invId]'>";
                            $html .=  "<div>";
                            $html .=  "<img src=' " . ROOT_URI . "$vehicle[imgPath]' onerror='this.onerror=null; this.src=\"$no_found_image_th_link\"' alt='Image of $vehicle[invMake] $vehicle[invModel] on eaglemotors.com'>";
                            $html .=  "</div>";
                            $html .=  "<hr>";
                            $html .=  "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
                            $html .=  "</a>";
                            $html .=  "<span>$". number_format($vehicle['invPrice']) . "</span>";
                            $html .=  "</li>";
                        }
                        $html .=  "</ul>";
                        echo $html;
                    }
                ?>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>
