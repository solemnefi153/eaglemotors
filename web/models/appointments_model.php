<?php 
    /*************************************************/
    /*       This is the appointments model          */
    /*************************************************/ 
    //This function will create a new account (Client) in the database
    function createAppointment($appointment_date, $appointment_time, $client_first_name, $client_phone_number, $client_id, $inv_id){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'INSERT INTO appointments (appointment_date, appointment_time, client_first_name, client_phone_number, client_id, inv_id)
            VALUES (:appointment_date, :appointment_time, :client_first_name, :client_phone_number, :client_id, :inv_id)';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':appointment_date', $appointment_date, PDO::PARAM_STR);
        $stmt->bindValue(':appointment_time', $appointment_time, PDO::PARAM_STR);
        $stmt->bindValue(':client_first_name', $client_first_name, PDO::PARAM_STR);
        $stmt->bindValue(':client_phone_number', $client_phone_number, PDO::PARAM_STR);
        $stmt->bindValue(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->bindValue(':inv_id', $inv_id, PDO::PARAM_INT);
        // Insert the data
        $stmt->execute();
        // Ask how many rows changed as a result of our insert
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
    }
    //Check if an account is used by a user with a different ID that the one that was passed to this function
    function getAppointmentInfo($appointment_id){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.inv_id = inventory.inv_id WHERE appointment_id = :appointment_id';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':appointment_id', $appointment_id, PDO::PARAM_INT);
        $stmt->execute();
        // Fetch all the info
        $appointmentInfo = $stmt->fetch(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the  appointment information 
        return $appointmentInfo;
    }
    //Gets all the client upcomming appointments
    function getClientUpcomingAppointments($client_id){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement depending on the database
        if(getenv('ENVIRONMENT') == 'production'){
            $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.inv_id = inventory.inv_id  WHERE client_id = :client_id and appointment_date >= CURRENT_DATE;';
        }
        else{
            $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.inv_id = inventory.inv_id  WHERE client_id = :client_id and appointment_date >= CURDATE();';
        }
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->execute();
        // Fetch all the info
        $appointments = $stmt->fetchAll(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the  appointment information 
        return $appointments;
    }
    //Gets all the  upcomming appointments
    function getAllUpcomingAppointments(){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
         // The SQL statement depending on the database
         if(getenv('ENVIRONMENT') == 'production'){
            $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.inv_id = inventory.inv_id WHERE appointment_date >= CURRENT_DATE;';
        }
        else{
            $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.inv_id = inventory.inv_id WHERE appointment_date >= CURDATE();';
        }
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->execute();
        // Fetch all the info
        $appointments = $stmt->fetchAll(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the  appointment information 
        return $appointments;
    }
    //Gets all the  expired appointments
    function getAllExpiredAppointments(){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement depending on the database
        if(getenv('ENVIRONMENT') == 'production'){
            $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.inv_id = inventory.inv_id WHERE appointment_date < CURRENT_DATE;';
        }
        else{
            $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.inv_id = inventory.inv_id WHERE appointment_date < CURDATE();';
        }
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->execute();
        // Fetch all the info
        $appointments = $stmt->fetchAll(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the  appointment information 
        return $appointments;
    }
    //Updates an appointment in the database
    function editAppointment($appointment_id, $appointment_date, $appointment_time, $client_phone_number){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'UPDATE appointments SET appointment_date = :appointment_date, appointment_time = :appointment_time, 
            client_phone_number = :client_phone_number WHERE appointment_id = :appointment_id';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':appointment_date', $appointment_date, PDO::PARAM_STR);
        $stmt->bindValue(':appointment_time', $appointment_time, PDO::PARAM_STR);
        $stmt->bindValue(':client_phone_number', $client_phone_number, PDO::PARAM_STR);
        $stmt->bindValue(':appointment_id', $appointment_id, PDO::PARAM_INT);
        // Update  the appointment
        $stmt->execute();
        // Ask how many rows changed as a result of the update
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
    }
    //Deletes an appointment  from the database 
    function deleteAppointment($appointment_id) {
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'DELETE FROM appointments WHERE appointment_id = :appointment_id';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':appointment_id', $appointment_id, PDO::PARAM_INT);
        // Update  the vehicledata
        $stmt->execute();
        // Ask how many rows changed as a result of our insert
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
    }
?>