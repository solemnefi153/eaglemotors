<?php 
    /*************************************************/
    /*        This is the car Vehilces model         */
    /*************************************************/
    //Adds a car into the database
    function addCarToInvelntory($newVehicle){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'INSERT INTO inventory (inv_make, inv_model, inv_description, inv_price, inv_stock, inv_color, classification_id)
            VALUES (:inv_make, :inv_model, :inv_description, :inv_price, :inv_stock, :inv_color, :classification_id)';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':inv_make', $newVehicle['inv_make'], PDO::PARAM_STR);
        $stmt->bindValue(':inv_model', $newVehicle['inv_model'], PDO::PARAM_STR);
        $stmt->bindValue(':inv_description', $newVehicle['inv_description'], PDO::PARAM_STR);
        $stmt->bindValue(':inv_price', $newVehicle['inv_price'], PDO::PARAM_STR);
        $stmt->bindValue(':inv_stock', $newVehicle['inv_stock'], PDO::PARAM_INT);
        $stmt->bindValue(':inv_color', $newVehicle['inv_color'], PDO::PARAM_STR);
        $stmt->bindValue(':classification_id', $newVehicle['classification_id'], PDO::PARAM_INT);
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
        $sql = 'SELECT inv_id, inv_make, inv_model FROM inventory';
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
    // Get vehicles by classification_id 
    function getInventoryByClassification($classification_id){ 
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = ' SELECT * FROM inventory WHERE classification_id = :classification_id'; 
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next  line replaces the placeholder in the SQL
        // statement with the actual value in the variable
        // and tells the database the type of data it is
        $stmt->bindValue(':classification_id', $classification_id, PDO::PARAM_INT); 
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
    function getVehiclesByClassification($classification_name){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = "SELECT * FROM inventory JOIN images ON inventory.inv_id = images.inv_id WHERE classification_id IN (SELECT classification_id FROM carclassification WHERE classification_name = :classification_name) AND img_primary = 1 AND img_path LIKE '%-tn%';";
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':classification_name', $classification_name, PDO::PARAM_STR);
        // Insert the data
        $stmt->execute();
        // Get the all the rows from the results
        $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return all the rows that were returned in the query
        return $inventory; 
    }
    // Get vehicle information by inv_id
    function getInvItemInfo($inv_id){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); ;
        $sql = 'SELECT * FROM inventory WHERE inv_id = :inv_id';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':inv_id', $inv_id, PDO::PARAM_INT);
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
        $sql = 'UPDATE inventory SET inv_make = :inv_make, inv_model = :inv_model, 
	        inv_description = :inv_description, inv_price = :inv_price, 
	        inv_stock = :inv_stock, inv_color = :inv_color, 
	        classification_id = :classification_id WHERE inv_id = :inv_id';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':inv_make', $vehicleInfo['inv_make'], PDO::PARAM_STR);
        $stmt->bindValue(':inv_model', $vehicleInfo['inv_model'], PDO::PARAM_STR);
        $stmt->bindValue(':inv_description', $vehicleInfo['inv_description'], PDO::PARAM_STR);
        $stmt->bindValue(':inv_price', $vehicleInfo['inv_price'], PDO::PARAM_STR);
        $stmt->bindValue(':inv_stock', $vehicleInfo['inv_stock'], PDO::PARAM_INT);
        $stmt->bindValue(':inv_color', $vehicleInfo['inv_color'], PDO::PARAM_STR);
        $stmt->bindValue(':classification_id', $vehicleInfo['classification_id'], PDO::PARAM_INT);
        $stmt->bindValue(':inv_id', $vehicleInfo['inv_id'], PDO::PARAM_INT);
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
   function deleteVehicle($inv_id) {
       // Create a connection object from the eaglemotors connection function
       $db = eaglemotorsConnect(); 
       $sql = 'DELETE FROM inventory WHERE inv_id = :inv_id';
       // Create the prepared statement using the eaglemotors connection
       $stmt = $db->prepare($sql);
       // The next four lines replace the placeholders in the SQL
       // statement with the actual values in the variables
       // and tells the database the type of data it is
       $stmt->bindValue(':inv_id', $inv_id, PDO::PARAM_INT);
       // Update  the vehicledata
       $stmt->execute();
       // Ask how many rows changed as a result of our insert
       $rowsChanged = $stmt->rowCount();
       // Close the database interaction
       $stmt->closeCursor();
       // Return the indication of success (rows changed)
       return $rowsChanged;
   }
//    $sql = 'SELECT * FROM inventory JOIN images ON inventory.inv_id = images.inv_id WHERE inventory.inv_id = :inv_id AND img_primary != 0 AND img_path LIKE "%-tn%";';
?>