<?php
    require_once("main/db_connect.php");
    require('main/functions.php');
    authorised();


    $password = $password_confirmation = '';
    $erreur = '';

    if(isset($_POST['update'])){
        if(!empty($_POST['password'])
            && !empty($_POST['code'])){

            $code = $_POST['code'];
            
                $password = $_POST['password'];
        

           
       
                    if(strlen($password) >= 8)
                    {
                            $password_verified = md5($_POST['password']);
                            $req_user = $bdd->prepare("SELECT id FROM users where motdepasseoublie = ?");
                            $req_user->execute(array($code));
                            $user_trouv = $req_user->rowCount();
                            if($user_trouv == 1)
                            {
                                $user = $bdd->prepare("UPDATE users SET motdepasse = ?, motdepasseoublie = ? WHERE motdepasseoublie = ?");
                                $new_code = genererChaineAleatoire(20);
                                $user->execute(array($password_verified,$new_code,$code));
                                ?>
                                <script type="text/javascript" language="Javascript">
                                alert("Mot de passe changé, veuillez vous connecter");
                                
                                    location.href='sign_in.php';
                                
                            </script> <?php
                            
                                
                            }else{
                                $erreur = "Code incorrect !";
                            }

                       
                            
                      
                    }else
                    {
                        $erreur = "Mot de passe trop court, minimum 08 caractères";
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
<br><br><br><br><br><br><br>
    <?php
        include('main/header.php');
    ?><br><br>
    <center>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <label for="password">Entrez le code reçu par mail</label>
            <input type="password" name="code" id="code"><br><br>

            <label for="password">Nouveau Mot de Passe</label>
            <input type="password" name="password" id="password"><br><br>

            <input type="submit" name="update" value="Update my Password">
        </form>
        <p style="color: red;">
            <?php 
                if(isset($erreur))
                    echo $erreur;
            ?>
        </p>
    </center>
</body>
</html>