<?php 
//This is the Accounts controller 
    // Create or access a Session
    session_start();
    //Get the application configuration setting depending on the environment
    require_once "../../app-config.php";
    // Get the necesary models
    require_once ABS_ROOT_FILE_PATH . '/models/car_classifications_model.php';
    require_once ABS_ROOT_FILE_PATH . '/models/accounts_model.php';
    //Import some utility functions 
    require_once ABS_ROOT_FILE_PATH . '/library/formValidation.php';
    require_once ABS_ROOT_FILE_PATH . '/library/handleAdminOrClientRequests.php';
    require_once ABS_ROOT_FILE_PATH . '/library/catchErrors.php';
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
    }
    switch ($action){
        case 'view_loginOrGuest':
            // Filter and store the data
            if(isset($_SESSION['redirectURL'])){
                $redirect_url = $_SESSION['redirectURL'];
            }
            // Get the array of classifications. This is needed for almost every view
            $classifications = getClassifications();
            // Render the loginOrGuest view
            include ABS_ROOT_FILE_PATH . '/views/loginOrGuest.php';
            exit;
            break;
        //Check credentials and sets the necesary session variables
        case 'logIntoAccount':
            // Filter and store the data
            $client_email = filter_input(INPUT_POST, 'client_email', FILTER_SANITIZE_STRING);
            $client_password = filter_input(INPUT_POST, 'client_password', FILTER_SANITIZE_EMAIL);
            $client_email = checkEmail($client_email);
            $checkPassword = checkPassword($client_password);
            //Track input  errors
            $emailErr = $passwordErr = "";
            // Check for missing data
            if( empty($client_email) || empty($checkPassword)){
                $message = 'Please provide a valid email address and password';
                $notificationType = 'error_message';
                $emailErr = empty($client_email) ? ' input_error' : "";
                $passwordErr = empty($checkPassword) ? ' input_error' : "";
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the login view
                include ABS_ROOT_FILE_PATH . '/views/login.php';
                exit; 
            }
            // A valid password exists, proceed with the login process
            // Query the client data based on the email address
            $clientData = getClient($client_email);
            //Check that there is a user in the database whose client_email matches the one passed to this case
            $matchedPassword = false;
            if(count($clientData) > 1){
                // Compare the password just submitted against the  password stored in the database
                $matchedPassword = password_verify($client_password, $clientData['client_password']);
            }
            // If the hashes don't match create an error and return to the login view
            if(!$matchedPassword) {
                $message = 'Please check your credentials and try again';
                $notificationType = 'error_message';
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the login view
                include ABS_ROOT_FILE_PATH . '/views/login.php';
                exit;
            }
            //Login the user after the credentials were verified 
            $_SESSION['loggedin'] = TRUE;
            // Remove the password from the array
            // the array_pop function removes the last
            // element from an array
            array_pop($clientData);
            // Store the array into the session / This is how the code will verify that the session is active
            $_SESSION['clientData'] = $clientData;
            //check if there is a redirect link
            if(isset($_SESSION['redirectURL'])){
                $redirectURL = $_SESSION['redirectURL'];
                unset($_SESSION['redirectURL']);
                echo $redirectURL;
                header("Location: $redirectURL");
                exit;
            }
            //Redirect to this same controller to render the admin view
            header('Location: ' . ROOT_URI . 'controllers/accounts/');
            break;
        //Unsets the $_SESSION variavles and redirects to the default accounts controller case
        case 'logout':
            // Set the loggedin variable to false 
            $_SESSION['loggedin'] = FALSE;
            // Unset the clientData variable
            unset($_SESSION['clientData']);
            //Redirect to the default case of the accounts controller to render the sign in view
            header('Location: ' . ROOT_URI . 'controllers/accounts/');
            exit;
            break;
        //Renders the registration view
        case 'view_registration':
            // Get the array of classifications. This is needed for almost every view
            $classifications = getClassifications();
            //Render the registration view
            include ABS_ROOT_FILE_PATH . '/views/registration.php';
            break;
        //Verifies input and creates a new user in the database
        case 'register':
            // Filter and store the data
            $client_first_name = filter_input(INPUT_POST, 'client_first_name', FILTER_SANITIZE_STRING);
            $client_last_name = filter_input(INPUT_POST, 'client_last_name', FILTER_SANITIZE_STRING);
            $client_email = filter_input(INPUT_POST, 'client_email', FILTER_SANITIZE_EMAIL);
            $client_password = filter_input(INPUT_POST, 'client_password', FILTER_SANITIZE_STRING);
            $client_email = checkEmail($client_email);
            $checkPassword = checkPassword($client_password);
            $checkName = validateNameOrLastName($client_first_name);
            $checkLastName = validateNameOrLastName($client_last_name);
            //Track input  errors
            $firstNameErr = $lastNameErr = $emailErr = $passwordErr = "";
            // Check for missing data
            if(empty($checkName) || empty($checkLastName) || empty($client_email) || empty($checkPassword)){
                $message = 'One or more fields are missing or invalid';
                $notificationType = 'error_message';
                $firstNameErr = empty($checkName) ? ' input_error' : "";
                $lastNameErr = empty($checkLastName) ? ' input_error' : "";
                $emailErr = empty($client_email) ? ' input_error' : "";
                $passwordErr = empty($checkPassword) ? ' input_error' : "";
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the registration view
                include ABS_ROOT_FILE_PATH . '/views/registration.php';
                exit; 
            }
            //Check if the email is used by another account
            $clientData = getClient($client_email);
            //Check if a client with that email was found
            if(!empty($clientData)){
                $message = 'Email already exist. Please sign in with your account';
                $notificationType = 'error_message';
                $emailErr =  'input_error';
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the registration view
                include ABS_ROOT_FILE_PATH . '/views/registration.php';
                exit; 
            }
            // Hash the checked password
            $hashedPassword = password_hash($client_password, PASSWORD_DEFAULT); 
            // Send the data to the model
            $regOutcome = regClient($client_first_name, $client_last_name, $client_email, $hashedPassword);
            // Check and report the result
            if($regOutcome === 1){
                $_SESSION['message'] = "Thanks for registering $client_first_name. Please use your email and password to login.";
                $_SESSION['notificationType'] = 'success_message';
                //Redirect to the default case of the accounts controller to render the admin view
                header('Location: ' . ROOT_URI . 'controllers/accounts/');
                exit;
            } else {
                $message = "Something went wrong. Try again or use different values.";
                $notificationType = 'error_message';
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the registration view
                include ABS_ROOT_FILE_PATH . '/views/registration.php';
                exit;
            }
            break;
        //Renders the update account view if the a session is active
        case 'view_update_account':
            //Here I need to implement the handle admin or client request function
            //Check if the session is active 
            if(isset($_SESSION['clientData'])){
                //Set  necesary  variables for the view
                $client_first_name = $_SESSION['clientData']['client_first_name'];
                $client_last_name = $_SESSION['clientData']['client_last_name'];
                $client_email = $_SESSION['clientData']['client_email'];
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the client update view
                include ABS_ROOT_FILE_PATH . '/views/client_update.php';
                exit;
            }
            //Redirect the default case of the accounts controller to render the sign in view
            header('Location: ' . ROOT_URI . 'controllers/accounts/');
            exit;
            break;
        //Checks a session is active and then updates the user's account information 
        case 'updateAccount':
            //Here I need to implement the handle admin or client request function
            //Check if a session is not active for this action
            if(!isset($_SESSION['clientData'])){
                //Send the request back to the default case of the accouts controller
                $_SESSION['message'] = "Need to sign in to update account";
                $_SESSION['notificationType'] = 'error_message';
                //Redirect to the default case of the accounts controller to render the login view
                header('Location: ' . ROOT_URI . 'controllers/accounts/');
                exit;
            }
            // Filter and store the data
            $client_first_name = filter_input(INPUT_POST, 'client_first_name', FILTER_SANITIZE_STRING);
            $client_last_name = filter_input(INPUT_POST, 'client_last_name', FILTER_SANITIZE_STRING);
            $client_email = filter_input(INPUT_POST, 'client_email', FILTER_SANITIZE_EMAIL);
            $client_email = checkEmail($client_email);
            $checkName = validateNameOrLastName($client_first_name);
            $checkLastName = validateNameOrLastName($client_last_name);
            //Track input  errors
            $firstNameErr = $lastNameErr = $emailErr =  "";
            // Check for missing data
            if(empty($checkName) || empty($checkLastName) || empty($client_email)){
                $message = 'One or more fields are missing or invalid';
                $notificationType = 'error_message';
                $firstNameErr = empty($checkName) ? ' input_error' : "";
                $lastNameErr = empty($checkLastName) ? ' input_error' : "";
                $emailErr = empty($client_email) ? ' input_error' : "";
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the  update account view 
                include ABS_ROOT_FILE_PATH . '/views/client_update.php';
                exit; 
            }
            //Check if the email is used by another account 
            $otherAccountFound = findOtherAccountUsingThisEmail($client_email, $_SESSION['clientData']['client_id']);
            if(!empty($otherAccountFound)){
                $message = 'Email already used by another account.';
                $notificationType = 'error_message';
                $emailErr =  'input_error';
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the  update account view 
                include ABS_ROOT_FILE_PATH . '/views/client_update.php';
                exit; 
            }
            // Send the data to the model
            $updateOutcome = updateClient($client_first_name, $client_last_name, $client_email, $_SESSION['clientData']['client_id']);
            // Check and report the result
            if($updateOutcome === 1){
                $clientData = getClient($client_email);
                // Remove the password from the array
                // the array_pop function removes the last
                // element from an array
                array_pop($clientData);
                // Update the client data in the session  
                $_SESSION['clientData'] = $clientData;
                $_SESSION['message'] = "$client_first_name, your account has been successfully updated";
                $_SESSION['notificationType'] = 'success_message';
                //Redirect to the default case of the accounts controller to render the login view
                header('Location: ' . ROOT_URI . 'controllers/accounts/');
                exit;
            } else {
                $message = "Something went wrong. Try again or use different values.";
                $notificationType = 'error_message';
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the  update account view
                include ABS_ROOT_FILE_PATH . '/views/client_update.php';
                exit;
            }
            break;
        //Checks a session is active and then updates the user's password
        case 'updatePassowrd':
            //Here I need to implement the only client request function
            //Check if a session is not active for this action
            if(!isset($_SESSION['clientData'])){
                //Send the request back to the default case of the accouts controller
                $_SESSION['message'] = "Need to sign in to update your password";
                $_SESSION['notificationType'] = 'error_message';
                //Redirect to the default case of the accounts controller to render the login view
                header('Location: ' . ROOT_URI . 'controllers/accounts/');
                exit;
            }
            // Filter and store the data
            $client_password = filter_input(INPUT_POST, 'client_password', FILTER_SANITIZE_STRING);
            $oldPassword = filter_input(INPUT_POST, 'oldPassword', FILTER_SANITIZE_STRING);
            $checkPassword1 = checkPassword($client_password);
            $checkPassword2 = checkPassword($oldPassword);
            //Track input  errors
            $clientPasswordErr = $oldPasswordErr = "";
            // Check for missing data
            if(empty($checkPassword1) || empty($checkPassword2)){
                $message = 'One or more fields are missing or invalid';
                $notificationType = 'error_message';
                $passwordErr = empty($checkPassword1) ? ' input_error' : "";
                $oldPasswordErr = empty($checkPassword2) ? ' input_error' : "";
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the  update account view 
                include ABS_ROOT_FILE_PATH . '/views/client_update.php';
                exit; 
            }
            // A valid old and new passwords exists, proceed comparing old password with the one in the database
            //This is an additional step for security
            $clientData = getClient($_SESSION['clientData']['client_email']);
            //Check that the old password match the current password in the database
            $matchedPassword = password_verify($oldPassword, $clientData['client_password']);
            // If the hashes don't match create an error
            // and return to the login view
            if(!$matchedPassword) {
                $message = 'Please check your old password and try again';
                $notificationType = 'error_message';
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the client update view
                include ABS_ROOT_FILE_PATH . '/views/client_update.php';
                exit;
            }
            // Hash the  new password
            $hashedPassword = password_hash($client_password, PASSWORD_DEFAULT); 
            //Update the password in the database 
            $updateOutcome = updateClientPassword($hashedPassword, $_SESSION['clientData']['client_id']);
            // Check and report the result
            if($updateOutcome === 1){
                $_SESSION['message'] = $_SESSION['clientData']['client_first_name'] . ", your password has been successfully changed";
                $_SESSION['notificationType'] = 'success_message';
                //Redirect to the default case of the accounts controller to render the admin view
                header('Location: ' . ROOT_URI . 'controllers/accounts/');
                exit;
            } else {
                $message = "Something went wrong. Try again or use different values.";
                $notificationType = 'error_message';
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the  update account view
                include ABS_ROOT_FILE_PATH . '/views/client_update.php';
                exit;
            }
            break;
        //Checks a session is active to render the account view, or the sign in view 
        default:
            // Get the array of classifications. This is needed for almost every view
            $classifications = getClassifications();
            //Check there is a current session 
            if(isset($_SESSION['clientData'])){
                // Render the admin view
                include ABS_ROOT_FILE_PATH . '/views/admin.php';
                //Unset notification variables
                if(isset($_SESSION['message']))
                    unset($_SESSION['message']);
                if(isset($_SESSION['notificationType']))
                    unset($_SESSION['notificationType']);
                exit;
            }
            //If the session is not active render the login view
            include ABS_ROOT_FILE_PATH . '/views/login.php';
            //Unset notification variables
            if(isset($_SESSION['message']))
                unset($_SESSION['message']);
            if(isset($_SESSION['notificationType']))
                unset($_SESSION['notificationType']);
            exit;
            break;
    }
?> 