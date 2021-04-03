<?php 
    /*************************************************/
    /*          This is the root  controller         */
    /*************************************************/ 
    //Take action depending on the request method
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            //Redirect to the home route
            header("Location: " . ROOT_URI . "ap/home");
            exit;
        default: 
            http_response_code(405);
            echo "HTTP Status 405 – Method  $_SERVER[REQUEST_METHOD] Not Allowed ";
    }
?> 