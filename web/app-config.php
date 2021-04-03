<?php
//This file confugures some imprtant variables depending on the environmen 
//Check the readme file to find instructions to set up the environment variables
    // //Check tha the environment variable has been set
    // if(!getenv('ENVIRONMENT')){
    //     //Print a message to the console notifying that this variable is missing
    //     //Throw an error to stop the app
    // }
    // else{
    //     //Check that the environment variable ENVIRONMENT is set to development or production
    //     if(getenv('ENVIRONMENT') != 'development' && getenv('ENVIRONMENT') != 'development'){
    //         //Print a message to the console notifying that this variable is missing

    //         //Throw an error to stop the app
    //     }
    // }
    //The root uri for all the files
    if ( !defined('ROOT_URI') ){
           //Check if the application is hosted on heroku (production environmen)
           if(getenv('ENVIRONMENT') ==  'production'){
            define('ROOT_URI', '/');
        }
        //Case when the  application is hosted on XAMPP (development environmen)
        else{
            define('ROOT_URI', '/eaglemotors/web/');
        }
    }
    //Absolute root path for all files
    if ( !defined('ABS_ROOT_FILE_PATH') ){
        //Check if the application is hosted on heroku (production environmen)
        if(getenv('ENVIRONMENT') ==  'production'){
            define('ABS_ROOT_FILE_PATH', $_SERVER['DOCUMENT_ROOT']);
        }
        //Case when the  application is hosted on XAMPP (development environmen)
        else{
            define('ABS_ROOT_FILE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/eaglemotors/web');
        }
    }
    //Obtain the correct database connection function depending on the environment
    if(getenv('ENVIRONMENT') ==  'production'){
        //Connection to Heroku posgress DB
        require_once ABS_ROOT_FILE_PATH .'/db_connections/heroku_postgress_db_connection.php';
    }
    else {
        //Conection to the XAMPP maria DB
        require_once ABS_ROOT_FILE_PATH . '/db_connections/xampp_maria_db_connection.php';
    }   
?>