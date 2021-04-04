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
                    echo "Modify $vehicleInfo[inv_make] $vehicleInfo[inv_model]"; 
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
                                echo "Modify $vehicleInfo[inv_make] $vehicleInfo[inv_model]"; 
                            ?>
                        </h1>
                        <?php if (!empty($vehicleMainTnImage)){
                            echo "<img class='form_image' src='" . ROOT_URI . "$vehicleMainTnImage[img_path]' title='$vehicleMainTnImage[img_name] image at eaglemotors.com'> ";
                        }
                        ?>
                        <div>
                            <label for='inv_make'>Make</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($invMakeErr)) echo $invMakeErr;?>" id="inv_make"  name="inv_make" value='<?php if(isset($vehicleInfo['inv_make'])) echo $vehicleInfo['inv_make'];?>' required>
                        <div>
                            <label for='inv_model'>Model</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($invModelErr)) echo $invModelErr; ?>" id="inv_model"  name="inv_model"  value='<?php if(isset($vehicleInfo['inv_model'])) echo $vehicleInfo['inv_model'];?>' required>  
                        <div>
                            <label for='inv_description'>Description</label>
                            <span class='required'>*</span>
                        </div>
                        <textarea  class=" form_textarea <?php if(isset($invDescriptionErr)) echo $invDescriptionErr; ?>" id="inv_description"  name="inv_description"  required><?php if(isset($vehicleInfo['inv_description'])) echo $vehicleInfo['inv_description'];?></textarea>
                        <div>
                            <label for='inv_price'>Price</label>
                            <span class='required'>*</span>
                        </div>
                        <div class='imput_with_symbol <?php if(isset($invPriceErr)) echo $invPriceErr; ?>'>
                            <div class='imput_symbol'>$</div>
                            <input type="text" min="0" id="inv_price" name="inv_price"  value='<?php if(isset($vehicleInfo['inv_price'])) echo $vehicleInfo['inv_price'];?>' placeholder='00.00' pattern='(\d+\.\d{1,2})' required  >
                        </div>
                        <div class='inputRequirements'>
                            <span>Provide 2 decimals</span>
                            <span>Do not add comas</span>
                        </div>
                        <div>
                            <label for='inv_stock'>In Stock</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="number" min="0" class="form_input <?php if(isset($invStockErr)) echo $invStockErr; ?>" id="inv_stock" name="inv_stock"  value='<?php if(isset($vehicleInfo['inv_stock'])) echo $vehicleInfo['inv_stock'];?>' required>
                        <div>
                            <label for='inv_color'>Color</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($invColorErr)) echo $invColorErr; ?>" id="inv_color" name="inv_color"  value='<?php if(isset($vehicleInfo['inv_color'])) echo $vehicleInfo['inv_color'];?>' required>
                        <div>
                            <label for='classification_id'>Classification</label>
                            <span class='required'>*</span>
                        </div>
                        <select class='form_select <?php if(isset($classificationIdErr)) echo $classificationIdErr; ?>' id="classification_id" name="classification_id" required>
                            <?php 
                                if(isset($classifications)){
                                    echo "<option   disabled value=''". (isset($vehicleInfo['classification_id']) ? '' : 'selected') . "> -- Select classification -- </option>";
                                    foreach ($classifications as $classification) {
                                        echo "<option  value='" . $classification['classification_id']. "'";
                                        if(isset($vehicleInfo['classification_id'])){
                                            if($vehicleInfo['classification_id'] == $classification['classification_id']){
                                                echo 'selected ';
                                            }
                                        }
                                        echo ">$classification[classification_name]</option>";
                                    }
                                }
                                else{
                                    echo "<option  disabled selected value=''> -- Error loading classifications -- </option>";
                                }
                            ?>
                        </select>
                        <input type="submit" class="primary_btn" value="Update Vehicle">
                        <input type="hidden" name="action" value="updateVehicle">
                        <input type="hidden" name="inv_id" value="<?php if(isset($vehicleInfo['inv_id']))echo $vehicleInfo['inv_id'];?>">
                        <span class='required'>Required field*</span>
                    </form>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>