<?php 
session_start();
//This is the Image Uploads controller 
    //Get the application configuration setting depending on the environment
    require_once "../../app-config.php";
    // Get the necesary models
    require_once ABS_ROOT_FILE_PATH . '/models/car_classifications_model.php';
    require_once ABS_ROOT_FILE_PATH . '/models/vehicles_model.php';
    require_once ABS_ROOT_FILE_PATH . '/models/appointments_model.php';
    require_once ABS_ROOT_FILE_PATH . '/models/uploads_model.php';
    //Import some utility functions 
    require_once ABS_ROOT_FILE_PATH . '/library/formValidation.php';
    require_once ABS_ROOT_FILE_PATH . '/library/handleAdminOrClientRequests.php';
    require_once ABS_ROOT_FILE_PATH . '/library/catchErrors.php';
    // directory name where uploaded images are stored
    $image_dir = '/eaglemotors/images/vehicles';
    // The path is the full path from the server root
    $image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;
    //Grab the action from the requrest
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
    }
    switch ($action) {
        //renders the create appointment view
        case 'create_appointment_view':
            //Filter the values form the query string
            $inv_id = filter_input(INPUT_GET, 'inv_id', FILTER_VALIDATE_INT);
            //Check if the user wants to set up an appointment without creating an account or login in 
            $guest = filter_input(INPUT_GET, 'guest', FILTER_SANITIZE_STRING);
            if ($guest == ''){
                if(isset($_SESSION['guest'])){
                    $guest = $_SESSION['guest'];
                    unset($_SESSION['guest']);
                }
            }
            //Usent the redirect url if it is set 
            if(isset($_SESSION['redirectURL'])){
                unset($_SESSION['redirectURL']);
            }
            //Check if there is a curent session to associate the appointment to that user
            if(!isset($_SESSION['clientData'])){
                //If there is not a current session check if the guest parameter has not been set to true
                if(!$guest){
                    $_SESSION['redirectURL'] = ROOT_URI . "controllers/appointments/?action=create_appointment_view&inv_id=$inv_id";
                    //prompt to sign in or to continue as a guest
                    header('Location: ' . ROOT_URI . 'controllers/accounts/?action=view_loginOrGuest');
                    exit;
                }
            }
            //Check that a valid  inv_id was passed to this controller
            $vehicleInfo = getInvItemInfo($inv_id);
            //Get the vehicle thumbnail 
            $vehicleMainTnImage = getVehiclePrimaryImageTn($inv_id);
            if (empty($vehicleInfo)){
                $message = 'No inventory infomrmation found';
                $notificationType = 'error_message';
                $noSubmit = true;
            }
            //Get the input data and results, if any 
            if(isset($_SESSION['input'])){
                //Set the input errors
                if(isset($_SESSION['input']['inputErrors'])){
                    $clientFirstnameErr = $_SESSION['input']['inputErrors']['clientFirstnameErr'];
                    $appointmentDateErr = $_SESSION['input']['inputErrors']['appointmentDateErr'];
                    $appointmentTimeErr = $_SESSION['input']['inputErrors']['appointmentTimeErr'];
                    $clientPhoneNumberErr =  $_SESSION['input']['inputErrors']['clientPhoneNumberErr'];
                }
                //Set the input values
                $appointmentInfo['client_first_name'] = $_SESSION['input']['inputValues']['client_first_name'];
                $appointmentInfo['appointment_date'] = $_SESSION['input']['inputValues']['appointment_date'];
                $appointmentInfo['appointment_time'] = $_SESSION['input']['inputValues']['appointment_time'];
                $appointmentInfo['client_phone_number'] = $_SESSION['input']['inputValues']['client_phone_number'];
                //Unset the input SESSION variables
                unset($_SESSION['input']);
            }
            // Get the array of classifications. This is needed for almost every view
            $classifications = getClassifications();
            include ABS_ROOT_FILE_PATH . '/views/create_appointment_view.php';
            exit; 
            break;
        //Creates a new appointment in the database
        case 'createAppointment':
            // Store the incoming information
            $appointment_date = filter_input(INPUT_POST, 'appointment_date', FILTER_SANITIZE_STRING);
            $appointment_time = filter_input(INPUT_POST, 'appointment_time', FILTER_SANITIZE_STRING);
            $client_first_name = filter_input(INPUT_POST, 'client_first_name', FILTER_SANITIZE_STRING);
            $client_phone_number = filter_input(INPUT_POST, 'client_phone_number', FILTER_SANITIZE_STRING);
            $client_id = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);
            $inv_id = filter_input(INPUT_POST, 'inv_id', FILTER_VALIDATE_INT);
            $guest = filter_input(INPUT_POST, 'guest', FILTER_SANITIZE_STRING);
            //Check that the inv_id was passed to this controller
            $vehicleInfo = getInvItemInfo($inv_id);
            if (empty($vehicleInfo)){
                // Redirect to the create appointment view to notify the user that a vehicle was not found
                $_SESSION['guest'] = $guest;
                header("Location: " . ROOT_URI . "/controllers/appointments/?action=create_appointment_view&inv_id=$inv_id");
                exit; 
            }
            //Check that the name is valid 
            $vlaidName = validateNameOrLastName($client_first_name);
            //Check phone number format 
            $validPhoneNumber = validatePhoneNumber($client_phone_number);
            //Validate the date 
            $validDate = validateTestDriveAppointmentDate($appointment_date);
            //Validate the time
            $validTime = validateTestDriveAppointmentTime($appointment_time); 
            //Check that the necesary values where passed 
            //Track input errors 
            $appointmentDateErr = $appointmentTimeErr = $clientNameErr = $clientPhoneNumberErr = "";
            if (!$validDate || !$validTime || empty($vlaidName) || !$validPhoneNumber ) {
                $_SESSION['message'] = 'One or more fields are missing or invalid';
                $_SESSION['notificationType'] = 'error_message';
                //Set the input errors
                $_SESSION['input']['inputErrors']['clientFirstnameErr'] = empty($vlaidName) ? ' input_error' : "";
                $_SESSION['input']['inputErrors']['appointmentDateErr'] = !$validDate ? ' input_error' : "";
                $_SESSION['input']['inputErrors']['appointmentTimeErr'] = !$validTime ? ' input_error' : "";
                $_SESSION['input']['inputErrors']['clientPhoneNumberErr'] = !$validPhoneNumber ? ' input_error' : "";
                //Set the input values
                $_SESSION['input']['inputValues']['client_first_name'] = $client_first_name;
                $_SESSION['input']['inputValues']['appointment_date'] = $appointment_date;
                $_SESSION['input']['inputValues']['appointment_time'] = $appointment_time;
                $_SESSION['input']['inputValues']['client_phone_number'] = $client_phone_number;
                $_SESSION['guest'] = $guest;
                //Redirect to the case that renders the update appointment view
                header("Location: " . ROOT_URI . "controllers/appointments/?action=create_appointment_view&inv_id=$inv_id");
                exit; 
            }
            // Send the data to the appointments model
            $outcome = createAppointment($appointment_date, $appointment_time, $client_first_name, $client_phone_number, $client_id, $inv_id);
            // Check and report the result
            if($outcome === 1){
                $_SESSION['message'] = "Your test drive has been sucesfuly scheduled for $appointment_date at $appointment_time";
                //If there is an active session prompt the user to go to his/ her account to manage his/her appointments 
                if(isset($_SESSION['clientData'])){
                    $_SESSION['message'] .= "  Go to your account to view and update the apointment details";
                }
                $_SESSION['notificationType']  = 'success_message';
                header("Location: " . ROOT_URI . "controllers/vehicles/?action=view_vehicle_details&inv_id=$inv_id");
                exit;
            } else {
                $_SESSION['message'] = "Something went wrong. Try again or use different values.";
                $_SESSION['notificationType'] = 'error_message';
                //Set the input values
                $_SESSION['input']['inputValues']['client_first_name'] = $client_first_name;
                $_SESSION['input']['inputValues']['appointment_date'] = $appointment_date;
                $_SESSION['input']['inputValues']['appointment_time'] = $appointment_time;
                $_SESSION['input']['inputValues']['client_phone_number'] = $client_phone_number;
                $_SESSION['guest'] = $guest;
                header("Location: " . ROOT_URI . "controllers/appointments/?action=create_appointment_view&inv_id=$inv_id");
                exit;
            }
            break;
        //Renders the appointment details view if the user has proper rights
        case 'view_update_appointment':
            //Get and filter the input values form the query string 
            $appointment_id = filter_input(INPUT_GET, 'appointment_id', FILTER_VALIDATE_INT);
            //Check if  the appointment does not exist 
            $appointmentInfo = getAppointmentInfo($appointment_id);
            if(empty($appointmentInfo)){
                if(isset($_SESSION['input'])){
                    unset($_SESSION['input']);
                }
                $_SESSION['message'] = 'No information found for the requested appointment';
                $_SESSION['notificationType'] = 'error_message';
                //Redirect to the page that shows all the appointments in the user account
                header('Location: ' . ROOT_URI . 'controllers/appointments/');
                exit;
            }
            handleAdminOrClientRequest($appointmentInfo, function(){
                global $appointmentInfo;
                //Get the input data and results, if any 
                if(isset($_SESSION['input'])){
                    //Set the input errors
                    if(isset($_SESSION['input']['inputErrors'])){
                        $appointmentDateErr = $_SESSION['input']['inputErrors']['appointmentDateErr'];
                        $appointmentTimeErr = $_SESSION['input']['inputErrors']['appointmentTimeErr'];
                        $clientPhoneNumberErr =  $_SESSION['input']['inputErrors']['clientPhoneNumberErr'];
                    }
                    //Set the input values
                    $appointmentInfo['appointment_date'] = $_SESSION['input']['inputValues']['appointment_date'];
                    $appointmentInfo['appointment_time'] = $_SESSION['input']['inputValues']['appointment_time'];
                    $appointmentInfo['client_phone_number'] = $_SESSION['input']['inputValues']['client_phone_number'];
                    //Unset the input SESSION variable
                    unset($_SESSION['input']);
                }
                //Get the vehicle information 
                $vehicleInfo = getInvItemInfo($appointmentInfo['inv_id']);
                //Get the vehicle thumbnail 
                 $vehicleMainTnImage = getVehiclePrimaryImageTn($appointmentInfo['inv_id']);
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the update appointment view
                include ABS_ROOT_FILE_PATH . '/views/update_appointment_view.php';
                //Unset session message variables 
                if(isset($_SESSION['message']))
                    unset($_SESSION['message']);
                if(isset($_SESSION['notificationType']))
                    unset($_SESSION['notificationType']);
                exit;
            });
            break;
        //Updates the appointment information in the database if the user has proper rights
        case 'updateAppointment':
            // Store the incoming information
            $appointment_date = filter_input(INPUT_POST, 'appointment_date', FILTER_SANITIZE_STRING);
            $appointment_time = filter_input(INPUT_POST, 'appointment_time', FILTER_SANITIZE_STRING);
            $client_phone_number = filter_input(INPUT_POST, 'client_phone_number', FILTER_SANITIZE_STRING);
            $appointment_id = filter_input(INPUT_POST, 'appointment_id', FILTER_SANITIZE_NUMBER_INT);
            //Check if  the appointment does not exist 
            $appointmentInfo = getAppointmentInfo($appointment_id);
            if(empty($appointmentInfo)){
                $_SESSION['message'] = 'No information found for the requested appointment';
                $_SESSION['notificationType'] = 'error_message';
                ///Redirect to the page that shows all the appointments in the user account
                header('Location: ' . ROOT_URI . 'controllers/appointments');
                exit;
            }
            handleAdminOrClientRequest($appointmentInfo, function(){
                global $client_phone_number, $appointment_date, $appointment_time, $appointment_id;
                //Check phone number format 
                $validPhoneNumber = validatePhoneNumber($client_phone_number);
                //Validate the date 
                $validDate = validateTestDriveAppointmentDate($appointment_date);
                //Validate the time
                $validTime = validateTestDriveAppointmentTime($appointment_time); 
                //Validate the data
                if (!$validDate || !$validTime || !$validPhoneNumber ) {
                    $_SESSION['message'] = 'One or more fields are missing or invalid';
                    $_SESSION['notificationType'] = 'error_message';
                    //Set the input errors
                    $_SESSION['input']['inputErrors']['appointmentDateErr'] = !$validDate ? ' input_error' : "";
                    $_SESSION['input']['inputErrors']['appointmentTimeErr'] = !$validTime ? ' input_error' : "";
                    $_SESSION['input']['inputErrors']['clientPhoneNumberErr'] = !$validPhoneNumber ? ' input_error' : "";
                    //Set the input values
                    $_SESSION['input']['inputValues']['appointment_date'] = $appointment_date;
                    $_SESSION['input']['inputValues']['appointment_time'] = $appointment_time;
                    $_SESSION['input']['inputValues']['client_phone_number'] = $client_phone_number;
                    //Redirect to the case that renders the update appointment view
                    header("Location: " . ROOT_URI . "controllers/appointments/?action=view_update_appointment&appointment_id=$appointment_id");
                    exit; 
                }
                // Send the data to the appointments model
                $outcome = editAppointment($appointment_id, $appointment_date, $appointment_time, $client_phone_number);
                //Check and report the result
                if($outcome === 1){
                    $_SESSION['message'] = "Your appointment has been sucesfuly updated";
                    $_SESSION['notificationType']  = 'success_message';
                    header("Location: " . ROOT_URI . "controllers/appointments/");
                    exit;
                }
                $_SESSION['message'] = "Something went wrong. Try again or use different values.";
                $_SESSION['notificationType'] = 'error_message';
                //Set the input values
                $_SESSION['input']['inputValues']['appointment_date'] = $appointment_date;
                $_SESSION['input']['inputValues']['appointment_time'] = $appointment_time;
                $_SESSION['input']['inputValues']['client_phone_number'] = $client_phone_number;
                //Redirect to the case that renders the update appointment view
                header("Location: " . ROOT_URI . "controllers/appointments/?action=view_update_appointment&appointment_id=$appointment_id");
                exit;
            });
            break;
        //Updates the appointment information in the database if the user has proper rights
        case 'cancelAppointment':
            // Store the incoming information
            $appointment_id = filter_input(INPUT_GET, 'appointment_id', FILTER_SANITIZE_NUMBER_INT);
            //Check if  the appointment does not exist 
            $appointmentInfo = getAppointmentInfo($appointment_id);
            if(empty($appointmentInfo)){
                $_SESSION['message'] = 'No information found for the requested appointment';
                $_SESSION['notificationType'] = 'error_message';
                ///Redirect to the page that shows all the appointments in the user account
                header('Location: ' . ROOT_URI . 'controllers/appointments');
                exit;
            }
            handleAdminOrClientRequest($appointmentInfo, function(){
                global $appointment_id;
                // Send the data to the appointments model
                $outcome = deleteAppointment($appointment_id);
                //Check and report the result
                if($outcome === 1){
                    //The message will be different depending on the client Level 
                    if($_SESSION['clientData']['client_level'] > 1){
                        $_SESSION['message'] = "Your appointment has been sucesfuly cancelled. Please, make sure that the  customer has been notified";
                    }
                    else{
                        $_SESSION['message'] = "Your appointment has been sucesfuly cancelled.";
                    }
                    $_SESSION['notificationType']  = 'success_message';
                    header("Location: " . ROOT_URI . "controllers/appointments/");
                    exit;
                }
                $_SESSION['message'] = "Something went wrong. Unable to delete appointment";
                $_SESSION['notificationType'] = 'error_message';
                //Redirect to the case that renders the update appointment view
                header("Location:" . ROOT_URI . "controllers/appointments/?action=view_update_appointment&appointment_id=$appointment_id");
                exit;
            });
            break;
        //Renders all the upcomming appoitments for the client and all the appointments for the admin user
        default:
            //Check that there is not a current session
            if(!isset($_SESSION['clientData'])){
                //redirect to the accounts controller to render the login view
                $_SESSION['message'] = 'Login to view  your appointments';
                $_SESSION['notificationType'] = 'error_message';
                header("Location: " . ROOT_URI . "controllers/accounts/");
                exit;
            }
            $client_level = $_SESSION['clientData']['client_level'];
            if( $client_level == 1){
                //Get upcomming appointments for only the customer
                $upcomingAppointments = getClientUpcomingAppointments($_SESSION['clientData']['client_id']);
            }
            else{
                //Get all the appointments in the DB
                $upcomingAppointments = getAllUpcomingAppointments();
                $pastAppointments = getAllExpiredAppointments();
            }
            //Check that there are appointments in the database and that there are no other errors to display 
            if (count($upcomingAppointments) == 0 && !isset($_SESSION['message'])){
                $message = 'No upcomming appointments found';
                $notificationType = 'error_message';
            }
            // Get the array of classifications. This is needed for almost every view
            $classifications = getClassifications();
            include ABS_ROOT_FILE_PATH . '/views/appointments_view.php';
            //Unset notification variables
            if(isset($_SESSION['message']))
                unset($_SESSION['message']);
            if(isset($_SESSION['notificationType']))
                unset($_SESSION['notificationType']);
            exit; 
            break;
    }
?>                