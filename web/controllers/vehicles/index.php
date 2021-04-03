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
                    'invMake' => filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING),
                    'invModel' => filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING),
                    'invDescription' => filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING),
                    'invPrice' => filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'invStock' => filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT),
                    'invColor' => filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING),
                    'classificationId' => filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT)
                );
                //Validate input 
                $validPrice = checkPrice($newVehicle['invPrice']);
                $newVehicle['invStock'] = checkPositiveNumber($newVehicle['invStock']);
                //Track input errors 
                $invMakeErr = $invModelErr = $invDescriptionErr = $invPriceErr = $invStockErr = $invColorErr = $classificationIdErr = "";
                // Check for missing data
                if(empty($newVehicle['invMake']) || empty($newVehicle['invModel']) || empty($newVehicle['invDescription']) || empty($validPrice) || 
                   empty($newVehicle['invStock']) || empty($newVehicle['invColor']) || empty($newVehicle['classificationId'])){
                    $message = 'One or more fields are missing or invalid';
                    $notificationType = 'error_message';
                    $invMakeErr = empty($newVehicle['invMake']) ? ' input_error' : "";
                    $invModelErr = empty($newVehicle['invModel']) ? ' input_error' : "";
                    $invDescriptionErr = empty($newVehicle['invDescription']) ? ' input_error' : "";
                    $invStockErr = empty($newVehicle['invStock']) ? ' input_error' : "";
                    $invColorErr = empty($newVehicle['invColor']) ? ' input_error' : "";
                    $classificationIdErr = empty($newVehicle['classificationId']) ? ' input_error' : "";
                    if(empty($validPrice)){
                        $invPriceErr = ' input_error';
                        $newVehicle['invPrice'] = '';
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
                    $_SESSION['message'] = "The $newVehicle[invMake] $newVehicle[invModel] was successfully added to the inventory";
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
                $classificationName =  filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING);
                //Track missing data 
                $classificationNameErr = "";
                // Check for missing data
                if(empty($classificationName)){
                    $message = 'Missing car classification name';
                    $classificationNameErr =  ' input_error';
                    $notificationType = 'error_message';
                    // Get the array of classifications. This is needed for almost every view
                    $classifications = getClassifications();
                    include ABS_ROOT_FILE_PATH . '/views/add_car_classification.php';
                    exit; 
                }
                // Send the data to the car classifications model
                $outcome = addCarClassification($classificationName);
                // Check and report the result
                if($outcome === 1){
                    $_SESSION['message'] = "The $classificationName classification was succesfuly created";
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
        //Get vehicles by classificationId if the user had proper credentials 
        case 'getInventoryItems': 
            //Verify credentials
            processAdminRequests(function (){
                // Get the classificationId 
                $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
                // Fetch the vehicles by classificationId from the DB 
                $inventoryArray = getInventoryByClassification($classificationId); 
                // Convert the array to a JSON object and send it back 
                echo json_encode($inventoryArray); 
            });
            break;
        //Renders the modify vechilce view if the user that made the requrest has proper credentials
        case 'view_modify_vehicle':
            processAdminRequests(function (){
                // Filter and store the data
                $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                $vehicleInfo = getInvItemInfo($invId);
                $vehicleMainTnImage = getVehiclePrimaryImageTn($invId);
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
                    'invMake' => filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING),
                    'invModel' => filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING),
                    'invDescription' => filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING),
                    'invPrice' => filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'invStock' => filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT),
                    'invColor' => filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING),
                    'classificationId' => filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT), 
                    'invId' => filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT)
                );
                $vehicleMainTnImage = getVehiclePrimaryImageTn($vehicleInfo['invId']);
                //Validate input 
                $validPrice = checkPrice($vehicleInfo['invPrice']);
                $vehicleInfo['invStock'] = checkPositiveNumber($vehicleInfo['invStock']);
                //Track input errors 
                $invMakeErr = $invModelErr = $invDescriptionErr = $invPriceErr = $invStockErr = $invColorErr = $classificationIdErr = "";
                // Check for missing data
                if(empty($vehicleInfo['invMake']) || empty($vehicleInfo['invModel']) || empty($vehicleInfo['invDescription']) ||  empty($vehicleInfo) || 
                   empty($vehicleInfo['invStock']) || empty($vehicleInfo['invColor']) || empty($vehicleInfo['classificationId'])){
                    $message = 'One or more fields are missing or invalid';
                    $notificationType = 'error_message';
                    $invMakeErr = empty($vehicleInfo['invMake']) ? ' input_error' : "";
                    $invModelErr = empty($vehicleInfo['invModel']) ? ' input_error' : "";
                    $invDescriptionErr = empty($vehicleInfo['invDescription']) ? ' input_error' : "";
                    $invStockErr = empty($vehicleInfo['invStock']) ? ' input_error' : "";
                    $invColorErr = empty($vehicleInfo['invColor']) ? ' input_error' : "";
                    $classificationIdErr = empty($vehicleInfo['classificationId']) ? ' input_error' : "";
                    if(empty($validPrice)){
                        $invPriceErr = ' input_error';
                        $vehicleInfo['invPrice'] = '';
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
                    $_SESSION['message'] = "The $vehicleInfo[invMake] $vehicleInfo[invModel] was successfully updated";
                    $_SESSION['notificationType']  = 'success_message';
                    header("Location: " . ROOT_URI . "controllers/vehicles/");
                    exit;
                } else {
                    // Get the array of classifications. This is needed for almost every view
                    $classifications = getClassifications();
                    $message = "Error: the $vehicleInfo[invMake] $vehicleInfo[invModel] was not updated.";
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
                $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                $vehicleInfo = getInvItemInfo($invId);
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
                $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
                $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
                $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
                // Send the request to the vehicles model
                $deleteResult = deleteVehicle($invId);
                if ($deleteResult) {
                    //Also delete the images here ******
                    $message = "Congratulations the, $invMake $invModel was	successfully deleted, please manualy remove the images from the server";
                    $_SESSION['message'] = $message;
                    $_SESSION['notificationType'] = 'success_message';
                    header('location: ' . ROOT_URI . 'controllers/vehicles/');
                    exit;
                } 
                else {
                    $message = "Error: $invMake $invModel was not deleted";
                    $_SESSION['message'] = $message;
                    $_SESSION['notificationType'] = 'error_message';
                    header('location: ' . ROOT_URI . 'controllers/vehicles/');
                    exit;
                }
            });			
            break;
        //Renders a view with all the vehicles for a specified classification
        case 'classification':
            $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
            $vehicles = getVehiclesByClassification($classificationName);
            if(!count($vehicles)){
                $message = "Sorry, no $classificationName vehicles could be found.";
                $notificationType = 'error_message';
            } 
            // Get the array of classifications. This is needed for almost every view
            $classifications = getClassifications();
            include ABS_ROOT_FILE_PATH . '/views/classification.php';
            exit;
            break;
        //Renders the vehicle details page if a specific vehicle
        case 'view_vehicle_details':
            $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
            $vehicleInfo = getInvItemInfo($invId);
            //Check that the vehicle information was found
            if (empty($vehicleInfo)) {
                $message = 'Sorry, no vehicle information could be found.';
                $notificationType =  ' error_message';
            }
            else{
                //Get all the vehicle images
                $primaryImage = getVehiclePrimaryImage($invId);
                $thumbnails = getVehicleThumbnails($invId);
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