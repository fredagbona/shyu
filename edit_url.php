<?php
     if(!isset($_SESSION))
     {
         session_start();
     }
   
      require_once("main/db_connect.php");
      require('main/functions.php');
      notAuthorised();
      $id = decrypter($_GET['id']);
      if(isset(($_GET['id']))){
      $url = showUrl($id)->fetch();
     // updateUrl($id);
    
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
                                  $user->execute(array($long_url,$namelink,$url['id']));
                                 
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
      } }
     


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
   <br><br>


   <section class="container-fluid p-4">
    <div class="row">
        <div class="col-6" style="background-image: url('deg.png');">

        </div>
        <div class="col-xs-6 col-lg-6 border rounded p-2">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);   ?>" method="POST">
        
        <input type="text" name="longlink" id="longlink" class="form-control form-control-sm" value="<?php if(isset($url['long_url'] )) echo $url['long_url'] ?>"><br><br>

    
        <input type="text" name="namelink" id="namelink" class="form-control form-control-sm"  value="<?php if(isset($url['short_url'] )) echo $url['short_url'] ?>"><br><br>
        
        <input type="submit" name="updateurl" value="Mettre à jour le lien" class="btn btn-success">
    </form>
    <p>
    <?php 
		if(isset($erreur) && !empty($erreur)){
			?>   <script>
            toastr.options.toastClass = 'toastr';
            toastr.error('<?php echo $erreur ?>')
           </script>
           <?php } ?>
    </p>
           
            </div>
           
          
        </div>
    </div>
   </section>
   <?php include_once("main/footer.php"); ?>
</body>
</html>