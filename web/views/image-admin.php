<?php
    //Check that there is an active session 
    if(!isset($_SESSION['clientData'])){
        header("location: " . ROOT_URI);
        exit;
    }
    //Check that the user has proper rights
    if ($_SESSION['clientData']['client_level'] < 2) {
    header("location: " . ROOT_URI);
    exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Image management | Eagle Motors, LLC.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/general_styles.css' media='screen'>
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/vehicle_management.css' media='screen'>
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/vehicle_images_styles.css' media='screen'>
        <link href="<?php echo ROOT_URI; ?>public/images/site/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
        <div class='content'>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/header.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/navigation.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/notification_area.php'; ?>
            <h1 >Image management</h1>
            <main class='main-justified-left'>
                <form class='custom_form' action="<?php echo ROOT_URI; ?>controllers/uploads/" method="post" enctype="multipart/form-data">
                    <h2>Add vehicle image</h2>
                    <label for="inv_id">Vehicle</label>
                    <?php 
                        // Build the vehicles select list
                        if(isset($vehicles)){
                            $html = '<select class="from_select" name="inv_id" id="inv_id" required>';
                            $html .= "<option value='' disabled hidden selected>Choose a Vehicle</option>";
                            foreach ($vehicles as $vehicle) {
                                $html .= "<option value='$vehicle[inv_id]'>$vehicle[inv_make] $vehicle[inv_model]</option>";
                            }
                            $html .= '</select>';
                            echo $html;
                        }
                    ?>
                    <label>Main vehicle image</label>
                    <div class='from_radio_section'>
                        <label for="priYes" class="pImage">Yes</label>
                        <input type="radio" name="img_primary" id="priYes" class="pImage" value="1">
                        <label for="priNo" class="pImage">No</label>
                        <input type="radio" name="img_primary" id="priNo" class="pImage" checked value="0">
                    </div>
                    <label>Upload Image:</label>
                    <input class="from_file" type="file" name="file1" accept=".png, .jpg, .jpeg" required>
                    <input type="submit" class="primary_btn  from_btn" value="Upload Image">
                    <input type="hidden" name="action" value="upload">
                </form>
                <h2>Existing Images</h2>
                <p class="notice">When deleting an image, delete the thumbnail too and vice versa.</p>
                <?php
                    // Build images display for image management view
                    if (isset($imageArray)) {
                        $html = '<ul id="image-display">';
                        foreach ($imageArray as $image) {
                            $html .= '<li>';
                            $html .= "<img class='image_display' src='" . ROOT_URI . "$image[img_path]' title='$image[inv_make] $image[inv_model] image on PHP Motors.com' alt='$image[inv_make] $image[inv_model] image on PHP Motors.com'>";
                            $html .=  "<p>$image[img_name]</p>";
                            $html .= "<a class='delete_btn' href='" . ROOT_URI . "controllers/uploads?action=delete&img_id=$image[img_id]&filename=$image[img_name]' title='Delete image'>Delete Image</a>";
                            $html .= '</li>';
                        }
                        $html .= '</ul>';
                        echo $html;
                    }
                ?>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>