<?php
// Original source code from:
// https://www.freecontactform.com/email_form.php

if(isset($_POST['email'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "contact@abeckus.com";
    $email_from = $email_to;
    $email_reply = $email_to;
    $email_subject = "Email from abeckus.com contact form";
 
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['email'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
     
    $redirect = $_POST['redirect'];
    $form_version = $_POST['form_version'];
 
    $full_name = $_POST['name'];
    $email_address = $_POST['email']; // required
    $subject = $_POST['subject'];
    $website = $_POST['website'];
    $message = $_POST['message'];
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_address)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";

  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Message is below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
 
    $email_message .= "Name: ".clean_string($full_name)."\n";
    $email_message .= "Email: ".clean_string($email_address)."\n";
    $email_message .= "Website: <".clean_string($website).">\n";
    $email_message .= "Subject: ".clean_string($subject)."\n";
    $email_message .= "Message:\n".clean_string($message)."\n<end message>\n";
    $email_message .= "\nSubmitted: ".date("D M d, Y G:i:s \U\T\CO")."\n";
    $email_message .= "Form version: ".clean_string($form_version)."\n";


    // create email headers
    $headers = 'From: '.$email_from."\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email_to, $email_subject, $email_message, $headers);  

    header("Location: http://".$_SERVER["HTTP_HOST"]."/$redirect");
}
?>