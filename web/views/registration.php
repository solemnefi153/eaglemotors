<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Register | Eagle Motors, LLC.</title>
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
                        <h1 class='form_title'>Register</h1>
                        <div>
                            <label for='client_first_name'>First Name</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($firstNameErr)) echo $firstNameErr; ?>" id="client_first_name"  name="client_first_name" value='<?php if(isset($client_first_name)) echo $client_first_name;?>' pattern="^[a-zA-Z ,.'-]+$" required>
                        <div>
                            <label for='client_last_name'>Last Name</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($lastNameErr)) echo $lastNameErr; ?>" id="client_last_name"  name="client_last_name"  value='<?php if(isset($client_last_name)) echo $client_last_name;?>' pattern="^[a-zA-Z ,.'-]+$" required>  
                        <div>
                            <label for='client_email'>Email Address</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="email" class="form_input <?php if(isset($emailErr)) echo $emailErr; ?>" id="client_email"  name="client_email"  value='<?php if(isset($client_email)) echo $client_email;?>' required>
                        <div>
                            <label for='client_password'>Password</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="password" class="form_input <?php if(isset($passwordErr)) echo $passwordErr; ?>" id="client_password"  name="client_password"  required
                        pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                        <div class='inputRequirements'>
                            <span>Passwords should have:</span>
                            <span>8 charracters </span>
                            <span>At least 1 upercase </span>
                            <span>At least  1 number</span>
                            <span>At least  1 special character</span>
                        </div>
                        <input type="submit" class="primary_btn" value="Register">
                        <input type="hidden" name="action" value="register">
                        <span class='required'>Required field*</span>
                    </form>
                    <fieldset class='custom_fieldset'>
                        <legend >Already have an account?</legend>
                        <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/accounts/'>
                            <input type="submit" class="secondary_btn" value="Log In">
                            <input type="hidden" name='action' value="login">
                        </form>
                    </fieldset>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>