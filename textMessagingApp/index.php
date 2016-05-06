<?php

require('twilio-php/Services/Twilio.php'); 
require('keys.php');
 
$client = new Services_Twilio($_SESSION["account_sid"], $_SESSION["auth_token"]);
$headers = apache_request_headers();

$people = array(
        "+17863281019" => "Sam",
    );

// GENERATE UNIQUE ID FOR THE USER
$uniqueIDmessage = "your unique ID is: ";
$uniqueID = get_number();
$body = $_REQUEST['Body'];

session_start();

if (!isset($_SESSION['numbers'])) {
    $_SESSION['numbers']="*"; //---create the session variable
}
// GENERATE RANDOM NUMBER ONCE
function get_number() {
    $i = 0;
    do { 
        $num=rand(10000,99999); //---generate a random number
        if (!strstr($_SESSION['numbers'],"*".$num."*")) { //---check if the number has already been used
            $_SESSION['numbers']=$_SESSION['numbers'] . $i . "*"; //---add the number to the session variable to avoid repeating
            if (substr_count($_SESSION['numbers'],"*")>=10000) { //---resets the session variable when all numbers have been used
                    $_SESSION['numbers']="*";
            }
            $i=$num; //---ends the while loop to return the value
        }  
    } 
        while ($i==0);
        return $i;
};

// COUNTER
// create a counter to track which message we're on
// get the session varible if it exists
$counter = $_SESSION['counter'];
// if it doesn't exist, set the default
if(!strlen($counter)) {
    $counter = 0;
}
// save it
$_SESSION['counter'] = $counter;

// RECOGNIZE USER
if(!$name = $people[$_REQUEST['From']]) {
    $name = "Unknown";
}

// MESSAGES
if ($body == "1") {
    $response = ", to proceed with sign up, reply with '2'. For language options, reply with '0'";
    $counter++;

} else if ($body == "0") {
	$response = ", for Spanish, reply with 's'";

} else if ($body == 's' || $body == 'S') {
    // NEED SPANISH CONTENT
    $response = ", we apologize for the inconvenience. We have not yet set up our Spanish language sign up. Reply with '2' to proceed with sign up in English.";

} else if ($body == "2") {
    $response = ", " . $uniqueIDmessage . $uniqueID . "." . " You will use this to alert your emergency contacts. Reply with 3-5 phone numbers to serve as your emergency contacts, separate with a comma.";
    $counter++;

} else if (preg_match("/^\d+(?:,\d+)*$/", $body)) {
	$response = ", your emergency contacts have been saved. Would you like to customize the alert message? (Yes/No)";
	$counter++;

} else if ($body == "Yes" || $body == "yes") {
	$response = ", please reply with your custom message. If you choose to use numbers, please use less than 20. Your custom message cannot be 'yes'.";
	$counter++;	

} else if ($body == "No" || $body == "no") {
	$response = ", thank you for signing up! We hope to help keep you safe. Your emergency contacts will be alerted with our generic message, which you can find on our website. If you want to change the message, reply with your unique ID followed by -EDITM. To delete your account, reply with your unique ID followed by -DELETE.";

} else if (preg_match('/[^0-9a-z\s-]/i', $body) || preg_match('/^[a-zA-Z\s]+$/', $body) && $body != "yes" && $body != "Yes" && is_numeric($body) < 20) {
    $response = ", thank you for signing up! We hope to help keep you safe. If you want to change the message, reply with your unique ID followed by -EDITM. To delete your account, text us your unique ID followed by -DELETE.";
}

// CODE TO BE EXECUTED IF OTHER ELSE IF STATEMENTS ARE FALSE
else { 
    $response = ", that is not a valid command. ";
}

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>

<Response>
  <Message><?php echo $name, $response ?></Message>
</Response>