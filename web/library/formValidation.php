<?php
/**************************************/
/*       Validation functions         */
/**************************************/
    //Returns the email passed to this function if the email is valid 
    //Otherwise it will return a null value 
    function checkEmail($clientEmail){
        $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
        return $valEmail;
    }
    // Check the password for a minimum of 8 characters,
    // at least one 1 capital letter, at least 1 number and
    // at least 1 special character
    function checkPassword($clientPassword){
        $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
        return preg_match($pattern, $clientPassword);
    }
    //Check that the value is a float and that is a possitive number
    function checkPrice($price) {
        //We dont want 
        $pattern = '/^(\d+\.\d{1,2})$/';
        return preg_match($pattern, $price);
    }
    //Check that the value is a float and that is a possitive number
    function checkPositiveNumber($number) {
        $valNumber = filter_var($number, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
        return $valNumber;
    }
    //Validates the format of a phone number 
    function validatePhoneNumber($phoneNumber){
        if($phoneNumber == ''){
            return true;
        }
        else{
            $pattern = '/^([0-9]{3}-[0-9]{3}-[0-9]{4})$/';
            return preg_match($pattern, $phoneNumber);
        }
    }
    //Validate test drive  date format
    function validateTestDriveAppointmentDate($date){
        $pattern = '/^([0-9]{4}-[0-9]{2}-[0-9]{2})$/';
        //Check that the date has the proper format
        if(preg_match($pattern, $date)){
            $formatedDate = strtotime($date);
            $weekDay = date('w', $formatedDate);
            //Check that the date is on a weekday
            if($weekDay != 0 && $weekDay != 6){
                //Check that the date is not before today or later than two weeks
                if($date >= date("Y-m-d") && $date <= date('Y-m-d', strtotime("+15 day"))){
                    return true;
                }
            }
        }
        return false;
    }
    //Validate test drive time
    function validateTestDriveAppointmentTime($time){
        $pattern1 = '/^([0-9]{2}:[0-9]{2})$/';
        $pattern2 = '/^([0-9]{2}:[0-9]{2}:[0-9]{2})$/';
        //Check that the time has the proper format
        if(preg_match($pattern1, $time) || preg_match($pattern2, $time)){
            //Check that the time is during working hrs
            if(strtotime($time) >= strtotime("9:00:00") && strtotime($time) < strtotime("17:00:00")){
                return true;
            }
        }
        return false;
    }
    //Validate the format of a name or last name
    function validateNameOrLastName($nameOrLastname){
        if($nameOrLastname == ''){
            return false;
        }
        $pattern = "/^[a-zA-Z ,.'-]+$/";
        return preg_match($pattern, $nameOrLastname);
    }

?>