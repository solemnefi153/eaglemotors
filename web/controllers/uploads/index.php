<?php 
session_start();
//This is the Image Uploads controller 
    //Get the application configuration setting depending on the environment
    require_once "../../app-config.php";
    //Get the necesary models
    require_once ABS_ROOT_FILE_PATH . '/models/uploads_model.php';
    require_once ABS_ROOT_FILE_PATH . '/models/car_classifications_model.php';
    require_once ABS_ROOT_FILE_PATH . '/models/vehicles_model.php';
    //Import some utility functions 
    require_once ABS_ROOT_FILE_PATH . '/library/handleAdminRequests.php';
    require_once ABS_ROOT_FILE_PATH . '/library/handleImageUploads.php';
    require_once ABS_ROOT_FILE_PATH . '/library/catchErrors.php';
    // directory name where uploaded images are stored
    $image_dir = '/images/vehicles';
    // The path is the full path from the server root
    $image_dir_path = ABS_ROOT_FILE_PATH . $image_dir;
    //Grab the action from the requrest
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
    }
    switch ($action) {
        //Uploads an image on the server and adds the image path to the database
        case 'upload':
            processAdminRequests( function () {
                // Store the incoming vehicle id and primary picture indicator
                $invId = filter_input(INPUT_POST, 'invId', FILTER_VALIDATE_INT);
                $imgPrimary = filter_input(INPUT_POST, 'imgPrimary', FILTER_VALIDATE_INT);
                // Store the name of the uploaded image
                $imgName = $_FILES['file1']['name'];
                //Check that the necesary values where passed 
                if (!empty($invId) && !empty($imgName)) {
                    //Check if the image already exist on the server
                    $imageCheck = checkExistingImage($imgName);
                    if(!$imageCheck){
                        // Upload the image
                        //Store the returned path to the file
                        $imgPath = uploadFile('file1');
                        // Change name in path to get the Thumbnail path
                        $imgPathTh = makeThumbnailName($imgPath);
                        // Insert the images information to the database, get the result
                        $result = storeImages($imgPath, $invId, $imgName, $imgPrimary);
                        // Set a message based on the insert result
                        if ($result) {
                            // Store message to session
                            $_SESSION['message'] = 'Image was successfully uploaded';
                            $_SESSION['notificationType'] = 'success_message';
                        }  
                        else{
                            //Delete the images from the server
                            unlink(ROOT_URI .  $imgPath);
                            unlink(ROOT_URI  . $imgPathTh);
                            // Store message to session
                            $_SESSION['message'] = 'Failed to insert image path in the databse';
                            $_SESSION['notificationType'] = 'error_message';
                        }
                    } 
                    else{
                        // Store message to session
                        $_SESSION['message'] = 'An image with the same name already exists.';
                        $_SESSION['notificationType'] = 'error_message';
                    }
                } 
                else{
                    // Store message to session
                    $_SESSION['message'] = 'You must select a vehicle and image file for the vehicle';
                    $_SESSION['notificationType'] = 'error_message';
                }
                // Redirect to this controller for default action
                header('location: .');
                exit;
            });
            break;
        //Deletes an image from the server and removes the image path from the database
        case 'delete':
            processAdminRequests( function () {
                global $image_dir_path;
                // Get the image name and id
                $filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_STRING);
                $imgId = filter_input(INPUT_GET, 'imgId', FILTER_VALIDATE_INT);
                // Build the full path to the image to be deleted
                $target = $image_dir_path . '/' . $filename;
                // Check that the file exists in that location
                if (file_exists($target)) {
                    // Deletes the file in the folder
                    $result = unlink($target); 
                    
                    // Remove from database only if physical file deleted
                    if ($result) {
                        $remove = deleteImage($imgId);
                        // Set a message based on the delete result
                        if ($remove) {
                            $message = "$filename was successfully deleted";
                            $notificationType = 'success_message';
                        } else {
                            $message = "$filename was NOT deleted from the databse";
                            $notificationType = 'error_message';
                        }  
                    }
                    else{
                        $message = "An error occured while deleting the image from the server";
                        $notificationType = 'error_message';
                    }
                } 
                else{
                    $message = "Unable to delete Image: Image does not exist in the server";
                    $notificationType = 'error_message';
                }
                // Store message to session
                $_SESSION['message'] = $message;
                $_SESSION['notificationType'] = $notificationType;
                // Redirect to this controller for default action
                header('location: .');
            });
            break;
        //Renders the image management view
        default:
            processAdminRequests( function () {
                // Get the array of classifications. This is needed for almost every view
                $classifications = getClassifications();
                // Call function to return image info from database
                $imageArray = getImages();
                // Build the image information into HTML for display
                if (count($imageArray) == 0) {
                    $message = 'Sorry, no images could be found';
                    $notificationType = 'error_message';
                } 
                // Get vehicles information from database
                $vehicles = getVehicles();
                include ABS_ROOT_FILE_PATH . '/views/image-admin.php';
                //Unset notification variables
                if(isset($_SESSION['message']))
                unset($_SESSION['message']);
                if(isset($_SESSION['notificationType']))
                unset($_SESSION['notificationType']);
                exit;
            });
            break;
    }
?>                