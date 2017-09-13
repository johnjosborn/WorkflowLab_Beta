<?php

$message = "<html>
<body>
    <img src='cid:logo' width='300'>
    <br><br>
    <h4>Thank you for regirstering with Workflow Labs.</h4>
    <br>
    <h3>Click HERE to finalize your registration.</h3>
    <br>
    <h4>Link not working?  Copy and paste this into your browser:<br><h4>
    <h4>Linky linky</h4>
</body>
</html>";

$result = sendEmail('johnjosborn@gmail.com', $message);

echo $result;

//php functions
function sendEmail($email, $message){

    require("../lib/PHPMailer/PHPMailerAutoload.php");
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->IsHTML(true);
    $mail->AddEmbeddedImage('../media/logo6.png', 'logo');
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;
    //Ask for HTML-friendly debug output
    //$mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    $mail->Host = 'secure211.inmotionhosting.com';
    // use
    //$mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6
    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 465;
    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'ssl';
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "john@lab627.com";
    //Password to use for SMTP authentication
    $mail->Password = "H6DA3ScqIsId";
    //Set who the message is to be sent from
    $mail->setFrom('john@lab627.com', 'Workflow Labs');
    //Set an alternative reply-to address
    $mail->addReplyTo('john@lab627.com', 'Workflow Labs');
    //Set who the message is to be sent to
    //$mail->addAddress('3106256742@txt.att.net');//ian
    $mail->addAddress($email);

    //$mail->addAddress('3105289568@txt.att.net'); //kevin
    //Set the subject line
    $mail->Subject = '';
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
    $mail->msgHTML($message);
    //Replace the plain text body with one created manually
    $mail->AltBody = $message;
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');
    //send the message, check for errors
    if (!$mail->send()) {
 	   echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
 	   echo "Message sent!";
    }

    
    
}

function oldMail(){
    
    // When we unzipped PHPMailer, it unzipped to
        // public_html/PHPMailer_5.2.0
        require("../lib/PHPMailer/PHPMailerAutoload.php");
    
        $mail = new PHPMailer();
    
        // set mailer to use SMTP
        $mail->IsSMTP();
    
        // As this email.php script lives on the same server as our email server
        // we are setting the HOST to localhost
        $mail->Host = "secure211.inmotionhosting.com";  // specify main and backup server
    
        $mail->SMTPAuth = true;     // turn on SMTP authentication
    
        // When sending email using PHPMailer, you need to send from a valid email address
        // In this case, we setup a test email account with the following credentials:
        // email: send_from_PHPMailer@bradm.inmotiontesting.com
        // pass: password
        $mail->Username = "john@lab627.com";  // SMTP username
        $mail->Password = "H6DA3ScqIsId"; // SMTP password
    
        // $email is the user's email address the specified
        // on our contact us page. We set this variable at
        // the top of this page with:
        // $email = $_REQUEST['email'] ;
        $mail->From = "info@lab627.com";
    
        // below we want to set the email address we will be sending our email to.
        $mail->AddAddress("johnjosborn@gmail.com", "John");
    
        // set word wrap to 50 characters
        $mail->WordWrap = 50;
        // set email format to HTML
        $mail->IsHTML(true);
    
        $mail->Subject = "You have received feedback from your website!";
    
        // $message is the user's message they typed in
        // on our contact us page. We set this variable at
        // the top of this page with:
        // $message = $_REQUEST['message'] ;
        $mail->Body    = $message;
        $mail->AltBody = $message;
    
        if(!$mail->Send())
        {
        
            return ("Mailer Error: " . $mail->ErrorInfo);
        } else {
            
            return ( "Message has been sent ");
        }
    
    
    
    }




?>