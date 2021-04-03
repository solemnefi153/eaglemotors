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
                        <input type="text" class="form_input"  id='vehicle' disabled  name='makeAndModel' value="<?php if(isset($vehicleInfo['invMake'])) echo "$vehicleInfo[invMake] $vehicleInfo[invModel]";?>">
                        <input type='hidden' name='invId' value='<?php if(isset($invId)) echo $invId;?>' >
                        <img class='form_image' src='<?php if(isset($vehicleInfo['imgPath'])) echo ROOT_URI . $vehicleInfo['imgPath'];?>' title='<?php if(isset($vehicleInfo['invMake'])) echo "$vehicleInfo[invMake] $vehicleInfo[invModel] image";?>' alt='<?php if(isset($vehicleInfo['invMake'])) echo "$vehicleInfo[invMake] $vehicleInfo[invModel] image at eaglemotors.com";?>'> 
                        <label for='clientFirstname'>Your name</label>
                        <input type="text" class="form_input <?php if(isset($clientFirstnameErr)) echo $clientFirstnameErr; ?>" id="clientFirstname"  name="clientFirstname"   value='<?php if(isset($_SESSION['clientData'])){ echo $_SESSION['clientData']['clientFirstname']; } else if(isset($appointmentInfo['clientFirstname'])) { echo $appointmentInfo['clientFirstname']; }?>' <?php if(isset($_SESSION['clientData'])) {echo " disabled";} else {echo "required";} ?> >
                        <?php 
                            if(isset($_SESSION['clientData'])){
                                echo '<input type="hidden"   name="clientFirstname"   value="' . $_SESSION['clientData']['clientFirstname'] . '" >';
                            }
                        ?>
                        <input type="hidden"  id="clientId"  name="clientId"   value='<?php if(isset($_SESSION['clientData'])) echo $_SESSION['clientData']['clientId']; ?> '>
                        <label for='appointmentDate'>Date</label>
                        <input type="date" class="form_input <?php if(isset($appointmentDateErr)) echo $appointmentDateErr; ?>" id="appointmentDate"  name="appointmentDate"   value='<?php if(isset($appointmentInfo['appointmentDate'])) echo $appointmentInfo['appointmentDate'];?>' min="<?php echo date("Y-m-d");?>" max="<?php echo date('Y-m-d', strtotime("+15 day"));?>" required>
                        <span id='dateWeekdayAlert' class="inputRequirements" >Date must be during weekdays</span>
                        <label for='appointmentTime'>Time</label>
                        <input type="time" class="form_input <?php if(isset($appointmentTimeErr)) echo $appointmentTimeErr; ?>" id="appointmentTime"  name="appointmentTime"   value='<?php if(isset($appointmentInfo['appointmentTime'])) echo $appointmentInfo['appointmentTime'];?>' min='09:00' max='17:00' required>
                        <span  class="inputRequirements" >Available hours 9:00AM - 5:00PM</span>
                        <p class='form_p'>Type your phone number if you want to receive text reminders</p>
                        <label for='clientPhoneNumber'>Phone number</label>
                        <input type="tel" class="form_input <?php if(isset($clientPhoneNumberErr)) echo $clientPhoneNumberErr; ?>" id="clientPhoneNumber"  name="clientPhoneNumber"   value='<?php if(isset($appointmentInfo['clientPhoneNumber'])) echo $appointmentInfo['clientPhoneNumber'];?>' pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" > 
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
