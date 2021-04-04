<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Request test drive | Eagle Motors, LLC.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/general_styles.css' media='screen'>
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/form_styles.css' media='screen'>
        <script src='<?php echo ROOT_URI; ?>public/js/appointmentFormValidation.js' defer ></script>
        <link href="<?php echo ROOT_URI; ?>public/images/site/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
        <div class='content'>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/header.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/navigation.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/notification_area.php'; ?>
            <main>
                <div class='form_container'>
                    <form class='custom_form' <?php if(isset($noSubmit)) {echo '';} else { echo "method='POST' action='" . ROOT_URI . "controllers/appointments/'";} ?>>
                        <h1 class='form_title'>Request a test drive</h1>
                        <label for='vehicle'>Vehicle</label>
                        <input type="text" class="form_input"  id='vehicle' disabled  value="<?php if(isset($vehicleInfo['inv_make'])) echo "$vehicleInfo[inv_make] $vehicleInfo[inv_model]";?>">
                        <input type='hidden' name='inv_id' value='<?php if(isset($inv_id)) echo $inv_id;?>' >
                        <?php if (!empty($vehicleMainTnImage)){
                            echo "<img class='form_image' src='" . ROOT_URI . "$vehicleMainTnImage[img_path]' title='$vehicleMainTnImage[img_name] image at eaglemotors.com'> ";
                        }
                        ?>
                        <label for='client_first_name'>Your name</label>
                        <input type="text" class="form_input <?php if(isset($clientFirstnameErr)) echo $clientFirstnameErr; ?>" id="client_first_name"  name="client_first_name"   value='<?php if(isset($_SESSION['clientData'])){ echo $_SESSION['clientData']['client_first_name']; } else if(isset($appointmentInfo['client_first_name'])) { echo $appointmentInfo['client_first_name']; }?>' <?php if(isset($_SESSION['clientData'])) {echo " disabled";} else {echo "required";} ?>  pattern="^[a-zA-Z ,.'-]+$">
                        <?php 
                            if(isset($_SESSION['clientData'])){
                                echo '<input type="hidden"   name="client_first_name"   value="' . $_SESSION['clientData']['client_first_name'] . '" >';
                            }
                        ?>
                        <input type="hidden"  id="client_id"  name="client_id"   value='<?php if(isset($_SESSION['clientData'])) echo $_SESSION['clientData']['client_id']; ?> '>
                        <label for='appointment_date'>Date</label>
                        <input type="date" class="form_input <?php if(isset($appointmentDateErr)) echo $appointmentDateErr; ?>" id="appointment_date"  name="appointment_date"   value='<?php if(isset($appointmentInfo['appointment_date'])) echo $appointmentInfo['appointment_date'];?>' min="<?php echo date("Y-m-d");?>" max="<?php echo date('Y-m-d', strtotime("+15 day"));?>" required>
                        <span id='dateWeekdayAlert' class="inputRequirements" >Date must be during weekdays</span>
                        <label for='appointment_time'>Time</label>
                        <input type="time" class="form_input <?php if(isset($appointmentTimeErr)) echo $appointmentTimeErr; ?>" id="appointment_time"  name="appointment_time"   value='<?php if(isset($appointmentInfo['appointment_time'])) echo $appointmentInfo['appointment_time'];?>' min='09:00' max='17:00' required>
                        <span  class="inputRequirements" >Available hours 9:00AM - 5:00PM</span>
                        <p class='form_p'>Type your phone number if you want to receive text reminders</p>
                        <label for='client_phone_number'>Phone number</label>
                        <input type="tel" class="form_input <?php if(isset($clientPhoneNumberErr)) echo $clientPhoneNumberErr; ?>" id="client_phone_number"  name="client_phone_number"   value='<?php if(isset($appointmentInfo['client_phone_number'])) echo $appointmentInfo['client_phone_number'];?>' pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" > 
                        <div class='inputRequirements'>
                            <span>Tel format: 123-456-7899</span>
                        </div>
                        <input type="submit" class="primary_btn" value="Submit request" <?php if(isset($noSubmit)) echo "disabled" ; ?> >
                        <input type="hidden" name='action' value="createAppointment">
                        <input type='hidden' name='guest' value='<?php if(isset($guest)) echo $guest;?> '>
                    </form>
                </div>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>
