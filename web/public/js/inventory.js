'use strict' 
 
// Get a list of vehicles in inventory based on the classificationId 
let classificationList = document.querySelector("#classificationList"); 
classificationList.addEventListener("change", function () { 
    let classificationId = classificationList.value; 
    let classIdURL = ROOT_URI + "controllers/vehicles/index.php?action=getInventoryItems&classificationId=" + classificationId; 
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
    let inventoryDisplay = document.getElementById("inventoryDisplay"); 
    // Set up the table labels 
    let dataTable = '<thead>'; 
    dataTable += '<tr><th>Vehicle Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>'; 
    dataTable += '</thead>'; 
    // Set up the table body 
    dataTable += '<tbody>'; 
    // Iterate over all vehicles in the array and put each in a row 
    data.forEach(function (element) { 
        dataTable += `<tr><td>${element.invMake} ${element.invModel}</td>`; 
        dataTable += "<td><a href='" + ROOT_URI + `controllers/vehicles?action=view_modify_vehicle&id=${element.invId}' title='Click to modify'>Modify</a></td>`; 
        dataTable += "<td><a href='" + ROOT_URI + `controllers/vehicles?action=view_delete_vehicle&id=${element.invId}' title='Click to delete'>Delete</a></td></tr>`; 
    }) 
    dataTable += '</tbody>'; 
    // Display the contents in the Vehicle Management view 
    inventoryDisplay.innerHTML = dataTable; 
}