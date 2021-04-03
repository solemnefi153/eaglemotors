<?php
/*************************************************************************/
/*   Functions to check session credentials requests  */
/*************************************************************************/
    //Check the user credentials to authorize to performe the action determined by the callback
    function handleAdminOrClientRequest($appointmentInfo, $callback){
        //Check if there is a curent session and if the curren user has access rights view and  modify the appointment
        if(isset($_SESSION['clientData'])){
            //The client level has to be greated that 1 or the client Id associated with the appointment needs to be the same than the user currently logged in
            if($_SESSION['clientData']['clientLevel'] > 1 || $_SESSION['clientData']['clientId'] == $appointmentInfo['clientId']){
                $callback();
                exit;
            }
            else{
                //Notify that the user is not authorized to see or update the appointment
                $_SESSION['message'] = 'Unauthorized to perform the requested action';
                $_SESSION['notificationType'] = "error_message";
                //Redirect to the user account 
                header("Location: " . ROOT_URI . "controllers/accounts/");
                exit;
            }
        }
        else{
            //Redirect to the accounts controller to render the login view
            //Notify that the user is not authorized to see or update the appointment
            $_SESSION['message'] = 'Sign in  to perform the requested action';
            $_SESSION['notificationType'] = "error_message";
            header("Location: " . ROOT_URI . "controllers/accounts/");
            exit;
        }
    }
?>