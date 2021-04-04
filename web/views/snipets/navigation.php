<nav>
    <?php
    // Build a navigation bar using the $classifications array
    $nav = "<a class='nav_link' href='" . ROOT_URI . "' title='View the Eagle Motors home page'>Home</a>";
    if(isset($classifications)){
        foreach ($classifications as $classification) {
            $nav .= "<a class='nav_link' href='" . ROOT_URI . "controllers/vehicles/?action=classification&classification_name=".urlencode($classification['classification_name'])."' title='View our $classification[classification_name] product line'>$classification[classification_name]</a>";
        }
    }
    echo $nav; 
    // print_r($classifications)
    ?>
</nav>