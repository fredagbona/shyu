<?php
     if(!isset($_SESSION))
     {
         session_start();
     }
     
      require_once("main/db_connect.php");
      require('main/functions.php');
      notAuthorised();
      $id = decrypter($_GET['id']);
      deleteUrl($id);

?>