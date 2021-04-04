'use strict' 
 
// Get a list of vehicles in inventory based on the classificationId 
let classificationList = document.querySelector("#classificationList"); 
classificationList.addEventListener("change", function () { 
    let classification_id = classificationList.value; 
    let classIdURL = ROOT_URI + "controllers/vehicles/index.php?action=getInventoryItems&classification_id=" + classification_id; 
    fetch(classIdURL) 
    .then(function (response) { 
        if (response.ok) { 
            return response.json(); 
        } 
        throw Error("Network response was not OK"); 
    }) 
    .then(function (data) { 
        buildInventoryList(data); 
    }) 
    .catch(function (error) { 
        console.log('There was a problem: ', error.message) 
    }) 
})

// Build inventory items into HTML table components and inject into DOM 
function buildInventoryList(data) { 
    console.log(data);
    let inventoryDisplay = document.getElementById("inventoryDisplay"); 
    // Set up the table labels 
    let dataTable = '<table class="small_table">'; 
    dataTable += '<tr class="table_headers" ><th>Vehicle Name</th><td>&nbsp;</td></tr>'; 
    // Set up the table body 
    // Iterate over all vehicles in the array and put each in a row 
    data.forEach(function (element) { 
        dataTable += `<tr><td class='medium_td' >${element.inv_make} ${element.inv_model}</td>`; 
        dataTable += "<td class='buttons_td'><a class='primary_btn' href='" + ROOT_URI + `controllers/vehicles?action=view_modify_vehicle&inv_id=${element.inv_id}' title='Click to modify'>Modify</a>`; 
        dataTable += "<a class='danger_btn'  href='" + ROOT_URI + `controllers/vehicles?action=view_delete_vehicle&inv_id=${element.inv_id}' title='Click to delete'>Delete</a></td></tr>`; 
    }) 
    dataTable += '</table>'; 
    // Display the contents in the Vehicle Management view 
    inventoryDisplay.innerHTML = dataTable; 
}