<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            <?php
                if(isset($vehicleInfo['invMake']) && isset($vehicleInfo['invModel'])) 
                    echo "$vehicleInfo[invMake] $vehicleInfo[invModel]"; 
            ?>
            | Eagle Motors, LLC.
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/general_styles.css' media='screen'>
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/vehicle_details_styles.css' media='screen'>
        <link href="<?php echo ROOT_URI; ?>public/images/site/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
        <div class='content'>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/header.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/navigation.php'; ?>
            <?php 
                if(isset($message) || isset($_SESSION['message'])){
                    require ABS_ROOT_FILE_PATH . '/views/snipets/notification_area.php'; 
                }
            ?>
            <main>
                <?php
                    // Creates the necesary html to display the vehicle details page
                    if(!empty($vehicleInfo) && isset($primaryImage['imgPath'])){
                        $no_found_image_link = ROOT_URI . "images/vehicles/no-image.png";
                        $html = "<h1>Modify $vehicleInfo[invMake] $vehicleInfo[invModel]</h1>\n";
                        $html .= "<h2>Price: $" . number_format ( $vehicleInfo['invPrice'] , 2 , "." ,  "," ) . "</h2>\n";
                        $html .= "<div id='vehicle_details_container'>\n";
                        $html .= "    <div id='vehicle-image-details'>\n";
                        $html .= "        <img id='vehicle_img' src='". ROOT_URI . "$primaryImage[imgPath]' onerror='this.onerror=null; this.src=\"$no_found_image_link\"' alt='Image of $vehicleInfo[invMake] $vehicleInfo[invModel] on eaglemotors.com'>\n";
                        $html .= "        <div id='vehicle-details'>\n";
                        $html .= "            <h2>Vehicle details</h2>\n";
                        $html .= "            <hr>\n";
                        $html .= "            <p>$vehicleInfo[invDescription]</p>\n";
                        $html .= "            <div class='tb_row_t1'>\n";
                        $html .= "                <span>Color :</span>\n";
                        $html .= "                <span>$vehicleInfo[invColor]</span>\n";
                        $html .= "            </div>\n";
                        $html .= "            <div class='tb_row_t2'>\n";
                        $html .= "                <span>In Stock :</span>\n";
                        $html .= "                <span>$vehicleInfo[invStock]</span>\n";
                        $html .= "            </div>\n";
                        $html .= "            <a class='primary_btn' href='" . ROOT_URI . "controllers/appointments/?action=create_appointment_view&invId=$vehicleInfo[invId]' >Schedule a test drive</a>\n";
                        $html .= "        </div>\n";
                        $html .= "    </div>\n";
                        //Creates the neceary html to display the vehicle thumbnails
                        if(isset($thumbnails)){
                            if(count($thumbnails) > 0){
                                $no_found_image_th_link = ROOT_URI . "images/vehicles/no-image-tn.png";
                                $html .= "<h2 class='on_mobile_view_show' >Other images</h2>\n";
                            }
                            $html .= "    <div id='vehicle-thumbnails'>\n";
                            foreach ($thumbnails as $thumbnail) {
                                $html .= "    <img class='vehicle_details_tn' src='". ROOT_URI . "$thumbnail[imgPath]' onerror='this.onerror=null; this.src=\"$no_found_image_th_link\"' title='$thumbnail[imgName] image on PHP Motors.com' alt='$thumbnail[imgName] image on PHP Motors.com'>";
                            }
                            $html .= "    </div>\n"; 
                        }
                        $html .= "</div>\n";
                        echo $html;  
                    }
                ?>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>
