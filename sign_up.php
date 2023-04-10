<?php
    require_once("main/db_connect.php");
	require_once("main/all_mail_content.php");
    require_once('main/functions.php');
    authorised();
    $pseudo = $password = $email = "";
    $erreur = "";
    if(isset($_POST['register'])){
        if(!empty($_POST['pseudo']) 
            && !empty($_POST['email']) 
            && !empty($_POST['password'])){

            $pseudo = verifierInput($_POST['pseudo']);
            $email = verifierInput($_POST['email']);
            $pwd = $_POST['password'];

            if(estEmail($email)){
                    if(strlen($pwd) >= 8)
                    {
                        $password = md5($_POST['password']);
                        $req_user = $bdd->prepare("SELECT * FROM users where email = ?");
                        $req_user->execute(array($email));
                        $user_trouv = $req_user->fetch();
                        if(!$user_trouv){
                            $req_user2 = $bdd->prepare("SELECT * FROM users where pseudo = ?");
                            $req_user2->execute(array($pseudo));
                            $user_trouv2 = $req_user2->fetch();
                            if($user_trouv2['pseudo'] != $pseudo)
                            {
                                $erreur = $user_trouv['pseudo'];
                                $user = $bdd->prepare("INSERT INTO users(pseudo,email,motdepasse) VALUES(?,?,?)");
                                $user->execute(array($pseudo,$email,$password));

                                registerMessage($pseudo,$email);

                                ?>
                                <script type="text/javascript" language="Javascript">
                                        alert("Inscription réussie ! Veuillez vous connecter à présent");
                                    
                                            location.href='sign_in.php';
                                
                            </script> <?php
                            }else{
                                $erreur = "Pseudo  déjà utilisé";
                            }
                        }else
                        {
                            $erreur = "Adresse Email déjà utilisé";
                        }
                       
                    }else
                    {
                        $erreur = "Mot de passe trop court, minimum 08 caractères";
                    }
            }else
            {
                $erreur = "Adresse email invalide";
            }
        }else
        {
            $erreur = "Veuillez remplir tous les champs";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    
    <title>SHYU - SIGN UP</title>
</head>
<body>
<?php include_once('main/header.php') ?>
   <br><br><br><br>
   <section class="container">
        <h2 class="text-center text-info">INSCRIPTION</h2><br><br>
        <div class="row">
            <div class="col-xs-12 col-md-3"></div>
            <div class="col-xs-12 col-md-6 ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);   ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-6"> 
                            <label for="nom" class="form-label">Pseudo</label>
                            <input type="text" name="pseudo" id="pseudo" class="form-control"><br>
                        </div>
                        <div class="col-lg-6">
                            <label for="email"  class="form-label">Email</label>
                            <input type="text" name="email" id="email" class="form-control"><br>
                        </div>
                    </div>
                   

                    
                    <label for="password"  class="form-label">Mot de Passe</label>
                    <input type="password" name="password" id="password" class="form-control"><br>


                    <input type="submit" name="register" class="btn btn-success" value="Créer mon compte">
                   
                </form> <br>
                <a href="sign_in.php">Vous avez déjà un compte ? (Connectez-vous ici )</a>
                <?php 
		            if(isset($erreur) && !empty($erreur)){
                        ?>   <script>
                            toastr.options.toastClass = 'toastr';
                        toastr.error('<?php echo $erreur ?>')
                    </script>
                <?php } ?>
            </div>
            <div class=" col-xs-12 col-md-3"></div>
        </div>
   </section>

    <?php include_once("main/footer.php"); ?>
</body>
</html>