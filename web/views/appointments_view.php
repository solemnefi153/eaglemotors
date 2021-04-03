<?php
    //Check that there is an active session 
    if(!isset($_SESSION['clientData'])){
        header('location: ' . ROOT_URI);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Appointment Management | Eagle Motors, LLC.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/general_styles.css' media='screen'>
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/manage_appointments_styles.css' media='screen'>
        <script src='<?php echo ROOT_URI; ?>public/js/appointmentCancelation.js' defer ></script>
        <link href="<?php echo ROOT_URI; ?>public/images/site/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
        <div class='content'>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/header.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/navigation.php'; ?>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/notification_area.php'; ?>
            <main>
                <?php 
                    if(isset($upcomingAppointments)){
                        if(!empty($upcomingAppointments)){
                            $html = "<h1 >Upcomming Appointments</h1>";
                            $html .= "<div class='table_wraper'>";
                            $html .= "<table>";
                            $html .= "  <tr class='table_headers'>";
                            $html .= "      <th class='small_td'>Client Name</th>";
                            $html .= "      <th class='medium_td'>Vehicle</th>";
                            $html .= "      <th class='small_td'>Date</th>";
                            $html .= "      <th class='small_td'>Time</th>";
                            $html .= "      <th class='medium_td'>Contact info</th>";
                            $html .= "      <th class='small_td' >Modify or Cancel</th>";
                            $html .= "  </tr>";
                            foreach($upcomingAppointments as $appointment){
                                $html .= "  <tr>";
                                $html .= "      <td class='small_td'>$appointment[clientFirstname]</td>";
                                $html .= "      <td class='medium_td'>$appointment[invMake] $appointment[invModel]</td>";
                                $html .= "      <td class='small_td'>$appointment[appointmentDate]</td>";
                                $html .= "      <td class='small_td'>$appointment[appointmentTime]</td>";
                                $html .= "      <td class='medium_td'>$appointment[clientPhoneNumber]</td>";
                                $html .= "      <td class='buttons_td'><a class='primary_btn' href='" . ROOT_URI . "controllers/appointments/?action=view_update_appointment&appointmentId=$appointment[appointmentId]' title='Modify Appointment'>Modify</a> <a class='danger_btn' href='" . ROOT_URI . "controllers/appointments/?action=cancelAppointment&appointmentId=$appointment[appointmentId]' title='Cancel Appointment' onclick='confirmAppointmentCancelation(event)'>Cancel</a></td>";
                                $html .= "  </tr>";
                            }
                            $html .= "</table>";
                            $html .= "</div>";
                            echo $html;
                        }
                    }
                    if(isset($pastAppointments)){
                        if(!empty($pastAppointments)){
                            $html = "<h1 >Expired Appointments</h1>";
                            $html .= "<div class='table_wraper'>";
                            $html .= "<table>";
                            $html .= "  <tr class='table_headers'>";
                            $html .= "      <th class='small_td'>Client Name</th>";
                            $html .= "      <th class='medium_td'>Vehicle</th>";
                            $html .= "      <th class='small_td'>Date</th>";
                            $html .= "      <th class='small_td'>Time</th>";
                            $html .= "      <th class='medium_td'>Contact info</th>";
                            $html .= "      <th class='small_td' >Cancel</th>";
                            $html .= "  </tr>";
                            foreach($pastAppointments as $appointment){
                                $html .= "  <tr>";
                                $html .= "      <td class='small_td'>$appointment[clientFirstname]</td>";
                                $html .= "      <td class='medium_td'>$appointment[invMake] $appointment[invModel]</td>";
                                $html .= "      <td class='small_td'>$appointment[appointmentDate]</td>";
                                $html .= "      <td class='small_td'>$appointment[appointmentTime]</td>";
                                $html .= "      <td class='medium_td'>$appointment[clientPhoneNumber]</td>";
                                $html .= "      <td class='buttons_td'><a  class='danger_btn' href='" . ROOT_URI . "controllers/appointments/?action=cancelAppointment&appointmentId=$appointment[appointmentId]' title='Delete Appointment' onclick='confirmAppointmentCancelation(event)'>Delete</a></td>";
                                $html .= "  </tr>";
                            }
                            $html .= "</table>";
                            $html .= "</div>";
                            echo $html;
                        }
                    }
                ?>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>
    </body>
</html>