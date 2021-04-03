
<div  class='notification_area'>
   <span id='notificationMessage' class='
   <?php 
      if(isset($notificationType))
         echo $notificationType;
      else if (isset($_SESSION['notificationType']))
         echo $_SESSION['notificationType'];
      else
         echo 'no_message';
   ?>
   '>
   <?php 
      if(isset($message))
         echo $message;
      else if (isset($_SESSION['message']))
         echo $_SESSION['message'];
      else
         echo '';   
   ?>
   </span>
</div>

