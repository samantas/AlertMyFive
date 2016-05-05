<?php
header('Content-type: text/xml');
$body = $_REQUEST['Body'];
if ($body == "Yes") {
  $response = "You said yes.";
} else {
  $response = "You didn't say yes.";
}
?>
<Response>
  <Message><?php echo $response; ?></Message>
</Response>