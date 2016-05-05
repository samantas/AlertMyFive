<?php

// this line loads the library 
require('twilio-php/Services/Twilio.php'); 
require('keys.php');
 
$client = new Services_Twilio($_SESSION["account_sid"], $_SESSION["auth_token"]);
 
$client->account->messages->create(array( 
    'To' => "+17863281019", 
    'From' => "+19549980841", 
    'Body' => "Hey Jenny! Good luck on the bar exam!", 
));

echo "sent message to Sam";

?>