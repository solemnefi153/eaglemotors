<?php 
    /*************************************************/
    /*           This is the home route              */
    /*************************************************/ 
    //Create or access a Session
    session_start();
    //Get the application configuration setting depending on the environment
    require_once "../../app-config.php";
    //This  imprts the home controller 
    require ABS_ROOT_FILE_PATH . '/controllers/home/index.php';
?> 