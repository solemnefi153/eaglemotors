<?php 
    /*
        This is the appointment model
    */
    //This function will create a new account (Client) in the database
    function createAppointment($appointmentDate, $appointmentTime, $clientFirstname, $clientPhoneNumber, $clientId, $invId){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'INSERT INTO appointments (appointmentDate, appointmentTime, clientFirstname, clientPhoneNumber, clientId, invId)
            VALUES (:appointmentDate, :appointmentTime, :clientFirstname, :clientPhoneNumber, :clientId, :invId)';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':appointmentDate', $appointmentDate, PDO::PARAM_STR);
        $stmt->bindValue(':appointmentTime', $appointmentTime, PDO::PARAM_STR);
        $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
        $stmt->bindValue(':clientPhoneNumber', $clientPhoneNumber, PDO::PARAM_STR);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
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
    function getAppointmentInfo($appointmentId){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.invId = inventory.invId WHERE appointmentId = :appointmentId';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':appointmentId', $appointmentId, PDO::PARAM_INT);
        $stmt->execute();
        // Fetch all the info
        $appointmentInfo = $stmt->fetch(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the  appointment information 
        return $appointmentInfo;
    }
    //Gets all the client upcomming appointments
    function getClientUpcomingAppointments($clientId){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.invId = inventory.invId  WHERE clientId = :clientId and appointmentDate >= CURDATE();';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
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
        // The SQL statement
        $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.invId = inventory.invId WHERE appointmentDate >= CURDATE();';
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
        // The SQL statement
        $sql = 'SELECT * FROM  appointments JOIN inventory ON appointments.invId = inventory.invId WHERE appointmentDate < CURDATE();';
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
    function editAppointment($appointmentId, $appointmentDate, $appointmentTime, $clientPhoneNumber){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'UPDATE appointments SET appointmentDate = :appointmentDate, appointmentTime = :appointmentTime, 
            clientPhoneNumber = :clientPhoneNumber WHERE appointmentId = :appointmentId';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':appointmentDate', $appointmentDate, PDO::PARAM_STR);
        $stmt->bindValue(':appointmentTime', $appointmentTime, PDO::PARAM_STR);
        $stmt->bindValue(':clientPhoneNumber', $clientPhoneNumber, PDO::PARAM_STR);
        $stmt->bindValue(':appointmentId', $appointmentId, PDO::PARAM_INT);
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
    function deleteAppointment($appointmentId) {
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'DELETE FROM appointments WHERE appointmentId = :appointmentId';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':appointmentId', $appointmentId, PDO::PARAM_INT);
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