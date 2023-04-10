<?php
    if(!isset($_SESSION))
    {
        session_start();
    }

    require_once('main/db_connect.php');
    require('main/functions.php');
    notAuthorised();
    $links = getMyLinks();
 


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

   <section class="container-fluid">
    <h3 class="text-center">Mes liens (<?= count($links); ?>) </h3> <br>
    <div class="row">
        <?php
           
            foreach($links as $link){
           
            
        ?>
        <div class="col-xs-12 col-md-12 col-lg-3 mb-4 ">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title">Lien ID :  <?php echo crypter($link->id); ?> </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Lien court : <a id="<?= 'link' ?>" href="/shyu/<?php echo $link->short_url ; ?> " target="_blank"><?php echo "localhost/shyu/$link->short_url " ?></a> </h6>
                        <p class="card-text"><b>Lien long :</b> <a href="<?php echo $link->long_url; ?>" target="_blank"><?php echo $link->long_url; ?></a> </p>
                        <a href="#"  class="btn btn-outline-primary card-link copier" onclick="docopy()" data-target="<?= '#link'  ?>">Copier</a>
                        <a href="edit_url.php?id=<?= crypter($link->id) ?>" class=" btn btn-outline-warning card-link">Editer</a>
                        <a href="delete_url.php?id=<?= crypter($link->id) ?>" class=" btn btn-outline-danger card-link">Supprimer</a>
                     
                    </div>
                 </div>
        </div>
        <?php } ?>
    </div>
   </section>

   <br><br><br>
  
   <?php include_once("main/footer.php"); ?>
<script src="main/copy.js"></script>
</body>
</html>