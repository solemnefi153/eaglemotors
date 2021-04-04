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
        <title>
            <?php
                if(isset($vehicleInfo['inv_make']) && isset($vehicleInfo['inv_model'])) 
                    echo "Delete $vehicleInfo[inv_make] $vehicleInfo[inv_model]"; 
            ?>
            | Eagle Motors, LLC.
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/general_styles.css' media='screen'>
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/form_styles.css' media='screen'>
        <link href="<?php echo ROOT_URI; ?>public/images/site/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
        <div class='content'>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/header.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/navigation.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/notification_area.php'; ?>
            <main>
                <div class='form_container'>
                    <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/vehicles/'>
                        <h1 class='form_title'>
                            <?php
                                if(isset($vehicleInfo['inv_make']) && isset($vehicleInfo['inv_model'])) 
                                    echo "Delete $vehicleInfo[inv_make] $vehicleInfo[inv_model]"; 
                            ?>
                        </h1>
                        <p class='form_important_info'>Confirm Vehicle Deletion. The delete is permanent.</p>
                        <div>
                            <label for='inv_make'>Make</label>
                        </div>
                        <input type="text" class="form_input form_readonly" id="inv_make"  name="inv_make" value='<?php if(isset($vehicleInfo['inv_make'])) echo $vehicleInfo['inv_make'];?>' readonly>
                        <div>
                            <label for='inv_model'>Model</label>
                        </div>
                        <input type="text" class="form_input form_readonly" id="inv_model"  name="inv_model"  value='<?php if(isset($vehicleInfo['inv_model'])) echo $vehicleInfo['inv_model'];?>' readonly>  
                        <div>
                            <label for='inv_description'>Description</label>
                            <span class='required'>*</span>
                        </div>
                        <textarea  class="form_textarea form_readonly" id="inv_description"  name="inv_description" readonly><?php if(isset($vehicleInfo['inv_description'])) echo $vehicleInfo['inv_description'];?></textarea>
                        <input type="submit" class="primary_btn" value="Delete Vehicle">
                        <input type="hidden" name="action" value="deleteVehicle">
                        <input type="hidden" name="inv_id" value="<?php if(isset($vehicleInfo['inv_id'])) echo $vehicleInfo['inv_id'];?>">
                    </form>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>