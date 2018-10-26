<?php

if(isset($_POST['email'])) {

//   require_once('recaptchalib.php');
//   $privatekey = "6LdFrwkUAAAAAFCKmgsIGbGFBj7uGx4kmUbuPVTg";
//   $resp = recaptcha_check_answer ($privatekey,
//                                 $_SERVER["REMOTE_ADDR"],
//                                 $_POST["recaptcha_challenge_field"],
//                                 $_POST["recaptcha_response_field"]);
//
//   if (!$resp->is_valid) {
//     // What happens when the CAPTCHA was entered incorrectly
//     die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
//          "(reCAPTCHA said: " . $resp->error . ")");
//   } else {
//     // Your code here to handle a successful verification
//     echo "reCAPTCHA verfified"
//   }


    // EDIT THE 2 LINES BELOW AS REQUIRED

    $email_to = "what.matters@durham.ac.uk";
    $email_subject = "What Matters Around Galaxies: Abstract Submitted";

    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
    // validation expected data exists
    if(!isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['institute']) ||
        !isset($_POST['email']) ||
        !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    if(empty($_POST["g-recaptcha-response"])){
        died('Error: empty reCaptcha. Try again.');
    }
    // else{
    //     //get verify response data
    //     $secret = 'xxxx';
    //     $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    //     $responseData = json_decode($verifyResponse);
    //     // if(!$responseData->success){
    //     //     died("reCaptcha could not be validated. Try again!");
    //     // }
    // }

    $first_name = $_POST['first_name']; // required
    $last_name  = $_POST['last_name']; // required
    $institute  = $_POST['institute']; // required
    $email_from = $_POST['email']; // required
    $talk       = $_POST['talk']; // required
    $comments   = $_POST['comments']; // required
    $info       = $_POST['info']; // required
    if(isset($_POST['parent']) && $_POST['parent'] == 'on') {$parent='Yes';}
    else {$parent='No';}
    $error_message = "";

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }

    $string_exp = "/^[A-Za-z .'-]+$/";

  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
  }

  if(!preg_match($string_exp,$last_name)) {
    $error_message .= 'The Last Name you entered does not appear to be valid.<br />';
  }

  if(!preg_match($string_exp,$institute)) {
    $error_message .= 'The Institute you entered does not appear to be valid.<br />';
  }

  // if(strlen($comments) < 2) {
  //   $error_message .= 'The Abstract you entered does not appear to be valid.<br />';
  // }

  if(strlen($error_message) > 0) {
    died($error_message);
  }


    $email_message = "Thank you for submitting your pre-registration for the What Matters Around Galaxies conference.\n\n";

    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    $email_message .= "First Name: \n".clean_string($first_name)."\n\n";
    $email_message .= "Last Name: \n".clean_string($last_name)."\n\n";
    $email_message .= "Institute: \n".clean_string($institute)."\n\n";
    $email_message .= "Email: \n".clean_string($email_from)."\n\n";
    $email_message .= "Type of talk: \n".clean_string($talk)."\n\n";
    $email_message .= "Abstract: \n".clean_string($comments)."\n\n";
    $email_message .= "Special requirements: \n".clean_string($info)."\n\n";
    $email_message .= "Parent facilities: \n".clean_string($parent)."\n\n";

    $email_message .= "\nWe look forward to seeing you in June!\n\nWith kind regards,\nThe SOC and LOC.";

    // $email_message .= "recaptcha: ".$_POST["g-recaptcha-response"]."\n";
// create email headers

$headers = 'From: '.$email_to."\r\n".
'Reply-To: '.$email_to."\r\n" .
'Cc: '.$email_to."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_from, $email_subject, $email_message, $headers);

?>



<!-- include your own success html here -->

<h3>Thank you for submitting your abstract. You should receive an e-mail shortly with your submission.</h3>

Your browser should shortly return you to the What Matters homepage.

<?php
 header( "refresh:5;url=http://astro.dur.ac.uk/whatmatters" );
}

?>
