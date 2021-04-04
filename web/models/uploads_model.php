<?php 
    /*************************************************/
    /*        This is the Image Upload model         */
    /*************************************************/
    // Add image information to the database table
    function storeImages($img_path, $inv_id, $img_name, $img_primary) {
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'INSERT INTO images (inv_id, img_path, img_name, img_primary) VALUES (:inv_id, :img_path, :img_name, :img_primary)';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // Store the full size image information
        $stmt->bindValue(':inv_id', $inv_id, PDO::PARAM_INT);
        $stmt->bindValue(':img_path', $img_path, PDO::PARAM_STR);
        $stmt->bindValue(':img_name', $img_name, PDO::PARAM_STR);
        $stmt->bindValue(':img_primary', $img_primary, PDO::PARAM_INT);
        // Run the query 
        $stmt->execute();
        //Ask how many rows were changed
        $rowsChanged = $stmt->rowCount(); 
        $newImgId = $db->lastInsertId();
        //Check that the previous insert was successful
        if( $rowsChanged == 1){
            // Make and store the thumbnail image information
            // Change name in path
            $img_path = makeThumbnailName($img_path);
            // Change name in file name
            $img_name = makeThumbnailName($img_name);
            $stmt->bindValue(':inv_id', $inv_id, PDO::PARAM_INT);
            $stmt->bindValue(':img_path', $img_path, PDO::PARAM_STR);
            $stmt->bindValue(':img_name', $img_name, PDO::PARAM_STR);
            $stmt->bindValue(':img_primary', $img_primary, PDO::PARAM_INT);
            // Run the query 
            $stmt->execute();
            //Ask how many rows were changed
            $rowsChanged = $stmt->rowCount(); 
            if($rowsChanged == 1){
                // Close the database interaction
                $stmt->closeCursor();
                // Return the number of rows that we got from the query
                return $rowsChanged; 
            }
            else{
                //Delete the first insert in the db
                deleteImage($newImgId);
                //Return 0
                return 0;
            }
        }
        return 0;
    }
    // Get Image Information from images table
    function getImages() {
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'SELECT img_id, img_path, img_name, img_date, inventory.inv_id, inv_make, inv_model FROM images JOIN inventory ON images.inv_id = inventory.inv_id';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // Run the query 
        $stmt->execute();
        // Grab all the rows that were returnded from the query
        $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the rows that we got from the query
        return $imageArray; 
    }
    // Check for an existing image
    function checkExistingImage($img_name){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = "SELECT img_name FROM images WHERE img_name = :img_name";
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':img_name', $img_name, PDO::PARAM_STR);
        // Run the query 
        $stmt->execute();
        // Count how many rows were changed
        $imageMatch = $stmt->fetch(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the result that was found, if any. 
        return $imageMatch; 
   }
    //Queries for the primary image of a vehicle 
    function getVehiclePrimaryImage($inv_id){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'SELECT img_path, img_name FROM images JOIN inventory ON images.inv_id = inventory.inv_id WHERE inventory.inv_id = :inv_id AND img_primary = 1 AND img_path NOT LIKE "%-tn%";';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':inv_id', $inv_id, PDO::PARAM_INT);
        // Run the query 
        $stmt->execute();
        // Grab the row that was returnded from the query, if any
        $imageData = $stmt->fetch(PDO::FETCH_ASSOC); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the data 
        return $imageData; 
    }
    //Queries for the primary image of a vehicle 
    function getVehiclePrimaryImageTn($inv_id){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'SELECT img_path, img_name FROM images JOIN inventory ON images.inv_id = inventory.inv_id WHERE inventory.inv_id = :inv_id AND img_primary = 1 AND img_path LIKE "%-tn%";';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':inv_id', $inv_id, PDO::PARAM_INT);
        // Run the query 
        $stmt->execute();
        // Grab the row that was returnded from the query, if any
        $imageData = $stmt->fetch(PDO::FETCH_ASSOC); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the data 
        return $imageData; 
    }
    //Queries for all the thumbnail images of a vehicle
    function getVehicleThumbnails($inv_id){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'SELECT img_path, img_name FROM images JOIN inventory ON images.inv_id = inventory.inv_id WHERE inventory.inv_id = :inv_id  AND img_path LIKE "%tn%";';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':inv_id', $inv_id, PDO::PARAM_INT);
        // Run the query 
        $stmt->execute();
        // Grab all the rows that were returnded from the query
        $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the rows that we got from the query
        return $imageArray; 
    }
    // Delete image information from the images table
    function deleteImage($img_id) {
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'DELETE FROM images WHERE img_id = :img_id';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':img_id', $img_id, PDO::PARAM_INT);
        // Run the query 
        $stmt->execute();
        // Count how many rows were changed
        $result = $stmt->rowCount(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the rows that we got from the query
        return $result; 
   }
 
?>