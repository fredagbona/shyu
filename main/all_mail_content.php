<?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        require 'vendor/autoload.php';

        $mymail = 'fredagbona@gmail.com';
        $myname = 'FredTheDev';
        $secretcode = 'cvvktbvxrgntoiqy';

        function registerMessage($name, $email){
            $mymail = 'fredagbona@gmail.com';
            $myname = 'FredTheDev';
            $secretcode = 'cvvktbvxrgntoiqy';
            $subject = 'Bienvenue sur SHYU (Short Your Url) ';
            $body = '<h2>Bienvenue</h2>
            <br>
            <p>Hello '.$name.', l\' equipe de SHYU te souhaite la bienvenue, nous avons cree ce service pour toi, tu pourras raccourcir des liens en illimite, enjoy !  <br>';
            $altbody = '<h2>Bienvenue</h2>
            <br>
            <p>Hello '.$name.', l\' equipe de SHYU te souhaite la bienvenue, nous avons cree ce service pour toi, tu pourras raccourcir des liens en illimite, enjoy !  <br>'; 


                $mail = new PHPMailer(true);

                try {
                    
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
                    $mail->isSMTP();                                          
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = $mymail;                     
                    $mail->Password   = $secretcode;                             
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                    $mail->Port       = 465;                                   
                    $mail->setFrom($mymail, $myname);
                    $mail->addAddress($email, $name);     
                    $mail->isHTML(true);                                  
                    $mail->Subject = $subject;
                    $mail->Body    = $body;
                    $mail->AltBody = $altbody;
                    $mail->send();
                    
                   
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
        }

        

?>