<?php 
    /*************************************************/
    /*           This is the root route              */
    /*************************************************/ 
    //Create or access a Session
    session_start();
    //Get the application configuration setting depending on the environment
    require_once "./app-config.php";
    //This imprts the root controller 
    require ABS_ROOT_FILE_PATH . '/controllers/root/index.php';
?> 