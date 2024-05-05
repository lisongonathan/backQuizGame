<?php
ob_start();
?>

<!-- header inner -->
<div  class="head_top">
   <!-- end header -->
   <!-- banner -->
   <section class="banner_main">
      <div class="container-fluid">
         <div class="row d_flex">
            <div class="col-md-6">
               <div class="text-bg">
                  <h1 class="titlepage"><?= $data["status"] ?></h1>                        
                  <div class="Testimonial_box">
                    <i><img class='img-circle' src=<?= $data["user"]["photo"] ?> alt="#"/></i>
                  </div>                  
                    <div class="Testimonial_box">
                        <h4><?= $data["user"]["nom"] ?></h4>
                        <p><?= $data["message"] ?></p>
                        <a href="#">QuizGame</a>
                    </div>                  
               </div>
            </div>
            <div class="col-md-6">
               <div class="text-img">
                  <figure><img src="../Views/images/box_img.png" alt="#"/></figure>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>

<?php $contenu = ob_get_clean(); ?>
<?php require "gabarit.php"; ?>