<?php
include('admin/config/dbconn.php');
include('main/header.php');
include('main/topbar.php');
?>
<main id="main">
  <section class="breadcrumbs">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <h2>Contact Us</h2>
        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Contact Us</li>
        </ol>
      </div>
    </div>
  </section>
  <section id="contact" class="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <?php
          if (isset($success)) {
            echo 'Thanks';
          }
          ?>
          <h4 class="mb-4 text-primary">Contact</h4>
          <p class="description">Consult with our team online by filling out the form below. If you have specific inquiries regarding our services, please don't hesitate to get in touch. We will respond as soon as possible.</p>
        </div>
      </div>
    </div>

    <div>
  <iframe 
    style="border:0; width: 100%; height: 350px;" 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.8970165411565!2d120.95530837639498!3d15.478657585299465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339729b80b7dc5a5%3A0xe1a689adf24cb8ef!2sReñon%20Dental%20Clinic%2C%20Purok%204%2C%20Kalikid%20Sur%2C%20Cabanatuan%20City%2C%20Nueva%20Ecija%2C%20Philippines!5e0!3m2!1sen!2sph!4v1710912345678" 
    frameborder="0" 
    allowfullscreen>
  </iframe>
</div>



    <div class="container">
      <div class="row mt-5">

        <div class="col-lg-4">
          <div class="info">
            <div class="address">
              <i class="bi bi-geo-alt"></i>
              <h4>Location:</h4>
              <p><?= $address ?></p>
            </div>

            <div class="email">
              <i class="bi bi-envelope"></i>
              <h4>Email:</h4>
              <p><?= $email ?></p>
            </div>

            <div class="phone">
              <i class="bi bi-phone"></i>
              <h4>Call:</h4>
              <p><?= $mobile ?></p>
            </div>

          </div>

        </div>

        <div class="col-lg-8 mt-5 mt-lg-0">
          <form id="frmDemo" class="php-email-form" method="post">
            <div class="row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" id="name" placeholder="Your Name" class="form-control" required />
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <input type="email" name="email" id="email" placeholder="Your Email" class="form-control" required />
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" id="message" rows="5" placeholder="Message" required></textarea>
            </div>
            <div class="my-3">
              <div class="alert alert-danger" role="alert" id="error_message" style="display:none;"></div>
              <div class="alert alert-success" role="alert" id="success_message" style="display:none;"></div>
            </div>
            <div class="text-center"><button name="btn-submit" id="btn-submit" type="submit">Send Message</button></div>
          </form>
        </div>

      </div>

    </div>
  </section>

</main>
<?php
include('main/footer.php');
include('main/scripts.php');
?>