<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;
 require 'vendor/autoload.php';
 require_once('db_connect.php');

function logout(){
    session_start();
    session_destroy();


    ?>
    <script type="text/javascript" language="Javascript">
        alert("Déconnecté(e) avec succès !");
        
            location.href='index.php';
        
    </script> <?php
}
function estEmail($var){
    return filter_var($var, FILTER_VALIDATE_EMAIL);
}

function verifierInput($var){
    $var = trim($var); //Enlever tous les espaces et retours à la  ligne inutiles, pour la protection
    $var = stripslashes($var); //Enlever tous les antislash 
    $var = htmlspecialchars($var);  
    $var = strip_tags($var);

    return $var;
}
    function notAuthorised(){
        if(!isset($_SESSION['user']))
     {
        ?>
        <script type="text/javascript" language="Javascript">
             alert("On ne peut accéder à cette page sans être connecté, veuillez-vous connecter !");
            
                 location.href='sign_in.php';
            
        </script> <?php
     }
    }

    function authorised(){
        if(isset($_SESSION['user']))
        {
            ?>
            <script type="text/javascript" language="Javascript">
                alert("On ne peut accéder à cette page une fois connecté(e) !");
                
                    location.href='index.php';
                
            </script> <?php
        }
    }

    function getMyLinks(){
        global $bdd;

        $req_links = $bdd->prepare("SELECT * FROM links WHERE id_user = ? ORDER BY created_at DESC");
        $req_links->execute(array($_SESSION['id']));
        $links = [];
        while($rows = $req_links->fetchObject()){
            $links[] = $rows;
        }

        return $links;
    }

    function showUrl($var){
        global $bdd;
        $req_show = $bdd->prepare("SELECT * FROM links WHERE id = ?");
        $req_show->execute(array($var));
        return $req_show;
    }

    function updateUrl($var){
        global $bdd;
        $long_url = $namelink = "";
        $erreur = "";

       
  
        if(isset($_POST['updateurl'])){
            if(!empty($_POST['longlink'])&& !empty($_POST['namelink']))
          {
            $long_url = $_POST['longlink'];
            $namelink = verifierInput($_POST['namelink']);
    
            if (!filter_var($long_url, FILTER_VALIDATE_URL) === false) {
                if(strlen($namelink) < 5 ){
                    $erreur = "Votre alias doit contenir au moins 05 caractères";
                }
                else{
                    $words = $bdd->prepare("SELECT short_url FROM links WHERE short_url = ?");
                    $words->execute(array($namelink));
                    $word = $words->fetch();
                    if($word['short_url'] != $namelink){
    
                    
                        $user = $bdd->prepare("UPDATE links SET long_url = ?, short_url = ? WHERE id = ? ");
                                    $user->execute(array($long_url,$namelink,$var));
                                   
                                    ?>
                                    <script type="text/javascript" language="Javascript">
                                            alert("Lien court mis à jour avec succès ! Veuillez l'apercevoir depuis votre dashboard");
                                        
                                                location.href='dashboard.php';
                                        
                                    </script> <?php
                    }else{
                        $erreur = "Cet alias existe déjà !";
                    }
                }
            } else {
                $erreur = "URL non valide";
            }
    
            
          }else{
            $erreur = "Veuillez remplir tous les champs !";
          }
        }
    }
    
    function deleteUrl($var){
        global $bdd;
        $req_del = $bdd->prepare("DELETE FROM links WHERE id = ?");
        $req_del->execute(array($var));
        ?>
        <script type="text/javascript" language="Javascript">
        alert("Votre lien court a été supprimé !");
        
            location.href='dashboard.php';
        
    </script> <?php
     }
   
    
    function genererChaineAleatoire($longueur, $listeCar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
    $chaine = '';
    $max = mb_strlen($listeCar, '8bit') - 1;
    for ($i = 0; $i < $longueur; ++$i) {
    $chaine .= $listeCar[random_int(0, $max)];
    }
    return $chaine;
    }
    function isAlias($var){
        global $bdd;
        $req_alias = $bdd->prepare("SELECT * FROM links where short_url = ?");
        $req_alias->execute(array($var));
        $alias_found = $req_alias->fetch();
        if(!empty($alias_found)){
            return $alias_found['long_url'];
        }
        else{
            return 1;
        }
    }

    function forgotPassword($var1, $var2){
       
        require 'all_mail_content.php';
            global $bdd;
            $forgot_key = genererChaineAleatoire(28);
            $subject = 'Mot de passe oublie';
            $body = '<h2>Mot de passe oublie</h2>
            <br>
            <p>Hello '.$var1.', voici le code pour changer ton mot de passe : '.$forgot_key.' et fais-le via ce lien <a href="change_password.php">Changer mon mot de passe</a></p> <br>';
            $altbody = 'Mot de passe oublie
            
            Hello '.$var1.', voici le lien pour changer ton mot de passe <a href="change_password.php?key=<?= $forgot_key ?>">Changer mon mot de passe</a>'; 

           
        

            $req_user = $bdd->prepare("SELECT motdepasseoublie FROM users where email = ?");
            $req_user->execute(array($var1));
            $user_trouv = $req_user->fetch();
            if(!empty($user_trouv['key_forgot'])){
                $user = $bdd->prepare("INSERT INTO users(key_forgot) VALUES(?)");
                $user->execute(array($forgot_key));

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
                    $mail->addAddress($var1, $var2);     
                    $mail->isHTML(true);                                  
                    $mail->Subject = $subject;
                    $mail->Body    = $body;
                    $mail->AltBody = $altbody;
                    $mail->send();
                    
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }else
            {
                $user = $bdd->prepare("UPDATE users SET motdepasseoublie = ? WHERE email = ?");
                $user->execute(array($forgot_key, $var1));

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
                    $mail->addAddress($var1, $var2);     
                    $mail->isHTML(true);                                  
                    $mail->Subject = $subject;
                    $mail->Body    = $body;
                    $mail->AltBody = $altbody;
                    $mail->send();
                    
                 ?>
                    <script type="text/javascript" language="Javascript">
                         alert("Vérifie ta boite mail pour les étapes de changement de mot de passe !");
                        
                             location.href='index.php';
                        
                    </script> <?php
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }

            
    }

    
    function crypter($var)
    {
        $tmp = 6;
        $compt = 5;

        while($compt >= 1)
        {
            $var = $var + $compt;
            $compt--;
        }
        return $var * $tmp;
    }

    function decrypter($var)
    {
        $tmp = 6;
        $compt = 5;
        $var = $var / $tmp;

        while($compt >= 1)
        {
            $var = $var - $compt;
            $compt--;
        }

        return $var;
    }

?>