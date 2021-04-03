<?php 
    /*
        This is the car accounts model
    */
    //This function will create a new account (Client) in the database
    function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'INSERT INTO clients (clientFirstname, clientLastname,clientEmail, clientPassword)
            VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
        $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
        $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
        $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
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
    function findOtherAccountUsingThisEmail($clientEmail, $clientId){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'SELECT * FROM  clients WHERE clientEmail = :clientEmail AND NOT clientId = :clientId ;';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        // Insert the data
        $stmt->execute();
        // Fetch all the rows that were found
        $clientData = $stmt->fetchAll(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the  client data, 
        return $clientData;
    }
    // Get client data based on an email address
    function getClient($clientEmail){
         // Create a connection object using the eaglemotors connection function
         $db = eaglemotorsConnect();
         // The SQL statement
         $sql = 'SELECT * FROM  clients WHERE clientEmail = :clientEmail;';
         // Create the prepared statement using the eaglemotors connection
         $stmt = $db->prepare($sql);
         // The next four lines replace the placeholders in the SQL
         // statement with the actual values in the variables
         // and tells the database the type of data it is
         $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
         // Insert the data
         $stmt->execute();
         // Fetch one row form the results
         $clientData = $stmt->fetch(); 
         // Close the database interaction
         $stmt->closeCursor();
         // Return the  client data
         return $clientData;
    }
    // Get client data based on an email address
    function getClientById($clientId){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'SELECT * FROM  clients WHERE clientId = :clientId;';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
        // Insert the data
        $stmt->execute();
        // Fetch one row form the results
        $clientData = $stmt->fetch(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the  client data
        return $clientData;
    }
    //Update client information
    function updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, clientLastname = :clientLastname, 
	        clientEmail = :clientEmail WHERE clientId = :clientId';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
        $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
        $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        // Update  the client 
        $stmt->execute();
        // Ask how many rows changed as a result of the update
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
    }
    //Update client password
    function updateClientPassword($clientPassword, $clientId){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'UPDATE clients SET clientPassword = :clientPassword WHERE clientId = :clientId;';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        // Update  the client 
        $stmt->execute();
        // Ask how many rows changed as a result of the update
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
    }
?>