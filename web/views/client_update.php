<?php
    //Check that there is an active session 
    if(!isset($_SESSION['clientData'])){
        header("location: " . ROOT_URI . "controllers/accounts");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Update Account | Eagle Motors, LLC.</title>
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
                        <h1 class='form_title'>Account Update</h1>
                        <div>
                            <label for='clientFirstname'>First Name</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($firstNameErr)) echo $firstNameErr; ?>" id="clientFirstname"  name="clientFirstname" value='<?php if(isset($clientFirstname)) echo $clientFirstname;?>' required>
                        <div>
                            <label for='clientLastname'>Last Name</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="text" class="form_input <?php if(isset($lastNameErr)) echo $lastNameErr; ?>" id="clientLastname"  name="clientLastname"  value='<?php if(isset($clientLastname)) echo $clientLastname;?>' required>  
                        <div>
                            <label for='clientEmail'>Email Address</label>
                            <span class='required'>*</span>
                        </div>
                        <input type="email" class="form_input <?php if(isset($emailErr)) echo $emailErr; ?>" id="clientEmail"  name="clientEmail"  value='<?php if(isset($clientEmail)) echo $clientEmail;?>' required>
                        <input type="submit" class="primary_btn" value="Update Account Information">
                        <input type="hidden" name='action' value="updateAccount">
                    </form>
                    <fieldset class='custom_fieldset'>
                        <legend >or</legend>
                        <form class='custom_form' method='POST' action='<?php echo ROOT_URI; ?>controllers/accounts/'>
                            <h1 class='form_title'>Change password</h1>
                            <div>
                                <label for='oldPassword'>Old Password</label>
                                <span class='required'>*</span>
                            </div>
                            <input type="password" class="form_input <?php if(isset($oldPasswordErr)) echo $oldPasswordErr; ?>" id="oldPassword"  name="oldPassword"  required
                            pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                            <div>
                                <label for='clientPassword'>New Password</label>
                                <span class='required'>*</span>
                            </div>
                            <input type="password" class="form_input <?php if(isset($passwordErr)) echo $passwordErr; ?>" id="clientPassword"  name="clientPassword"  required
                            pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                            <div class='inputRequirements'>
                                <span>Passwords should have:</span>
                                <span>8 charracters </span>
                                <span>At least 1 upercase </span>
                                <span>At least  1 number</span>
                                <span>At least  1 special character</span>
                            </div>
                            <input type="submit" class="primary_btn" value="Change Password">
                            <input type="hidden" name='action' value="updatePassowrd">
                        </form>
                    </fieldset>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>