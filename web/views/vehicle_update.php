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
                    echo "Modify $vehicleInfo[invMake] $vehicleInfo[invModel]"; 
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
                                echo "Modify $vehicleInfo[invMake] $vehicleInfo[invModel]"; 
                            ?>
                        </h1>
                        <?php if (!empty($vehicleMainTnImage)){
                            echo "<img class='form_image' src='" . ROOT_URI . "$vehicleMainTnImage[imgPath]' title='$vehicleMainTnImage[imgName] image at eaglemotors.com'> ";
                        }
                        ?>
                        <div>
                            <label for='invMake'>Make</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($invMakeErr)) echo $invMakeErr;?>" id="invMake"  name="invMake" value='<?php if(isset($vehicleInfo['invMake'])) echo $vehicleInfo['invMake'];?>' required>
                        <div>
                            <label for='invModel'>Model</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($invModelErr)) echo $invModelErr; ?>" id="invModel"  name="invModel"  value='<?php if(isset($vehicleInfo['invModel'])) echo $vehicleInfo['invModel'];?>' required>  
                        <div>
                            <label for='invDescription'>Description</label>
                            <span class='required'>*</span>
                        </div>
                        <textarea  class=" form_textarea <?php if(isset($invDescriptionErr)) echo $invDescriptionErr; ?>" id="invDescription"  name="invDescription"  required><?php if(isset($vehicleInfo['invDescription'])) echo $vehicleInfo['invDescription'];?></textarea>
                        <div>
                            <label for='invPrice'>Price</label>
                            <span class='required'>*</span>
                        </div>
                        <div class='imput_with_symbol <?php if(isset($invPriceErr)) echo $invPriceErr; ?>'>
                            <div class='imput_symbol'>$</div>
                            <input type="text" min="0" id="invPrice" name="invPrice"  value='<?php if(isset($vehicleInfo['invPrice'])) echo $vehicleInfo['invPrice'];?>' placeholder='00.00' pattern='(\d+\.\d{1,2})' required  >
                        </div>
                        <div>
                            <label for='invStock'>In Stock</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="number" min="0" class="form_input <?php if(isset($invStockErr)) echo $invStockErr; ?>" id="invStock" name="invStock"  value='<?php if(isset($vehicleInfo['invStock'])) echo $vehicleInfo['invStock'];?>' required>
                        <div>
                            <label for='invColor'>Color</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($invColorErr)) echo $invColorErr; ?>" id="invColor" name="invColor"  value='<?php if(isset($vehicleInfo['invColor'])) echo $vehicleInfo['invColor'];?>' required>
                        <div>
                            <label for='classificationId'>Classification</label>
                            <span class='required'>*</span>
                        </div>
                        <select class='form_select <?php if(isset($classificationIdErr)) echo $classificationIdErr; ?>' id="classificationId" name="classificationId" required>
                            <?php 
                                if(isset($classifications)){
                                    echo "<option   disabled value=''". (isset($vehicleInfo['classificationId']) ? '' : 'selected') . "> -- Select classification -- </option>";
                                    foreach ($classifications as $classification) {
                                        echo "<option  value='" . $classification['classificationId']. "'";
                                        if(isset($vehicleInfo['classificationId'])){
                                            if($vehicleInfo['classificationId'] == $classification['classificationId']){
                                                echo 'selected ';
                                            }
                                        }
                                        echo ">$classification[classificationName]</option>";
                                    }
                                }
                                else{
                                    echo "<option  disabled selected value=''> -- Error loading classifications -- </option>";
                                }
                            ?>
                        </select>
                        <input type="submit" class="primary_btn" value="Update Vehicle">
                        <input type="hidden" name="action" value="updateVehicle">
                        <input type="hidden" name="invId" value="
                            <?php 
                                if(isset($vehicleInfo['invId']))
                                    echo $vehicleInfo['invId'];
                            ?>
                        ">
                        <span class='required'>Required field*</span>
                    </form>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>
