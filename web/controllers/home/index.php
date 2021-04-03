<?php 
    /*************************************************/
    /*          This is the home  controller         */
    /*************************************************/ 
    //Require the necesary modules
    require ABS_ROOT_FILE_PATH . "/models/car_classifications_model.php";
    //load the car classifications needed for the nav bar
    $classifications = getClassifications();
    //Take action depending on the request method
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            //Render the home view
            require ABS_ROOT_FILE_PATH . '/views/home.php';
            exit;
        default: 
            http_response_code(405);
            echo "HTTP Status 405 – Method  $_SERVER[REQUEST_METHOD] Not Allowed ";
    }
?> 