<?php 
    /*************************************************/
    /*           This is the accounts model          */
    /*************************************************/ 
    //This function will create a new account (Client) in the database
    function regClient($client_first_name, $client_last_name, $client_email, $client_password){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'INSERT INTO clients (client_first_name, client_last_name, client_email, client_password)
            VALUES (:client_first_name, :client_last_name, :client_email, :client_password)';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':client_first_name', $client_first_name, PDO::PARAM_STR);
        $stmt->bindValue(':client_last_name', $client_last_name, PDO::PARAM_STR);
        $stmt->bindValue(':client_email', $client_email, PDO::PARAM_STR);
        $stmt->bindValue(':client_password', $client_password, PDO::PARAM_STR);
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
    function findOtherAccountUsingThisEmail($client_email, $client_id){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'SELECT * FROM  clients WHERE client_email = :client_email AND NOT client_id = :client_id ;';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':client_email', $client_email, PDO::PARAM_STR);
        $stmt->bindValue(':client_id', $client_id, PDO::PARAM_INT);
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
    function getClient($client_email){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'SELECT * FROM  clients WHERE client_email = :client_email;';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':client_email', $client_email, PDO::PARAM_STR);
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
    function getClientById($client_id){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'SELECT * FROM  clients WHERE client_id = :client_id;';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':client_id', $client_id, PDO::PARAM_STR);
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
    function updateClient($client_first_name, $client_last_name, $client_email, $client_id){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'UPDATE clients SET client_first_name = :client_first_name, client_last_name = :client_last_name, 
	        client_email = :client_email WHERE client_id = :client_id';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':client_first_name', $client_first_name, PDO::PARAM_STR);
        $stmt->bindValue(':client_last_name', $client_last_name, PDO::PARAM_STR);
        $stmt->bindValue(':client_email', $client_email, PDO::PARAM_STR);
        $stmt->bindValue(':client_id', $client_id, PDO::PARAM_INT);
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
    function updateClientPassword($client_password, $client_id){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'UPDATE clients SET client_password = :client_password WHERE client_id = :client_id;';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':client_password', $client_password, PDO::PARAM_STR);
        $stmt->bindValue(':client_id', $client_id, PDO::PARAM_INT);
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