<?php




            /*SendGrid Library*/
require_once ('vendor/autoload.php');

http_response_code(204);

/*Post Data*/
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$phone = $_POST['phone'];

  $uploaddir = '../SendGrid-API/uploads/';
           $uploadfile = $uploaddir . basename($_FILES['file']['name']);

           echo '<pre>';
           if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
               echo "File is valid, and was successfully uploaded.\n";
           } else {
               echo "Possible invalid file upload !\n";
           }

           echo 'Here is some more debugging info:';
           print_r($_FILES);
            print_r($uploadfile[name]);
            print_r((string)$uploadfile);

           print "</pre>";




function makeEmail($to_emails = array(),$from_email,$subject,$body) {

//All code for attachment e-mail
  $uploaddir = '../SendGrid-API/uploads/';
  $uploadfile = $uploaddir . basename($_FILES['file']['name']);



 $from = new SendGrid\Email(null, $from_email);
 $file =  $uploadfile;
$file_encoded = base64_encode(file_get_contents($file));
$attachment = new SendGrid\Attachment();
$attachment->setContent($file_encoded);
$attachment->setType("application/text");
$attachment->setDisposition("attachment");
$attachment->setFilename(basename($_FILES['file']['name']));

   $to = new SendGrid\Email(null, $to_emails[0]);
   $content = new SendGrid\Content("text/html", $body);
   $mail = new SendGrid\Mail($from, $subject, $to, $content);
   $to = new SendGrid\Email(null, $to_emails[1]);
   $mail->personalization[0]->addTo($to);
   $mail->addAttachment($attachment);

   return $mail;
}

function sendMail($to = array(),$from,$subject,$body) {

   $apiKey = ('Your SendGrid Key');
   $sg = new \SendGrid($apiKey);
   $request_body = makeEmail($to ,$from,$subject,$body);
   $response = $sg->client->mail()->send()->post($request_body);
   echo $response->statusCode();
   echo $response->body();
   print_r($response->headers());
}

$to = array('Your e-mail # 1','Your e-mail #2');
$from = $email;
$subject = "You have an e-mail from your site!";
$body = "The following person contacted you through your website:<br>
<br>

Name: {$name}<br>
<br>

Email: {$email} <br>
<br>

Phone: {$phone}<br>
<br>

Their message is:
{$message} <br>
<br>



";


sendMail($to,$from,$subject,$body);
$mail->addAttachment($attachment);










?>
