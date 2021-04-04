<?php 
session_start();
//This is the Vehicles controller 
    //Get the application configuration setting depending on the environment
    require_once "../../app-config.php";
    //make sure all errors are catched  
    require_once ABS_ROOT_FILE_PATH . '/library/catchErrors.php';
    // Get the necesary models
    require_once ABS_ROOT_FILE_PATH . '/models/car_classifications_model.php';
    require_once ABS_ROOT_FILE_PATH . '/models/vehicles_model.php';
    require_once ABS_ROOT_FILE_PATH . '/models/uploads_model.php';
    //Import some utility functions 
    require_once ABS_ROOT_FILE_PATH . '/library/handleAdminRequests.php';
    require_once ABS_ROOT_FILE_PATH . '/library/catchErrors.php';
    require_once ABS_ROOT_FILE_PATH . '/library/formValidation.php';
    //Grab the action from the requrest
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
    }
    switch ($action){
        //Renders the add vehicle  view if the user that made the requrest has proper credentials
        case 'view_add_vehicle':
            //Verify credentials 
            processAdminRequests(function (){
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                include ABS_ROOT_FILE_PATH . '/views/add_vehicle.php';
                //Unset notification variables
                if(isset($_SESSION['message']))
                    unset($_SESSION['message']);
                if(isset($_SESSION['notificationType']))
                    unset($_SESSION['notificationType']);
                exit;
            });
            break;
        //Adds a vechicle to the inventory if the user that made the requrest has proper credentials
        case 'addVehicleToInventory':
            //Verify credentials 
            processAdminRequests(function (){
                // Sanitize and store the data
                $newVehicle =  array(
                    'inv_make' => filter_input(INPUT_POST, 'inv_make', FILTER_SANITIZE_STRING),
                    'inv_model' => filter_input(INPUT_POST, 'inv_model', FILTER_SANITIZE_STRING),
                    'inv_description' => filter_input(INPUT_POST, 'inv_description', FILTER_SANITIZE_STRING),
                    'inv_price' => filter_input(INPUT_POST, 'inv_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'inv_stock' => filter_input(INPUT_POST, 'inv_stock', FILTER_SANITIZE_NUMBER_INT),
                    'inv_color' => filter_input(INPUT_POST, 'inv_color', FILTER_SANITIZE_STRING),
                    'classification_id' => filter_input(INPUT_POST, 'classification_id', FILTER_SANITIZE_NUMBER_INT)
                );
                //Validate input 
                $validPrice = checkPrice($newVehicle['inv_price']);
                $newVehicle['inv_stock'] = checkPositiveNumber($newVehicle['inv_stock']);
                //Track input errors 
                $invMakeErr = $invModelErr = $invDescriptionErr = $invPriceErr = $invStockErr = $invColorErr = $classificationIdErr = "";
                // Check for missing data
                if(empty($newVehicle['inv_make']) || empty($newVehicle['inv_model']) || empty($newVehicle['inv_description']) || empty($validPrice) || 
                   empty($newVehicle['inv_stock']) || empty($newVehicle['inv_color']) || empty($newVehicle['classification_id'])){
                    $message = 'One or more fields are missing or invalid';
                    $notificationType = 'error_message';
                    $invMakeErr = empty($newVehicle['inv_make']) ? ' input_error' : "";
                    $invModelErr = empty($newVehicle['inv_model']) ? ' input_error' : "";
                    $invDescriptionErr = empty($newVehicle['inv_description']) ? ' input_error' : "";
                    $invStockErr = empty($newVehicle['inv_stock']) ? ' input_error' : "";
                    $invColorErr = empty($newVehicle['inv_color']) ? ' input_error' : "";
                    $classificationIdErr = empty($newVehicle['classification_id']) ? ' input_error' : "";
                    if(empty($validPrice)){
                        $invPriceErr = ' input_error';
                        $newVehicle['inv_price'] = '';
                    } 
                    else{
                        $invPriceErr = "";
                    }
                    // Get the array of classifications. This is needed for almost every view
                    $classifications = getClassifications();
                    include ABS_ROOT_FILE_PATH . '/views/add_vehicle.php';
                    exit; 
                }
                // Send the data to the vehicles model
                $outcome = addCarToInvelntory($newVehicle);
                // Check and report the result
                if($outcome === 1){
                    $_SESSION['message'] = "The $newVehicle[inv_make] $newVehicle[inv_model] was successfully added to the inventory";
                    $_SESSION['notificationType']  = 'success_message';
                    header("Location: " . ROOT_URI . "controllers/vehicles/");
                    exit;
                } else {
                    // Get the array of classifications. This is needed for almost every view
                    $classifications = getClassifications();
                    $message = "Something went wrong. Try again or use different values.";
                    $notificationType = 'error_message';
                    include ABS_ROOT_FILE_PATH . '/views/add_vehicle.php';
                    exit;
                }
            });
            break;
        //Renders the add car classification view if the user that made the requrest has proper credentials
        case 'view_add_car_classification':
            //Verify credentials 
            processAdminRequests(function (){
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the add car classification  view 
                include ABS_ROOT_FILE_PATH . '/views/add_car_classification.php';
                //Unset notification variables
                if(isset($_SESSION['message']))
                    unset($_SESSION['message']);
                if(isset($_SESSION['notificationType']))
                    unset($_SESSION['notificationType']);
                exit;
            });
            break;
        //Adds a car classification if the user that made the requrest has proper credentials
        case 'addCarClassification':
            //Verify credentials 
            processAdminRequests(function (){
                // Filter and store the data
                $classification_name =  filter_input(INPUT_POST, 'classification_name', FILTER_SANITIZE_STRING);
                //Track missing data 
                $classificationNameErr = "";
                // Check for missing data
                if(empty($classification_name)){
                    $message = 'Missing car classification name';
                    $classificationNameErr =  ' input_error';
                    $notificationType = 'error_message';
                    // Get the array of classifications. This is needed for almost every view
                    $classifications = getClassifications();
                    include ABS_ROOT_FILE_PATH . '/views/add_car_classification.php';
                    exit; 
                }
                // Send the data to the car classifications model
                $outcome = addCarClassification($classification_name);
                // Check and report the result
                if($outcome === 1){
                    $_SESSION['message'] = "The $classification_name classification was succesfuly created";
                    $_SESSION['notificationType'] = 'success_message';
                    header("Location: " . ROOT_URI . "controllers/vehicles/");
                    exit;
                } else {
                    // Get the array of classifications. This is needed for almost every view
                    $classifications = getClassifications();
                    $message = "Unable to add classification. Plase try again or type a different name";
                    $notificationType = 'error_message';
                    include ABS_ROOT_FILE_PATH . '/views/add_car_classification.php';
                    exit;
                }
            });
            break;
        //Get vehicles by classification_id if the user had proper credentials 
        case 'getInventoryItems': 
            //Verify credentials
            processAdminRequests(function (){
                // Get the classification_id 
                $classification_id = filter_input(INPUT_GET, 'classification_id', FILTER_SANITIZE_NUMBER_INT); 
                // Fetch the vehicles by classification_id from the DB 
                $inventoryArray = getInventoryByClassification($classification_id); 
                // Convert the array to a JSON object and send it back 
                echo json_encode($inventoryArray); 
            });
            break;
        //Renders the modify vechilce view if the user that made the requrest has proper credentials
        case 'view_modify_vehicle':
            processAdminRequests(function (){
                // Filter and store the data
                $inv_id = filter_input(INPUT_GET, 'inv_id', FILTER_VALIDATE_INT);
                $vehicleInfo = getInvItemInfo($inv_id);
                $vehicleMainTnImage = getVehiclePrimaryImageTn($inv_id);
                //Variables for Vehicle information 
                if(empty($vehicleInfo)){
                    $message = 'Sorry, no vehicle information could be found.';
                    $notificationType =  ' error_message';
                }
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                include ABS_ROOT_FILE_PATH . '/views/vehicle_update.php';
                //Unset notification variables
                if(isset($_SESSION['message']))
                    unset($_SESSION['message']);
                if(isset($_SESSION['notificationType']))
                    unset($_SESSION['notificationType']);
                exit;
            });
            break;
        //Updates a vehicle from the database if the user that made the requrest has proper credentials
        case 'updateVehicle':
            //Verify credentials 
            processAdminRequests(function (){
                // Sanitize and store the data
                $vehicleInfo =  array(
                    'inv_make' => filter_input(INPUT_POST, 'inv_make', FILTER_SANITIZE_STRING),
                    'inv_model' => filter_input(INPUT_POST, 'inv_model', FILTER_SANITIZE_STRING),
                    'inv_description' => filter_input(INPUT_POST, 'inv_description', FILTER_SANITIZE_STRING),
                    'inv_price' => filter_input(INPUT_POST, 'inv_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'inv_stock' => filter_input(INPUT_POST, 'inv_stock', FILTER_SANITIZE_NUMBER_INT),
                    'inv_color' => filter_input(INPUT_POST, 'inv_color', FILTER_SANITIZE_STRING),
                    'classification_id' => filter_input(INPUT_POST, 'classification_id', FILTER_SANITIZE_NUMBER_INT), 
                    'inv_id' => filter_input(INPUT_POST, 'inv_id', FILTER_SANITIZE_NUMBER_INT)
                );
                $vehicleMainTnImage = getVehiclePrimaryImageTn($vehicleInfo['inv_id']);
                //Validate input 
                $validPrice = checkPrice($vehicleInfo['inv_price']);
                $vehicleInfo['inv_stock'] = checkPositiveNumber($vehicleInfo['inv_stock']);
                //Track input errors 
                $invMakeErr = $invModelErr = $invDescriptionErr = $invPriceErr = $invStockErr = $invColorErr = $classificationIdErr = "";
                // Check for missing data
                if(empty($vehicleInfo['inv_make']) || empty($vehicleInfo['inv_model']) || empty($vehicleInfo['inv_description']) ||  empty($vehicleInfo) || 
                   empty($vehicleInfo['inv_stock']) || empty($vehicleInfo['inv_color']) || empty($vehicleInfo['classification_id'])){
                    $message = 'One or more fields are missing or invalid';
                    $notificationType = 'error_message';
                    $invMakeErr = empty($vehicleInfo['inv_make']) ? ' input_error' : "";
                    $invModelErr = empty($vehicleInfo['inv_model']) ? ' input_error' : "";
                    $invDescriptionErr = empty($vehicleInfo['inv_description']) ? ' input_error' : "";
                    $invStockErr = empty($vehicleInfo['inv_stock']) ? ' input_error' : "";
                    $invColorErr = empty($vehicleInfo['inv_color']) ? ' input_error' : "";
                    $classificationIdErr = empty($vehicleInfo['classification_id']) ? ' input_error' : "";
                    if(empty($validPrice)){
                        $invPriceErr = ' input_error';
                        $vehicleInfo['inv_price'] = '';
                    } 
                    else{
                        $invPriceErr = "";
                    }
                    // Get the array of classifications. This is needed for almost every view
                    $classifications = getClassifications();
                    include ABS_ROOT_FILE_PATH . '/views/vehicle_update.php';
                    exit; 
                }
                // Send the data to the vehicles model
                $outcome = updateVehicle($vehicleInfo);
                // Check and report the result
                if($outcome === 1){
                    $_SESSION['message'] = "The $vehicleInfo[inv_make] $vehicleInfo[inv_model] was successfully updated";
                    $_SESSION['notificationType']  = 'success_message';
                    header("Location: " . ROOT_URI . "controllers/vehicles/");
                    exit;
                } else {
                    // Get the array of classifications. This is needed for almost every view
                    $classifications = getClassifications();
                    $message = "Error: the $vehicleInfo[inv_make] $vehicleInfo[inv_model] was not updated.";
                    $notificationType = 'error_message';
                    include ABS_ROOT_FILE_PATH . '/views/vehicle_update.php';
                    exit;
                }
            });
            break;    
        //Renders the delete vehicle view if the user that made the requrest has proper credentials 
        case 'view_delete_vehicle':
            processAdminRequests(function (){
                // Sanitize and store the data
                $inv_id = filter_input(INPUT_GET, 'inv_id', FILTER_VALIDATE_INT);
                $vehicleInfo = getInvItemInfo($inv_id);
                if (empty($vehicleInfo)) {
                    $message = 'Sorry, no vehicle information could be found.';
                    $notificationType =  ' error_message';
                }
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                include ABS_ROOT_FILE_PATH . '/views/vehicle_delete.php';
                //Unset notification variables
                if(isset($_SESSION['message']))
                    unset($_SESSION['message']);
                if(isset($_SESSION['notificationType']))
                    unset($_SESSION['notificationType']);
                exit; 
            });
            break;
        //Deletes a vehicle if the user that made the requrest has proper credentials
        case 'deleteVehicle':
            //Verify credentials 
            processAdminRequests(function (){
                // Sanitize and store the data
                $inv_make = filter_input(INPUT_POST, 'inv_make', FILTER_SANITIZE_STRING);
                $inv_model = filter_input(INPUT_POST, 'inv_model', FILTER_SANITIZE_STRING);
                $inv_id = filter_input(INPUT_POST, 'inv_id', FILTER_SANITIZE_NUMBER_INT);
                // Send the request to the vehicles model
                $deleteResult = deleteVehicle($inv_id);
                if ($deleteResult) {
                    //Also delete the images here ******
                    $message = "Congratulations the, $inv_make $inv_model was	successfully deleted, please manualy remove the images from the server";
                    $_SESSION['message'] = $message;
                    $_SESSION['notificationType'] = 'success_message';
                    header('location: ' . ROOT_URI . 'controllers/vehicles/');
                    exit;
                } 
                else {
                    $message = "Error: $inv_make $inv_model was not deleted";
                    $_SESSION['message'] = $message;
                    $_SESSION['notificationType'] = 'error_message';
                    header('location: ' . ROOT_URI . 'controllers/vehicles/');
                    exit;
                }
            });			
            break;
        //Renders a view with all the vehicles for a specified classification
        case 'classification':
            $classification_name = filter_input(INPUT_GET, 'classification_name', FILTER_SANITIZE_STRING);
            $vehicles = getVehiclesByClassification($classification_name);
            if(!count($vehicles)){
                $message = "Sorry, no $classification_name vehicles could be found.";
                $notificationType = 'error_message';
            } 
            // Get the array of classifications. This is needed for almost every view
            $classifications = getClassifications();
            include ABS_ROOT_FILE_PATH . '/views/classification.php';
            exit;
            break;
        //Renders the vehicle details page if a specific vehicle
        case 'view_vehicle_details':
            $inv_id = filter_input(INPUT_GET, 'inv_id', FILTER_VALIDATE_INT);
            $vehicleInfo = getInvItemInfo($inv_id);
            //Check that the vehicle information was found
            if (empty($vehicleInfo)) {
                $message = 'Sorry, no vehicle information could be found.';
                $notificationType =  ' error_message';
            }
            else{
                //Get all the vehicle images
                $primaryImage = getVehiclePrimaryImage($inv_id);
                $thumbnails = getVehicleThumbnails($inv_id);
            }
            // Get the array of classifications. This is needed for almost every view
            $classifications = getClassifications();
            include ABS_ROOT_FILE_PATH . '/views/vehicle_details.php';
            //Unset notification variables
            if(isset($_SESSION['message']))
                unset($_SESSION['message']);
            if(isset($_SESSION['notificationType']))
                unset($_SESSION['notificationType']);
            break;
        //Renders the vehicle management view if the user that made the requrest has proper credentials
        default:
            //Verify credentials 
            processAdminRequests(function (){
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                //Render the vehicle management view 
                include ABS_ROOT_FILE_PATH . '/views/vehicle_management.php';
                //Unset notification variables
                if(isset($_SESSION['message']))
                    unset($_SESSION['message']);
                if(isset($_SESSION['notificationType']))
                    unset($_SESSION['notificationType']);
                exit;
            });
    }
?>                