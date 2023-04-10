<?php
  if(!isset($_SESSION))
  {
      session_start();
  }
  
   require_once("main/db_connect.php");
   
     require('main/functions.php');
     authorised();
     $pseudo =  $password = "";
     $erreur = "";

  if(isset($_POST['login']))
  {
      if(!empty($_POST['pseudo'])&& !empty($_POST['password']))
      {

          $pseudo = verifierInput($_POST['pseudo']);
          $password = md5($_POST['password']);

         
         
                  
              $req_user = $bdd->prepare("SELECT * FROM users where pseudo = ? AND motdepasse = ?");
              $req_user->execute(array($pseudo,$password));
              $user_trouv = $req_user->rowCount();
              if($user_trouv == 1)
              {
                  $user_info = $req_user->fetch();
                  $_SESSION['id'] = $user_info['id'];
                  $_SESSION['pseudo'] = $user_info['pseudo'];
                  $_SESSION['email'] = $user_info['email'];
                  $_SESSION['date'] = $user_info['date_creation_compte'];
                  $_SESSION['is_admin'] = $user_info['is_admin'];
                  $_SESSION['nbre_url'] = $user_info['nbre_url'];
                  $_SESSION['user'] = md5($pseudo);

                  header("location: index.php?id=".crypter($_SESSION['id']));

              }else
              {
                  $erreur = "Combinaison EMail/Mot de passe incorrect";
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
<?php include_once('main/header.php') ?>
   <br><br><br><br>
    
   <section class="container">
        <h2 class="text-center text-info">CONNEXION</h2><br><br>
        <div class="row">
            <div class="col-xs-12 col-md-3"></div>
            <div class="col-xs-12 col-md-6">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);   ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-6"> 
                            <label for="nom" class="form-label">Pseudo</label>
                            <input type="text" name="pseudo" id="pseudo" class="form-control"><br>
                        </div>
                        <div class="col-lg-6">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control"><br>
                        </div>
                    </div>
                    <input type="submit" name="login" class="btn btn-success" value="Se connecter">
                  
                   
                </form> <br>
                <a href="forgot-password.php">Mot de passe oublié ?</a>
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