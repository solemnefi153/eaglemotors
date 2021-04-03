<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login or continue as guest | Eagle Motors, LLC.</title>
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
                    <p class='form_p' >Keep track of your future test drives in your account</p>
                    <div id='left_form'>
                        <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/accounts/'>
                            <input type="submit" class="secondary_btn" value="Sign In">
                        </form> 
                        <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/accounts/'>
                            <input type="submit" class="secondary_btn" value="Register account">
                            <input type="hidden" name='action' value="view_registration">
                        </form>
                    </div >
                    <fieldset class='custom_fieldset'>
                        <legend>or</legend>
                        <a class='primary_btn' href='<?php if(isset($redirect_url)) echo $redirect_url . "&guest=true" ?>' >Continue as guest</a>
                    </fieldset>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>


