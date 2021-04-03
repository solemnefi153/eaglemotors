function confirmAppointmentCancelation(event){
    event.preventDefault();
    //After confirmation follow the link
    if(confirm('Are you sure you want to cancel this appointment?')){
        window.location =  event.target.href;
    }
};