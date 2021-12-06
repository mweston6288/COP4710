<?php
    // Include php mailer packages
    require dirname(__FILE__).'/../../vendor/phpmailer/phpmailer/src/Exception.php';
    require dirname(__FILE__).'/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require dirname(__FILE__).'/../../vendor/phpmailer/phpmailer/src/SMTP.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Function that sends email with provided content.
    function sendEmail($recipients, $emailSubject, $emailContent)
    {
        // Create PHP Mailer object 
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 0;  // Change back to 1 for debugging.
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "cop4710bookstorenotifications@gmail.com";
        $mail->Password   = "COP4710password";

        // Setup e-mail content
        $mail->IsHTML(true);
        
        // Add all recipients to email.
        for ($i = 0; $i < count($recipients); $i++)
        {
            $mail->AddAddress($recipients[$i]['email'], $recipients[$i]['name']);
        }

        $mail->SetFrom("cop4710bookstorenotifications@gmail.com", "Book Store Notifications");
        $mail->Subject = $emailSubject;
        $mail->Body = $emailContent; 
        
        // Send email, and return if it sent successfully.
        return $mail->Send();
    }
    function emailPassword($recipientEmail, $recipientName, $emailSubject, $emailContent){
        // Create PHP Mailer object 
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 0;  // Change back to 1 for debugging.
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "cop4710bookstorenotifications@gmail.com";
        $mail->Password   = "COP4710password";

        // Setup e-mail content
        $mail->IsHTML(true);
        
        // Add all recipients to email.
  
        $mail->AddAddress($recipientEmail, $recipientName);

        $mail->SetFrom("cop4710bookstorenotifications@gmail.com", "Book Store Notifications");
        $mail->Subject = $emailSubject;
        $mail->Body = $emailContent; 
        
        // Send email, and return if it sent successfully.
        return $mail->Send();
    }
?>