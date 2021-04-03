<?php
    //Check that there is an active session 
    if(!isset($_SESSION['clientData'])){
        header('location: ' . ROOT_URI . 'controllers/accounts');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My Account | Eagle Motors, LLC.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/general_styles.css' media='screen'>
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/car_details_styles.css' media='screen'>
        <link href="<?php echo ROOT_URI; ?>public/images/site/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
        <div class='content'>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/header.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/navigation.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/notification_area.php'; ?>
            <main>
                <h1><?php echo $_SESSION['clientData']['clientFirstname'] . ' ' . $_SESSION['clientData']['clientLastname']; ?> </h1>
                <p>You are logged in </p>
                <ul>
                    <li>First name: <?php echo $_SESSION['clientData']['clientFirstname']; ?> </li>
                    <li>Last name: <?php echo $_SESSION['clientData']['clientLastname']; ?> </li>
                    <li>Email: <?php echo $_SESSION['clientData']['clientEmail']; ?> </li>
                </ul>
                <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/accounts/'>
                    <input type="submit" class="secondary_btn" value="Update account Information">
                    <input type="hidden" name='action' value="view_update_account">
                </form>
                <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/appointments/'>
                    <input type='submit' class='secondary_btn' value='View and edit appointments'>
                    <input type='hidden' name='action' value='view_appointments'>
                </form>
                <!-- This will redirect to the vehicles controller -->
                <!-- The default case will check if there is an active session and if the session has proper rights -->
                <?php 
                    if($_SESSION['clientData']['clientLevel'] > 1) {
                        echo "<p>To manage the inventory click on the button below</p>";
                        echo "<form class='custom_form' method='POST' action='" . ROOT_URI . "controllers/vehicles/'>";
                        echo "<input type='submit' class='secondary_btn' value='Vehicle Management'>";
                        echo "</form>";
                    }
                ?>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>
