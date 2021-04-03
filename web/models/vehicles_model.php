<?php 
    /*
        This is the car Vehilces model
    */
    //Adds a car into the database
    function addCarToInvelntory($newVehicle){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invPrice, invStock, invColor, classificationId)
            VALUES (:invMake, :invModel, :invDescription, :invPrice, :invStock, :invColor, :classificationId)';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':invMake', $newVehicle['invMake'], PDO::PARAM_STR);
        $stmt->bindValue(':invModel', $newVehicle['invModel'], PDO::PARAM_STR);
        $stmt->bindValue(':invDescription', $newVehicle['invDescription'], PDO::PARAM_STR);
        $stmt->bindValue(':invPrice', $newVehicle['invPrice'], PDO::PARAM_STR);
        $stmt->bindValue(':invStock', $newVehicle['invStock'], PDO::PARAM_INT);
        $stmt->bindValue(':invColor', $newVehicle['invColor'], PDO::PARAM_STR);
        $stmt->bindValue(':classificationId', $newVehicle['classificationId'], PDO::PARAM_INT);
        // Insert the data
        $stmt->execute();
        // Ask how many rows changed as a result of our insert
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
    }
    //Get all the vehicles' information from the database 
    function getVehicles(){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'SELECT invId, invMake, invModel FROM inventory';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // Run the query 
        $stmt->execute();
        // Grab all the rows that were returnded from the query
        $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the rows that we got from the query
        return $invInfo; 
    }
    // Get vehicles by classificationId 
    function getInventoryByClassification($classificationId){ 
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next  line replaces the placeholder in the SQL
        // statement with the actual value in the variable
        // and tells the database the type of data it is
        $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
        // Run the query 
        $stmt->execute();
        // Grab all the rows that were returnded from the query
        $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the rows that we got from the query
        return $inventory; 
    }
    //Get vehicles by classification name
    function getVehiclesByClassification($classificationName){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'SELECT * FROM inventory JOIN images ON inventory.invId = images.invId WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName) AND imgPrimary = 1 AND imgPath LIKE "%-tn%";';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
        // Insert the data
        $stmt->execute();
        // Get the all the rows from the results
        $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return all the rows that were returned in the query
        return $inventory; 
    }
    // Get vehicle information by invId
    function getInvItemInfo($invId){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); ;
        $sql = 'SELECT * FROM inventory WHERE invId = :invId';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
        // Insert the data
        $stmt->execute();
        // Get the invenroty information form the query
        $invInfo = $stmt->fetch(PDO::FETCH_ASSOC); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the inventory information
        return $invInfo; 
    }
   //Updates a vehicle in the database
   function updateVehicle($vehicleInfo){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, 
	        invDescription = :invDescription, invPrice = :invPrice, 
	        invStock = :invStock, invColor = :invColor, 
	        classificationId = :classificationId WHERE invId = :invId';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':invMake', $vehicleInfo['invMake'], PDO::PARAM_STR);
        $stmt->bindValue(':invModel', $vehicleInfo['invModel'], PDO::PARAM_STR);
        $stmt->bindValue(':invDescription', $vehicleInfo['invDescription'], PDO::PARAM_STR);
        $stmt->bindValue(':invPrice', $vehicleInfo['invPrice'], PDO::PARAM_STR);
        $stmt->bindValue(':invStock', $vehicleInfo['invStock'], PDO::PARAM_INT);
        $stmt->bindValue(':invColor', $vehicleInfo['invColor'], PDO::PARAM_STR);
        $stmt->bindValue(':classificationId', $vehicleInfo['classificationId'], PDO::PARAM_INT);
        $stmt->bindValue(':invId', $vehicleInfo['invId'], PDO::PARAM_INT);
        // Update  the vehicledata
        $stmt->execute();
        // Ask how many rows changed as a result of the update
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
   }
   //Deletes a vehicle from the database 
   function deleteVehicle($invId) {
       // Create a connection object from the eaglemotors connection function
       $db = eaglemotorsConnect(); 
       $sql = 'DELETE FROM inventory WHERE invId = :invId';
       // Create the prepared statement using the eaglemotors connection
       $stmt = $db->prepare($sql);
       // The next four lines replace the placeholders in the SQL
       // statement with the actual values in the variables
       // and tells the database the type of data it is
       $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
       // Update  the vehicledata
       $stmt->execute();
       // Ask how many rows changed as a result of our insert
       $rowsChanged = $stmt->rowCount();
       // Close the database interaction
       $stmt->closeCursor();
       // Return the indication of success (rows changed)
       return $rowsChanged;
   }
//    $sql = 'SELECT * FROM inventory JOIN images ON inventory.invId = images.invId WHERE inventory.invId = :invId AND imgPrimary != 0 AND imgPath LIKE "%-tn%";';
?>