<?php 
//Proxy connection to the heroku  database 
    function databaseConnect(){
        try
        {
            $dbUrl = getenv('DATABASE_URL');
            $dbOpts = parse_url($dbUrl);
            $dbHost = $dbOpts["host"];
            $dbPort = $dbOpts["port"];
            $dbUser = $dbOpts["user"];
            $dbPassword = $dbOpts["pass"];
            $dbName = ltrim($dbOpts["path"],'/');
            $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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