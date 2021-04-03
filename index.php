<?php 
    //The purpose of this file is to re route users to the root or home route located in the web folder 
    //Heroku will use the web folder as the main folder for the web application
    //XAMPP and other hosting services might use another folder as the main folder
    //This is a solution to overcome file structure specifications
    //This project will give priority to Heroku's file structure specification
    header('Location: /eaglemotors/web');
?> 