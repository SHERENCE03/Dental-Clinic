  <?php
  include('admin/config/dbconn.php');
  include('main/header.php');
  include('main/topbar.php');
  ?>
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
      <h1>Welcome to <?= $system_name ?> </h1>
      <h2>Here to fix teeth and give confidence with your smiles</h2>
      <a href="#about" class="btn-get-started scrollto">Get Started</a>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <section id="why-us" class="why-us">
      <div class="container">

        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="content">
              <h3>Why Choose <?= $system_name ?>?</h3>
              <p>
                Creating an account in <?= $system_name ?> will give you an advantage and access to your teeth status, appointment status, you can view prescriptions, fees, and treatment performed to your teeth.
              </p>
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-calendar-check"></i>
                    <h4>Appointment</h4>
                  <p>You can view all the appointments</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-capsule"></i>
                    <h4>Prescriptions</h4>
                    <p>You can check the prescriptions and instructions</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-file"></i>
                    <h4>Fees and Treatments</h4>
                    <p>You can view all the total fees and treatments made</p>
                  </div>
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container-fluid">
        <div class="row">
          <?php
          $sql = "SELECT * FROM header";
          $query_run = mysqli_query($conn, $sql);

          while ($row = mysqli_fetch_array($query_run)) { ?>
            <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative" style="background:url('upload/<?= $row['image'] ?>') center center no-repeat;background-size: cover;min-height: 600px;">
            </div>

            <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
              <h3><?= $row['title'] ?></h3>
              <p style="font-size:22px;"><?= $row['content'] ?></p>
            <?php } ?>

            </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
          <h2>Services</h2>
          <p>We go beyond making sure your teeth and gums are healthy. 
            <br>Here, your smile gets the makeover that you need and desire through various dedicated treatments covering Cosmetic Dentistry, <br>
            Prosthodontics Treatment, Oral Surgery, Periodontics, Orthodontic Treatment, Restorative Treatment, and Oral Prophylaxis</p></br>
        </div>

        <div class="row">

          <?php
          $sql = "SELECT * FROM services";
          $query_run = mysqli_query($conn, $sql);
          $check_services = mysqli_num_rows($query_run) > 0;

          if ($check_services) {
            while ($row = mysqli_fetch_array($query_run)) {
          ?>
              <div class="col-lg-4 col-md-6 align-items-stretch mt-4 ">
                <div class="card border-0">
                  <div class="card-body icon-box">
                    <div class="icon"><a href="our-services.php?title=<?= $row['title'] ?>"><img src="upload/service/<?= $row['image'] ?>" class="img-fluid"></a></div>
                    <h4><a href="our-services.php?title=<?= $row['title'] ?>"><?= $row['title'] ?></a></h4>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            echo "<h5> No Record Found</h5>";
          } ?>

        </div>

      </div>
    </section><!-- End Services Section -->


    <!-- ======= Appointment Section ======= -->
    <section id="appointment" class="appointment section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Make an Appointment</h2>
          <p>Create an account and book your first appointment today to experience quality and safe dental journey. Get the best dental treatment in the Philippines with a click.</p>
        </div>

        <form action="forms/appointment.php" method="post" role="form" class="php-email-form">
          <div class="mb-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your appointment request has been sent successfully. Thank you!</div>
          </div>
          <?php
          if (isset($_SESSION['auth'])) {
            if ($_SESSION['auth_role'] == "patient") {
          ?>
              <div class="text-center"><a href="patient/request-appointment.php" class="appointment-btn" style="font-size:23px;"><span class="d-none d-md-inline"></span>Make an Appointment</a></div>
            <?php
            }
          } else {
            ?>
            <div class="text-center"><a href="patient/request-appointment.php" class="appointment-btn" style="font-size:23px;"><span class="d-none d-md-inline"></span>Make an Appointment</a></div>
          <?php
          }

          ?>

        </form>

      </div>
    </section><!-- End Appointment Section -->

    <section id="doctors" class="doctors">
      <div class="container">

        <div class="section-title">
          <h2>Dentist</h2>
          <p>Completing the team are competent dentists with different specializations, unfailing dental nurse assistants and aides, skilled laboratory technicians, and dependable staff, all ready to assist patients with any concern.</p>
        </div>

        <div class="row">
          <?php
          $count = 1;
          $sql = "SELECT f.description,f.image,d.name,d.specialty FROM featured f INNER JOIN tbldoctor d ON f.dentist_id = d.id";
          $query_run = mysqli_query($conn, $sql);
          $doctors = mysqli_num_rows($query_run) > 0;

          if ($doctors) {
            while ($row = mysqli_fetch_array($query_run)) {
          ?>

              <div class="col-lg-6 <?php if ($count > '1') {
                                      echo 'mt-4 mt-lg-0';
                                    } ?>">
                <div class="member d-flex align-items-start">
                  <div class="pic"><img src="admin/assets/dist/img/featured-dentist/<?= $row['image'] ?>" class="img-fluid" alt=""></div>
                  <div class="member-info">
                    <h4><?= $row['name'] ?></h4>
                    <span><?= $row['specialty'] ?></span>
                    <p><?= $row['description'] ?></p>
                  </div>
                </div>
                <?php $count++; ?>
              </div>
          <?php
            }
          }
          ?>

        </div>

      </div>
    </section>
    <section id="testimonials" class="testimonials">
      <div class="container">
        <div class="section-title">
          <h2>What People Say About <?= $system_name ?></h2>
          <p>Our satisfied clients share their experience at <?= $system_name ?>.</p>
        </div>

        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">
            <?php
            $sql = "SELECT * FROM reviews WHERE status='Active'";
            $query_run = mysqli_query($conn, $sql);
            $check_services = mysqli_num_rows($query_run) > 0;

            if ($check_services) {
              while ($row = mysqli_fetch_array($query_run)) { ?>
                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="admin/assets/dist/img/testimonials/<?= $row['image'] ?>" class="testimonial-img" alt="">
                      <h3><?= $row['name'] ?></h3>
                      <h4><?= $row['designation'] ?></h4>
                      <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        <?= $row['review'] ?>
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div>
            <?php }
            } ?>

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section>
    <section id="gallery" class="gallery">
      <div class="container">

        <div class="section-title">
          <h2>Gallery</h2>
        </div>
      </div>

      <div class="container-fluid">
        <div class="row no-gutters">
          <?php
          $sql = "SELECT * FROM gallery where status='Active'";
          $query_run = mysqli_query($conn, $sql);
          $check_services = mysqli_num_rows($query_run) > 0;

          if ($check_services) {
            while ($row = mysqli_fetch_array($query_run)) { ?>
              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="admin/assets/dist/img/gallery/<?= $row['image'] ?>" class="galelry-lightbox">
                    <img src="admin/assets/dist/img/gallery/<?= $row['image'] ?>" alt="" class="img-fluid">
                  </a>
                </div>
              </div>
          <?php }
          } ?>

        </div>

      </div>
    </section><!-- End Gallery Section -->
  <!-- Messenger Chat Plugin Code -->
    <!-- Messenger Chat Plugin Code -->
      <div id="fb-root"></div>

      <!-- Your Chat Plugin code -->
      <div id="fb-customer-chat" class="fb-customerchat">
      </div>

      <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "102712495430970");
        chatbox.setAttribute("attribution", "biz_inbox");
      </script>

      <!-- Your SDK code -->
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v15.0'
          });
        };

        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script>
    <?php
    include('main/footer.php');
    include('main/scripts.php');
    ?>
