var nameInput = document.getElementById('clientFirstname')
//Add event listener to the date input field
nameInput.addEventListener('input' , (function(e) {
    if(nameInput.value == '') {
        nameInput.classList.add('input_error');
    } else {
        nameInput.classList.remove('input_error');
    }
}))

var dateInput = document.getElementById('appointmentDate')
//Add event listener to the date input field
dateInput.addEventListener('change' , (function(e) {
    var d = new Date(e.target.value)
    if(d.getDay() === 6 || d.getDay() === 5) {
        dateInput.classList.add('input_error');
    } else {
        dateInput.classList.remove('input_error');
    }
}))

var timeInput = document.getElementById('appointmentTime')
//Add event listener to the date input field
timeInput.addEventListener('change' , (function(e) {
    const selectedTime = new Date("01/01/2000 "+ timeInput.value);
    const startShift = new Date("01/01/2000 "+ "09:00:00");
    const endShift = new Date("01/01/2000 "+ "17:00:00");
    if(selectedTime <  startShift || selectedTime >= endShift ) {

        timeInput.classList.add('input_error');
    } else {
        timeInput.classList.remove('input_error');
    }
}))

var phoneInput = document.getElementById('clientPhoneNumber')
//Add event listener to the date input field
phoneInput.addEventListener('input' , (function(e) {
    const selectedTime = phoneInput.value;
    const regex = new RegExp( '^([0-9]{3}-[0-9]{3}-[0-9]{4})$');
    if(!regex.test(selectedTime)) {
        console.log('Wrong format')
        phoneInput.classList.add('input_error');
    } else {
        phoneInput.classList.remove('input_error');

    }
}))


                