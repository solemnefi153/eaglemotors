<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sign In | Eagle Motors, LLC.</title>
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
                    <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/accounts/'>
                        <h1 class='form_title'>Sign In</h1>
                        <label for='clientEmail'>Email Address:</label>
                        <input type="email" class="form_input <?php if(isset($emailErr)) echo $emailErr; ?>" id="clientEmail"  name="clientEmail"  value='<?php if(isset($clientEmail)) echo $clientEmail;?>' required>
                        <label for='clientPassword'>Password:</label>
                        <input type="password" class="form_input <?php if(isset($passwordErr)) echo $passwordErr; ?>" id="clientPassword"  name="clientPassword"   value='<?php if(isset($clientPassword)) echo $clientPassword;?>' required
                        pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                        <div class='inputRequirements'>
                            <span>Passwords should have:</span>
                            <span>8 charracters </span>
                            <span>At least 1 upercase </span>
                            <span>At least  1 number</span>
                            <span>At least  1 special character</span>
                        </div>
                        <input type="submit" class="primary_btn" value="Sign In">
                        <input type="hidden" name='action' value="logIntoAccount">
                    </form>
                    <fieldset class='custom_fieldset'>
                        <legend >Don't have an account?</legend>
                        <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/accounts/'>
                            <input type="submit" class="secondary_btn" value="Register account">
                            <input type="hidden" name='action' value="view_registration">
                        </form>
                    </fieldset>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>


