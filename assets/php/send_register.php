<?php
// define variables and set to empty values
$name = $email = $category = $copyme = $message = "";


//handle post request
if($_SERVER["REQUEST_METHOD"]=="POST"){

  $email_to = "richard.bielby@durham.ac.uk";

  $email_subject = "What Matters around Galaxies Registration";


    //handle name
    if (empty($_POST["wm-name"]))
    {
        //set error
        die('Error: empty name. Try again.');
    } else {
        $name = clean_input($_POST["wm-name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            die('Error: name cannot contain special characters. Try again.');
        }
    }

    //handle email
    if (empty($_POST["wm-email"])) {
        die('Error: emtpy email. Try again.');

    } else {
        $email = clean_input($_POST["wm-email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Error: invalid email address. Try again.');
        }
    }

    //handle message
    if (empty($_POST["wm-abstract"])) {
        die('Error: empty message. Try again.');
    } else {
        $abstract = clean_input($_POST["wf-abstract"]);
    }

    //handle copy me
    $childers = clean_input($_POST["wm-childers"]);

    //check for undesired keywords
    $whitelist = array('wm-name','wm-email','wm-childers','wm-rcaptcha',
                       'wm-abstract','g-recaptcha-response');
    foreach ($_POST as $key=>$item) {
        if (!in_array($key, $whitelist)) {
            die("Hack-attempt detected. Unwanted fields in form!");
        }
    }

    //now verify rcaptcha
    if(empty($_POST["g-recaptcha-response"])){
        die('Error: empty reCaptcha. Try again.');
    }else{
        //get verify response data
        $secret = 'YOUR KEY HERE!!!!!!!';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if(!$responseData->success){
            die("reCaptcha could not be validated. Try again!");
        }
    }

    //now the message can be sent
    echo "So far so good";
    echo $name, $childers, $abstract, $email;
    //now the message can be sent
    $email_message .= "Name: ".clean_string($name)."\n";

       $email_message .= "Last Name: ".clean_string($abstract)."\n";

       $email_message .= "Email: ".clean_string($email)."\n";

       $email_message .= "Telephone: ".clean_string($childers)."\n";


    $headers = 'From: '.$email_from."\r\n".

    'Reply-To: '.$email_from."\r\n" .

    'X-Mailer: PHP/' . phpversion();

    @mail($email_to, $email_subject, $email_message, $headers);



  /*

    Try to check if comes from it. or www. to have only one handler.

  //at this point check if all is good
  if ($collect_error)
  {
    //failed
    header("Location: /url/to/the/other/page");
    exit;
  } else {
    //success
    header("Location: /url/to/the/other/page");
    exit;
  }
  */
}

//define the clean up function
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/*
These are all the keys
wf-name
wf-email
wf-category
wf-copy
wf-rcaptcha
wf-message
g-recaptcha-response
*/

?>
