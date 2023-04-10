<?php
 require_once('main/functions.php');


if(isset($_GET['alias'])){
    $code = $_GET['alias'];
    $url = isAlias($code);
    if($url != 1) {
        header("Location: ".$url);
    }
    else{
        ?>
        <script type="text/javascript" language="Javascript">
             alert("Erreur !");
            
                 location.href='error.php';
            
        </script> <?php
    }
    
}
else{
    header("Location: error.php");
}

?>