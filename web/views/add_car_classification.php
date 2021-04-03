<?php
    //Check that there is an active session 
    if(!isset($_SESSION['clientData'])){
        header('location: '. ROOT_URI);
        exit;
    }
    //Check that the user has proper rights
    if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: '. ROOT_URI);
    exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add Car Classification | Eagle Motors, LLC.</title>
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
                        <h1 class='form_title'>Add classification</h1>
                        <div>
                            <label for='classificationName'>Classification Name</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($classificationNameErr)) echo $classificationNameErr;?>" id="classificationName"  name="classificationName" value='<?php if(isset($classificationName)) echo $classificationName;?>' required>
                        <span class='required'>Required field*</span>
                        <input type="submit" class="primary_btn" value="Add Classification">
                        <input type="hidden" name="action" value="addCarClassification">
                    </form>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>