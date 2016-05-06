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
// THIS NEEDS TO BE A RANDOM NUMBER - ALL THE POSSIBILITIES THAT HAVE ALREADY BEEN TAKEN
$uniqueID = get_number();

$body = $_REQUEST['Body'];


session_start();
if (!isset($_SESSION['numbers'])) {
    $_SESSION['numbers']="*"; //---create the session variable
}

function get_number() {
    $i = 0;
    do { 
        $num=rand(10000,99999); //---generate a random number
        if (!strstr($_SESSION['numbers'],"*".$num."*")) { //---check if the number has already been used
            $_SESSION['numbers']=$_SESSION['numbers'] . $i . "*"; //---add the number to the session variable to avoid repeating
            if (substr_count($_SESSION['numbers'],"*")>=10000) { //---resets the session variable when all 20 number have been used
                    $_SESSION['numbers']="*";
            }
            $i=$num; //---ends the while loop to return the value
        }  
    } 
        while ($i==0);
        return $i;
}


// STORE UNIQUE ID
// ASSOCIATE WITH EMERGENCY CONTACTS

// SHOULD THE UNIQUE ID BE ASSOCIATED WITH THE PERSON'S ACTUAL PHONE NUMBER?

// IF USER TEXTS US THEIR CUSTOM MESSAGE TO SIGNIFY DISTRESS FROM THEIR OG PHONE NUMBER THEN WE SEND ALERT AFTER 10 MINS
// WE SHOULD ALLOW THEM TO CHOOSE THIS CUSTOM MESSAGE SO THEY DON'T HAVE TO REMEMBER A CODE IN A STRESSFUL SITUATION
// IF THE UNIQUE ID IS TEXTED FROM A NEW PHONE NUMBER, WE SHOULD ALTERT
// THE EMERGENCY CONTACTS THAT THE ALERT WAS SENT FROM AN UNFAMILIAR PHONE NUMBER

// IF UNIQUE ID IS TEXTED TO US WITH A -EDIT AFTER IT, GIVE OPTION TO CHANGE CONTACTS
// IF UNIQUE ID IS TEXTED TO US WITH A -DELETE AFTER IT, REMOVE THE UNIQUE ID AND ITS EMERGENCY CONTACTS
// IF A UNIQUE ID IS TECTED TO US WITH A -NEW, GIVE OPTION TO CHANGE ...

//
// IF A MESSAGE HAS BEEN SENT ONCE, DON'T SEND IT AGAIN BY MISTAKE
//

// Loop over list of $people array and send message to each one of them
// foreach ($people as $number => $name) {
//  $sms = $client->account->messages->sendMessage("954-998-0841", $number, "Hey $name, reply with '1' to sign up.");
//     }

// Loop over the list of messages and echo a property for each one
// foreach ($client->account->messages as $message) {
//     echo $message->body;
// }
// This could be useful later to delete messages from our Twilio account after 5 mins.

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
    $response = ", " . $uniqueIDmessage . $uniqueID . "." . " You will use this to alert your emergency contacts. Send us 3-5 phone numbers to serve as your emergency contacts, separate with a comma.";
} 

// CODE TO BE EXECUTED IF OTHER ELSE IF STATEMENTS ARE FALSE
else {
    $response = ", this is not a valid command. ";
}


header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>

<Response>
  <Message><?php echo $name, $response, $uniqueID ?></Message>
</Response>
