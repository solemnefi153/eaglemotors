<?php 
    set_exception_handler(function($exception) {
        //Print the error in the server console
        error_log($exception);
        //Echo the restul to the client
        // $response = (object) array('status' => 500);
        // $response->error = 'Internal server error ';
        //echo json_encode($response);
        //For now echo all the errors to the client 
        echo $exception;
        http_response_code(500);
        //Redirect to the 500 page
        //Quit this call if the required fields are not present
        die();
    });
?>