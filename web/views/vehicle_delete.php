<?php
    //Check that there is an active session 
    if(!isset($_SESSION['clientData'])){
        header("location: " . ROOT_URI);
        exit;
    }
    //Check that the user has proper rights
    if ($_SESSION['clientData']['clientLevel'] < 2) {
    header("location: " . ROOT_URI);
    exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            <?php
                if(isset($vehicleInfo['invMake']) && isset($vehicleInfo['invModel'])) 
                    echo "Delete $vehicleInfo[invMake] $vehicleInfo[invModel]"; 
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
                                if(isset($vehicleInfo['invMake']) && isset($vehicleInfo['invModel'])) 
                                    echo "Delete $vehicleInfo[invMake] $vehicleInfo[invModel]"; 
                            ?>
                        </h1>
                        <p class='form_important_info'>Confirm Vehicle Deletion. The delete is permanent.</p>
                        <div>
                            <label for='invMake'>Make</label>
                        </div>
                        <input type="text" class="form_input form_readonly" id="invMake"  name="invMake" value='<?php if(isset($vehicleInfo['invMake'])) echo $vehicleInfo['invMake'];?>' readonly>
                        <div>
                            <label for='invModel'>Model</label>
                        </div>
                        <input type="text" class="form_input form_readonly" id="invModel"  name="invModel"  value='<?php if(isset($vehicleInfo['invModel'])) echo $vehicleInfo['invModel'];?>' readonly>  
                        <div>
                            <label for='invDescription'>Description</label>
                            <span class='required'>*</span>
                        </div>
                        <textarea  class="form_textarea form_readonly" id="invDescription"  name="invDescription" readonly><?php if(isset($vehicleInfo['invDescription'])) echo $vehicleInfo['invDescription'];?></textarea>
                        <input type="submit" class="primary_btn" value="Delete Vehicle">
                        <input type="hidden" name="action" value="deleteVehicle">
                        <input type="hidden" name="invId" value="<?php if(isset($vehicleInfo['invId'])) echo $vehicleInfo['invId'];?>">
                    </form>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>
