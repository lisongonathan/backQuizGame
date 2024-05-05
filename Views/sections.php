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
                  <h1>Digital Marketing Landing Page 2019</h1>
                  <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters,</p>
                  <a href="#">Read More</a>
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
<!-- business -->
<div class="business">
   <div class="container">
      <div class="row">''
         <div class="col-md-12">
            <div class="titlepage">
               <span>Increase your client for</span>
               <h2>Better position of Business</h2>
               <p>It is a long established fact that a reader will be distracted by the readable content of a page </p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-10 offset-md-1">
            <div class="row">
               <div class="col-md-12">
                  <div class="business_box ">
                     <figure><img src="../Views/images/business_img.jpg" alt="#"/></figure>
                     <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believableThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable</p>
                     <a class="read_more" href="#">Read more</a>
                  </div>
               </div>
            </div>
         </div> 
      </div>
   </div>
</div>
<!-- end business -->
<!-- Projects -->
<div class="projects">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <span>Previous Projects</span>
               <h2>Better position of Business</h2>
               <p>It is a long established fact that a reader will be distracted by the readable content of a page </p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-10 offset-md-1">
            <div class="row">
               <div class="col-md-6 offset-md-3">
                  <div class="projects_box ">
                     <figure><img src="../Views/images/projects_img.png" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="projects_box ">
                     <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believableThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable</p>
                     <a class="read_more" href="#">Read more</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end projects -->
<!-- Testimonial -->
<div class="section">
   <div class="container">
      <div id="" class="Testimonial">
         <div class="row">
            <div class="col-md-12">
               <div class="titlepage">
                  <h2>Testimonial</h2>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3">
               <div class="Testimonial_box">
                  <i><img src="../Views/images/plan1.png" alt="#"/></i>
               </div>
            </div>
            <div class="col-md-9">
            </div>
         </div>
      </div>
   </div>
</div>

<!-- end Testimonial -->
<!-- contact -->
<div id="contact" class="contact">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <h2>Contact us</h2>
               <span>There are many variations of passages of Lorem Ipsum available, but the </span>
            </div>
         </div>
      </div>
   </div>
   <div class="container">
      <div class="row">
         <div class="col-md-12 ">
            <form class="main_form ">
               <div class="row">
                  <div class="col-md-12 ">
                     <input class="form_contril" placeholder="Name " type="text" name="Name ">
                  </div>
                  <div class="col-md-12">
                     <input class="form_contril" placeholder="Phone Number" type="text" name=" Phone Number">
                  </div>
                  <div class="col-md-12">
                     <input class="form_contril" placeholder="Email" type="text" name="Email">
                  </div>
                  <div class="col-md-12">
                     <textarea class="textarea" placeholder="Message" type="text" name="Message"></textarea>
                  </div>
                  <div class="col-sm-12">
                     <button class="send_btn">Send</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- end contact -->

<?php $contenu = ob_get_clean(); ?>
<?php require "gabarit.php"; ?>