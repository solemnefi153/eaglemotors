<?php 
/*
* Proxy connection to the eaglemotors database 
*/
    function eaglemotorsConnect(){
        $server = 'localhost';
        //change this to the environment variables
        $dbname= 'eaglemotors';
        $username = getenv('DATABASE_USERNAME');
        $password = getenv('DATABASE_PASSWORD'); 
        $dsn = "mysql:host=$server;dbname=$dbname";
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        // Create the actual connection object and assign it to a variable
        try {
        $db = new PDO($dsn, $username, $password, $options);
        return $db;
        } 
        catch (PDOException $ex)
        {
            http_response_code(500);
            $response = (object) array('status' => 500);
            $response->Error = 'Internal server error. Unable to connect to the database';
            header('Content-type:application/json;charset=utf-8');
            echo json_encode($response);
            die();
        }
    }
?>

