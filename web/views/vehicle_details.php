<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            <?php
                if(isset($vehicleInfo['inv_make']) && isset($vehicleInfo['inv_model'])) 
                    echo "$vehicleInfo[inv_make] $vehicleInfo[inv_model]"; 
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
                    if(!empty($vehicleInfo) && isset($primaryImage['img_path'])){
                        $no_found_image_link = ROOT_URI . "images/vehicles/no-image.png";
                        $html = "<h1>Modify $vehicleInfo[inv_make] $vehicleInfo[inv_model]</h1>\n";
                        $html .= "<h2>Price: $" . number_format ( $vehicleInfo['inv_price'] , 2 , "." ,  "," ) . "</h2>\n";
                        $html .= "<div id='vehicle_details_container'>\n";
                        $html .= "    <div id='vehicle-image-details'>\n";
                        $html .= "        <img id='vehicle_img' src='". ROOT_URI . "$primaryImage[img_path]' onerror='this.onerror=null; this.src=\"$no_found_image_link\"' alt='Image of $vehicleInfo[inv_make] $vehicleInfo[inv_model] on eaglemotors.com'>\n";
                        $html .= "        <div id='vehicle-details'>\n";
                        $html .= "            <h2>Vehicle details</h2>\n";
                        $html .= "            <hr>\n";
                        $html .= "            <p>$vehicleInfo[inv_description]</p>\n";
                        $html .= "            <div class='tb_row_t1'>\n";
                        $html .= "                <span>Color :</span>\n";
                        $html .= "                <span>$vehicleInfo[inv_color]</span>\n";
                        $html .= "            </div>\n";
                        $html .= "            <div class='tb_row_t2'>\n";
                        $html .= "                <span>In Stock :</span>\n";
                        $html .= "                <span>$vehicleInfo[inv_stock]</span>\n";
                        $html .= "            </div>\n";
                        $html .= "            <a class='primary_btn' href='" . ROOT_URI . "controllers/appointments/?action=create_appointment_view&inv_id=$vehicleInfo[inv_id]' >Schedule a test drive</a>\n";
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
                                $html .= "    <img class='vehicle_details_tn' src='". ROOT_URI . "$thumbnail[img_path]' onerror='this.onerror=null; this.src=\"$no_found_image_th_link\"' title='$thumbnail[img_name] image on PHP Motors.com' alt='$thumbnail[img_name] image on PHP Motors.com'>";
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