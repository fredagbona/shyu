

    <section class="container-fluid p-4">
    <div class="row">
        <div class="col-6">

        </div>
        <div class="col-xs-6 col-lg-6 border rounded p-2">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);   ?>" method="POST">
        
        <input type="text" name="longlink" id="longlink" class="form-control form-control-sm" placeholder="Entrez le Lien long"><br><br>

    
        <input type="text" name="namelink" id="namelink" class="form-control form-control-sm" placeholder="Entrez un alias pour créer le lien court"><br><br>

        <input type="submit" name="shorturl" value="Raccourcir le lien" class="btn btn-success">
    </form>
   
    <?php 
		if(isset($erreur) && !empty($erreur)){
			?>   <script>
                toastr.options.toastClass = 'toastr';
            toastr.error('<?php echo $erreur ?>')
           </script>
           <?php } ?>
  
           
            </div>
           
          
        </div>
    </div>
   </section>