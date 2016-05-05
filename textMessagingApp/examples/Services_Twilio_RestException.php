<?php
 
require('twilio-php/Services/Twilio.php'); 
require('keys.php');

$client = new Services_Twilio($_SESSION["account_sid"], $_SESSION["auth_token"]);
 
try {
    $message = $client->account->messages->create(array(
        "From" => "954-998-0841",
        "To" => "786-328-1019",
        "Body" => "Hey there! This is a test message.",
    ));
} catch (Services_Twilio_RestException $e) {
    echo $e->getMessage();
}