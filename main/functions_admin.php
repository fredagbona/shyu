<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';

    function isAdmin(){
        global $bdd;
        $is_admin = $bdd->prepare("SELECT is_admin FROM users WHERE id = ?");
        $is_admin->execute(array($_SESSION['id']));
        $res = $is_admin->fetch();
        if($res['is_admin'] == 0){
            ?>
        <script type="text/javascript" language="Javascript">
             alert("Vous n' êtes pas un administrateur !");
            
                 location.href='dashboard.php';
            
        </script> <?php
        }                                                
    }
   
       function getSimpleUsers()
       {
           global $bdd;
           $req_user = $bdd->prepare("SELECT * FROM users WHERE is_admin = ? ORDER BY date_creation_compte DESC");
           $req_user->execute(array(0));
           $results = [];
           while($rows = $req_user->fetchObject()){
               $results[] = $rows;
           }
   
           return $results;
       }

       function getAdmins()
       {
           global $bdd;
           $req_adm = $bdd->prepare("SELECT * FROM users WHERE is_admin = ? ORDER BY date_creation_compte DESC");
           $req_adm->execute(array(1));
           $results = [];
           while($rows = $req_adm->fetchObject()){
               $results[] = $rows;
           }
   
           return $results;
       }


       function getAllProjects(){
            global $bdd;

            $req_projects = $bdd->query("SELECT * FROM projects");
            $results = [];
            while($rows = $req_projects->fetchObject()){
                $results[] = $rows;
            }

            return $results;
       }

       function nbreProject($var){
            global $bdd;

            $req_projet = $bdd->prepare("SELECT id FROM projects WHERE id_user = ?");
            $req_projet->execute(array($var));

            $nbre = $req_projet->rowCount();

            return $nbre;
       }

       

       function getUser($var){
            global $bdd;

            $req_user = $bdd->prepare("SELECT nom, prenoms FROM users WHERE id = ?");
            $req_user->execute(array($var));

            return $req_user;
       }

       function deleteUser($var){
        global $bdd;
        $req_del = $bdd->prepare("DELETE FROM users WHERE id = ?");
        $req_del->execute(array($var));
        ?>
        <script type="text/javascript" language="Javascript">
        alert("Cet utilisateur a été supprimé !");
        
            location.href='super_admindashboard.php';
        
    </script> <?php
     }


?>