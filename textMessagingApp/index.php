<?php

require('twilio-php/Services/Twilio.php'); 
require('keys.php');
 
$client = new Services_Twilio($_SESSION["account_sid"], $_SESSION["auth_token"]);
$headers = apache_request_headers();

$people = array(
        "+17863281019" => "Sam",
    );

// GENERATE UNIQUE ID FOR THE USER
$uniqueIDmessage = "Your unique ID is: ";
$uniqueID = rand(10001,99999);

$body = $_REQUEST['Body'];

// RECOGNIZE USER
if(!$name = $people[$_REQUEST['From']]) {
	$name = "Unknown";
    }

// PART ONE
if ($body == "1") {
	$response = ", to proceed with sign up, reply with '2'.";
}
// PART TWO
else if ($body == "2") {
	$response = ", " . $uniqueIDmessage . $uniqueID . "." . "You will use this to alert your emergency contacts. Send us 3-5 phone numbers to serve as your emergency contacts, separate with a comma.";
} 

// CODE TO BE EXECUTED IF OTHER ELSE IF STATEMENTS ARE FALSE
else {
	$response = ", as sign up process has not been initated.";
}




header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>

<Response>
  <Message><?php echo $name, $response ?></Message>
</Response>