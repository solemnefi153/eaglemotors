<?php 
    /*************************************************/
    /*      This is the car classifications model    */
    /*************************************************/ 
    //This function will create a new car classification in the database
    function addCarClassification($classificationName){
        // Create a connection object using the eaglemotors connection function
        $db = eaglemotorsConnect();
        // The SQL statement
        $sql = 'INSERT INTO carclassification (classificationName) VALUES (:classificationName)';
        // Create the prepared statement using the eaglemotors connection
        $stmt = $db->prepare($sql);
        // The next four lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
        // Insert the data
        $stmt->execute();
        // Ask how many rows changed as a result of our insert
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
    }
    //Returns all the car classifications stored in the database 
    function getClassifications(){
        // Create a connection object from the eaglemotors connection function
        $db = eaglemotorsConnect(); 
        // The SQL statement to be used with the database 
        $sql = 'SELECT classificationName, classificationId FROM carclassification ORDER BY classificationName ASC'; 
        // The next line creates the prepared statement using the eaglemotors connection      
        $stmt = $db->prepare($sql);
        // The next line runs the prepared statement 
        $stmt->execute(); 
        // The next line gets the data from the database and 
        // stores it as an array in the $classifications variable 
        $classifications = $stmt->fetchAll(); 
        // The next line closes the interaction with the database 
        $stmt->closeCursor(); 
        // The next line sends the array of data back to where the function 
        // was called (this should be the controller) 
        return $classifications;
    }
?>