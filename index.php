<?php
if(!isset($_SESSION))
{
    session_start();
}
    require_once('main/db_connect.php');
    require('main/functions.php');

  
    $erreur =  "";

    if(isset($_POST['shorturl'])){
        if(!empty($_POST['longlink'])&& !empty($_POST['namelink']))
      {
        $longurl = $_POST['longlink'];
        $namelink = verifierInput($_POST['namelink']);

        if (!filter_var($longurl, FILTER_VALIDATE_URL) === false) {
            if(strlen($namelink) < 5 ){
                $erreur = "Votre alias doit contenir au moins 05 caractères";
            }
            else{
                $words = $bdd->prepare("SELECT short_url FROM links WHERE short_url = ?");
                $words->execute(array($namelink));
                $word = $words->fetch();
                if($word['short_url'] != $namelink){

                
                    $user = $bdd->prepare("INSERT INTO links(long_url,short_url,id_user) VALUES(?,?,?)");
                                $user->execute(array($longurl,$namelink,$_SESSION['id']));
                               
                                ?>
                                <script type="text/javascript" language="Javascript">
                                        alert("Lien court créé ! Veuillez l'apercevoir depuis votre dashboard");
                                    
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Url Shortener v2023</title>
</head>
<body class="">
   <?php include_once('main/header.php') ?>
   <br><br><br><br>
   <?php
            if( isset($_SESSION['user']))
            {
                include_once('short.php');
            }else{
    ?>

    <section class="container-fluid">
        <div class="row align-self-center">
            <div class=" col-xs-12 col-md-3"></div>
            <div class=" col-xs-12 col-md-6">
               
               
                    <h1 class="text-center text-info">Short Your URLs
                    </h1> <br>
                    <h4 class="text-center">Avec SHYU, c'est : </h4>
                    <p> <span ></span> 
                        <ul style="list-style-type: none;">
                            <li><i class="bi bi-check2-circle" style="font-size: 20px; color:green;"></i> Plus de 300 liens courts /mois</li>
                            <li><i class="bi bi-check2-circle" style="font-size: 20px; color:green;"></i> Des liens courts modifiables qui durent dans le temps</li>
                            <li><i class="bi bi-check2-circle" style="font-size: 20px; color:green;"></i> Un link-in-bio gratuit </li>
                            <li><i class="bi bi-check2-circle" style="font-size: 20px; color:green;"></i> Un tableau de bord </li>
                            <li><i class="bi bi-check2-circle" style="font-size: 20px; color:green;"></i> Un générateur de code QR</li>
                            <li><i class="bi bi-check2-circle" style="font-size: 20px; color:green;"></i> Des statistiques de vos liens courts (historiques, nombre de clics,type d'appareils,...)</li>
                            <li><i class="bi bi-check2-circle" style="font-size: 20px; color:green;"></i> Un sous-domaine gratuit</li>
                            <li><i class="bi bi-check2-circle" style="font-size: 20px; color:green;"></i> Un nom de domaine personalisé</li>
                            <li><i class="bi bi-check2-circle" style="font-size: 20px; color:green;"></i> Un accès au support h24</li>
                        </ul>
                    </p> <br>

                    <a href="sign_up.php" class="btn btn-info text-light d-block bg-gradient">Créer un compte gratuit</a>
                    
            </div>
            <div class=" col-xs-12 col-md-3"></div>
        </div>
               
    </section> <?php } ?>


    
    
   <?php include_once("main/footer.php"); ?>
   
</body>
</html>