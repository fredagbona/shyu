<?php 
  
    require_once("main/db_connect.php");
     require('main/functions.php');
     authorised();

     $name = $email = '';
     $erreur = '';
     

     if(isset($_POST['forgot'])){
        if(!empty($_POST['email']) ){ 

            $email = verifierInput($_POST['email']);
           

            if(estEmail($email)){
                
                        $req_user = $bdd->prepare("SELECT * FROM users where email = ?");
                        $req_user->execute(array($email));
                        $user_trouv = $req_user->fetch();
                        if($user_trouv){
                           $name = $user_trouv['pseudo'];
                           $email = $user_trouv['email'];
                           forgotPassword($email, $name);
                        }else
                        {
                            $erreur = "Adresse Email inexistante";
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
    <title>Document</title>
 </head>
 <body>
    <br><br><br><br><br><br><br><br><br>
    
    <?php
        include('main/header.php');
    ?><br>
    <section class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <input type="text" name="email" id="email" value="Enter your email" class="form-control"><br>
                    <input type="submit" name="forgot" value="Récupérer mon compte" class="btn btn-info">
                </div>
                <div class="col-3"></div>
            </div>
              
        </form>
    </section>
        
        <?php 
		if(isset($erreur) && !empty($erreur)){
			?>   <script>
                toastr.options.toastClass = 'toastr';
            toastr.error('<?php echo $erreur ?>')
           </script>
        <?php } ?>

    <?php include_once("main/footer.php"); ?>
 </body>
 </html>