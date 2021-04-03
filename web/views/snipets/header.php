<header>
    <img id="main_logo" src='<?php echo ROOT_URI; ?>public/images/site/logo_eagle.png' alt='logo'>
    <div id='header_text'>
        <?php 
            //Check if there is an actice session
            if(isset($_SESSION['clientData'])){
                //If there is an active session the My Account link will redirect to the accounts controller and the default case will render the user's account
                echo "<a href='" . ROOT_URI. "controllers/accounts/' class='my_account_link'>My Account</a>\n";
                //This link will call the accounts controller and logout the user. The accounts controller will then redirect to the accounts controller,
                // but this time the singin view will be rendered
                echo "<a href='" . ROOT_URI. "controllers/accounts/?action=logout' class='my_account_link'>Log Out</a>\n";
            } 
            else{
                //If there is not an actice active the accounts controller will be called and the sing in view will be rendered. 
                echo "<a href='" . ROOT_URI. "controllers/accounts/' class='my_account_link'>Log In</a>\n";
            }
        ?>
    </div>
</header>