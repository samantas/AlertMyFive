<?php 

/* Controller: Match the keyword with the customized SMS reply. */
function index(){
    $response = new Services_Twilio_Twiml();
    $response->sms("Reply with one of the following keywords:
monkey, dog, pigeon, owl.");
    echo $response;
}
 
function monkey(){
    $response = new Services_Twilio_Twiml();
    $response->sms("Monkey. A small to medium-sized primate that
typically has a long tail, most kinds of which live in trees in
tropical countries.");
    echo $response;
}
 
function dog(){
    $response = new Services_Twilio_Twiml();
    $response->sms("Dog. A domesticated carnivorous mammal that
typically has a long snout, an acute sense of smell, and a barking,
howling, or whining voice.");
    echo $response;
}
 
function pigeon(){
    $response = new Services_Twilio_Twiml();
    $response->sms("Pigeon. A stout seed- or fruit-eating bird with
a small head, short legs, and a cooing voice, typically having gray and
white plumage.");
    echo $response;
}
 
function owl(){
    $response = new Services_Twilio_Twiml();
    $response->sms("Owl. A nocturnal bird of prey with large
forward-facing eyes surrounded by facial disks, a hooked beak,
and typically a loud call.");
    echo $response;
}
 
/* Read the contents of the 'Body' field of the Request. */
$body = $_REQUEST['Body'];
 
/* Remove formatting from $body until it is just lowercase
characters without punctuation or spaces. */
$result = preg_replace("/[^A-Za-z0-9]/u", " ", $body);
$result = trim($result);
$result = strtolower($result);
 
/* Router: Match the ‘Body’ field with index of keywords */
switch ($result) {
    case 'monkey':
        monkey();
        break;
    case 'dog':
        dog();
        break;
    case 'pigeon':
        pigeon();
        break;
    case 'owl':
        owl();
        break;
 
/* Optional: Add new routing logic above this line. */
    default:
        index();
}
?>