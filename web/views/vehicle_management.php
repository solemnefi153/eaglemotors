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
        <title>Vehicle Management | Eagle Motors, LLC.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/general_styles.css' media='screen'>
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/vehicle_management.css' media='screen'>
        <link href="<?php echo ROOT_URI; ?>public/images/site/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
        <div class='content'>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/header.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/navigation.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/notification_area.php'; ?>
            <main>
                <h1 >Vehicle Management</h1>
                <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/vehicles/'>
                    <input type="submit" class="secondary_btn" value="Add Vehicle">
                    <input type="hidden" name='action' value="view_add_vehicle">
                </form>
                <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/vehicles/'>
                    <input type="submit" class="secondary_btn" value="Add Car Classification">
                    <input type="hidden" name='action' value="view_add_car_classification">
                </form>
                <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/uploads/'>
                    <input type="submit" class="secondary_btn" value="Manage Inventory Images">
                </form>
                <?php
                if (isset($classifications)) { 
                    $html =  '<h2>Manage vehicles by classification</h2>'; 
                    $html .= '<p>Choose a classification to see those vehicles</p>'; 
                    $html .= "<select  class='custom_select' name='classificationId' id='classificationList' >";
                    $html .= "<option   disabled value='' selected> -- Select classification -- </option>";
                    foreach ($classifications as $classification) {
                        $html .= "<option  value='$classification[classificationId]' >$classification[classificationName]</option>";
                    }
                    $html .= "<select>";
                    echo $html;
                }
                ?>
            <noscript>
                <p>
                    <strong>JavaScript Must Be Enabled to Use this Page.</strong>
                </p>
            </noscript>
            <table id="inventoryDisplay"></table>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
        <script >const ROOT_URI ="<?php echo ROOT_URI; ?>"</script>
        <script src="<?php echo ROOT_URI; ?>public/js/inventory.js"></script>
    </body>
</html>

