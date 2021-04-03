<?php
/*********************************************************************/
/*   Functions to check credentials for admin requests  */
/*********************************************************************/
    //Handle admin requests. This function makes sure that there is an active session 
    //and that the user logged in has proper rights. If it does, a call back function will be called. 
    function processAdminRequests($callback = NULL){
        //Check if there is not active session 
        if(isset($_SESSION['loggedin'])){
            //Check if the active variable is set to true
            if($_SESSION['loggedin']){
                //Check if the session has proper wrights to access the vehicles controller 
                if($_SESSION['clientData']['clientLevel'] > 1){
                    //If a callback function was passed call the call back function
                    if($callback != NULL){
                        $callback();
                    }
                    //Stop this function to continue the caller's code. This will prevent the default code at the end
                    return;
                }
                else{
                    //Redirect to the account controller, but set the message and notification Type
                    $_SESSION['message'] = 'Unauthorized to perform the requested action';
                    $_SESSION['notificationType'] = 'error_message';
                    header("Location: " . ROOT_URI . "controllers/accounts/");
                    exit;
                    return;
                }
            }
        }
        //If there is not an active session redirect to the login view 
        //Redirect to the account controller, but set the message and notification Type
        $_SESSION['message'] = 'Sign in with an admin account to perform the requested action';
        $_SESSION['notificationType'] = 'error_message';
        header("Location: " . ROOT_URI . "/controllers/accounts/");
        exit;
    }
    //Handle admin requests for Json data. This function makes sure that there is an active session 
    //and that the user logged in has proper rights. If it does, a call back function will be called. 
    function processAdminRequestsForJson($callback = NULL){
        //Check if there is not active session 
        if(isset($_SESSION['loggedin'])){
            //Check if the active variable is set to true
            if($_SESSION['loggedin']){
                //Check if the session has proper wrights to access the vehicles controller 
                if($_SESSION['clientData']['clientLevel'] > 1){
                    //If a callback function was passed call the call back function
                    if($callback != NULL){
                        $callback();
                    }
                    //Stop this function to continue the caller's code. This will prevent the default code at the end
                    return;
                }
                else{
                    //If the user has no proper rights return a Json object indicatign that the user has no prper rights
                    http_response_code(401);
                    $response = array(
                        'status' => 401,
                        'Error' => 'No proper rights to process this requrest'
                    );
                    header('Content-type:application/json;charset=utf-8');
                    echo json_encode($response);
                    exit;
                }
            }
        }
        //If there is not an active session  return a Json object indicatign that the user has no prper rights                
        http_response_code(401);
        $response = array(
            'status' => 401,
            'Error' => 'Session with proper rights has not been initialized'
        );
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($response);
        exit;
        return;
    }

?>