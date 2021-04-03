<?php 
    /*
        This is the Image Upload model
    */
    // Add image information to the database table
    function storeImages($imgPath, $invId, $imgName, $imgPrimary) {
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'INSERT INTO images (invId, imgPath, imgName, imgPrimary) VALUES (:invId, :imgPath, :imgName, :imgPrimary)';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // Store the full size image information
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
        $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
        $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
        $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_INT);
        // Run the query 
        $stmt->execute();
        //Ask how many rows were changed
        $rowsChanged = $stmt->rowCount(); 
        $newImgId = $db->lastInsertId();
        //Check that the previous insert was successful
        if( $rowsChanged == 1){
            // Make and store the thumbnail image information
            // Change name in path
            $imgPath = makeThumbnailName($imgPath);
            // Change name in file name
            $imgName = makeThumbnailName($imgName);
            $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
            $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
            $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
            $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_INT);
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
        //I need to change this to focus only on the images
        $sql = 'SELECT imgId, imgPath, imgName, imgDate, inventory.invId, invMake, invModel FROM images JOIN inventory ON images.invId = inventory.invId';
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
    //Queries for the primary image of a vehicle 
    function getVehiclePrimaryImage($invId){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'SELECT imgPath, imgName FROM images JOIN inventory ON images.invId = inventory.invId WHERE inventory.invId = :invId AND imgPrimary = 1 AND imgPath NOT LIKE "%-tn%";';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
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
    function getVehiclePrimaryImageTn($invId){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'SELECT imgPath, imgName FROM images JOIN inventory ON images.invId = inventory.invId WHERE inventory.invId = :invId AND imgPrimary = 1 AND imgPath LIKE "%-tn%";';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
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
    function getVehicleThumbnails($invId){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'SELECT imgPath, imgName FROM images JOIN inventory ON images.invId = inventory.invId WHERE inventory.invId = :invId  AND imgPath LIKE "%tn%";';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
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
    function deleteImage($imgId) {
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = 'DELETE FROM images WHERE imgId = :imgId';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':imgId', $imgId, PDO::PARAM_INT);
        // Run the query 
        $stmt->execute();
        // Count how many rows were changed
        $result = $stmt->rowCount(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the rows that we got from the query
        return $result; 
   }
   // Check for an existing image
    function checkExistingImage($imgName){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        $sql = "SELECT imgName FROM images WHERE imgName = :name";
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $imgName, PDO::PARAM_STR);
        // Run the query 
        $stmt->execute();
        // Count how many rows were changed
        $imageMatch = $stmt->fetch(); 
        // Close the database interaction
        $stmt->closeCursor();
        // Return the result that was found, if any. 
        return $imageMatch; 
   }
?>