<?php
// TODO: Take care the form submission
// ini_set('display_errors',0);
// It returns proper info in JSON

header('Access-Control-Allow-Origin:*');
header('Content-Type: applications/json;charset=UTF-8');
$results = [];
$visitor_name = '';
$visitor_email = '';
$visitor_message= '';

// 1. Check the submission out -> Validate the data
// $_POST['firstname]



if(isset($_POST['firstname'])) {
    $visitor_name = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
}

if(isset($_POST['lastname'])) {
    $visitor_name .= ' '.filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
}

if(isset($_POST['email'])) {
    $visitor_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
}



if(isset($_POST['message'])) {
    $visitor_message = filter_var(htmlspecialchars($_POST['message']), FILTER_SANITIZE_STRING);
}

$results['name'] = $visitor_name;
$results['message'] = $visitor_message;

// 2. Prepare the email
$email_recipient = 'info@marialopera.ca';
$email_subject = 'Inquiry from Portfolio site';
$email_message = sprintf('Name: %s,  Email; %s, Message: %s', $visitor_name, $visitor_email, $visitor_message);

//  make sure you run the code in PHP 7.4 +
// Otherwise, you will need to make $email_headers as string
$email_headers = array(
    // Best practice, but it may need you to have a mail set up in noreply@yourdomain.ca
    // 'From' => 'noreply@marialopera.ca',
    'Reply-To' => $visitor_email,
    // You can still use it, if above is too much work
    // 'From' =>$visitor_email
);

// 3. Send out email


$email_result = mail($email_recipient, $email_subject, $email_message, $email_headers);
if ($email_result) {
    $results['message'] = sprintf('Thank you for contacting me, %s. You will got a reply within 24 hours.', $visitor_name);
} else {
    var_dump($results);
    $results['message'] = sprintf('I am sorry but the email did not go through.');
}

// // here goes the reCAPTCHA php code ----->


echo json_encode($results);


if(count($_POST)>0)
  {
      if(empty($_POST['firstname'])) 
      {
        echo "<h4>Please Enter your First name";  
      } 

         if (empty($_POST['lastname']))
      {
          echo "<h4>Please Enter your Lastname";
      }
      
      if (empty($_POST['g-recaptcha-response']))
      {
          echo "<h4>Please Solve reCAPTCHA";
      }

      if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recapthca-response']))
      {
          $secret="6LfbP1gdAAAAAEiEEtyAGW_SI5I-cET66LTYpXOB";
          $response=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret'.$secret.'&response='.$_POST['g-recaptcha-response']);
      
          $data=json_encode($response);

          if ($data -> success)
            {
                echo"<h2>Data sent";
            }
            else 
            {
                echo "Please Try again";
            }     
        }   
  }

  $visitor = $_POST['info'];
    switch ($visitor) {
        case 'Message':
        $mail_to = $visitor_email;
        $email_subject = "General Message";
        break;
    case 'Web':
        $mail_to = $visitor_email;
        $email_subject = "Quote for Web Development";
        break;
    case 'Animation':
        $mail_to = $visitor_email;
        $email_subject = "Quote for Animation";
        break;
    
}
