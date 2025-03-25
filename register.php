<?php
session_start();
include('includes/header.php');
include('admin/config/dbconn.php');
if (isset($_SESSION['auth'])) {
  if ($_SESSION['auth_role'] == "admin") {
    $_SESSION['status'] = "You are already logged in";
    header('Location: admin/index.php');
    exit(0);
  } else if ($_SESSION['auth_role'] == "patient") {
    $_SESSION['status'] = "You are already logged in";
    header('Location: patient/index.php');
    exit(0);
  } else if ($_SESSION['auth_role'] == "2") {
    $_SESSION['status'] = "You are already logged in";
    header('Location: dentist/index.php');
    exit(0);
  } else if ($_SESSION['auth_role'] == "3") {
    $_SESSION['status'] = "You are already logged in";
    header('Location: staff/index.php');
    exit(0);
  }
}
?>

<style>
  body {
    background-color:rgb(213, 231, 248);
  }
  body {
        font-family: "Poppins", sans-serif;
        text-align: center;
        background: linear-gradient(
          135deg,
rgb(61, 187, 209),
rgb(199, 220, 225),
rgb(28, 69, 139),
rgb(41, 200, 202),
rgb(5, 121, 163)
        );
        background-size: 400% 400%;
        animation: gradientBG 10s ease infinite;
        padding: 20px;
        color: white;
      }
      button {
        padding: 12px 20px;
        background: linear-gradient(45deg,rgb(58, 61, 229),rgb(70, 97, 218), #57e2e5);
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease-in-out, transform 0.2s;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      }
      .container {
  max-width: 180;
  margin: auto; /* Adjust the percentage as needed */
  width: 200%;
  border-radius: 15px;
  padding: 20px;
}


      button:hover {
        background: linear-gradient(45deg, #57e2e5, #42a5f5,rgb(36, 35, 98));
        transform: scale(1.05);
      }
</style>

<div class="py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-outline card-primary shadow">
          <?php
          if (isset($_SESSION['auth_status'])) {
          ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <?php echo $_SESSION['auth_status']; ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"></span>
              </button>
            </div>
          <?php
            unset($_SESSION['auth_status']);
          }
          ?>
          <div class="card-body register-card-body">
            <a href="index.php">
              <h3 class="login-box-msg text-danger font-weight-bold"><?= $system_name ?></h3>
            </a>
            <p class="login-box-msg">Create your account by filling the form below</p>
            <form id="register" method="POST" enctype="multipart/form-data">
              <div id="alert-message" class="alert d-none" role="alert"></div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" pattern="[a-zA-Z'-'\s]*">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                    <div class="invalid-feedback" id="fname-error"></div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" pattern="[a-zA-Z'-'\s]*">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                    <div class="invalid-feedback" id="lname-error"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="input-group mb-3">
                    <input type="text" autocomplete="off" name="birthday" class="form-control" id="datepicker" placeholder="mm/dd/yyyy">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-calendar"></span>
                      </div>
                    </div>
                    <div class="invalid-feedback" id="birthday-error"></div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <select class="custom-select" id="gender" name="gender">
                    <option selected value="">- Select Gender -</option>
                    <option>Female</option>
                    <option>Male</option>
                  </select>
                  <div class="invalid-feedback" id="gender-error"></div>
                </div>
              </div>
              <div class="row">
                <div class="input-group col-sm-12 mb-3">
                  <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-map-marker-alt"></span>
                    </div>
                  </div>
                  <div class="invalid-feedback" id="address-error"></div>
                </div>
              </div>
              <div class="row">
                <div class="input-group col-sm-12 mb-3">
                  <input type="number" autocomplete="off" id="phone" class="form-control js-phone"  placeholder="Phone" name="phone">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-phone"></span>
                    </div>
                  </div>
                  <div class="invalid-feedback" id="phone-error"></div>
                </div>
              </div>
              <div class="row">
                <div class="input-group col-sm-12 mb-3">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" pattern="^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                  <div class="invalid-feedback" id="email-error"></div>
                </div>
              </div>
              <div class="row">
                <div class="input-group col-sm-12">
                  <input type="password" class="form-control" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}" title="Must contain at least one number and one uppercase and lowercase letter,at least one special character, and at least 8 or more characters" placeholder="Password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="fas fa-eye" id="eye"></i>
                    </div>
                  </div>
                  <div class="invalid-feedback" id="password-error"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <p>Password Strength: <span id="result"> </span></p>
                  <div class="progress">
                    <div id="password-strength" class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    </div>
                  </div>
                  <ul class="list-unstyled">
                    <li class=""><span class="low-upper-case"><i class="fal fa-exclamation-triangle" aria-hidden="true"></i></span>&nbsp; Contain lowercase &amp; uppercase</li>
                    <li class=""><span class="one-number"><i class="fal fa-exclamation-triangle" aria-hidden="true"></i></span> &nbsp;Contain number (0-9)</li>
                    <li class=""><span class="one-special-char"><i class="fal fa-exclamation-triangle" aria-hidden="true"></i></span> &nbsp;Contain Special Character (!@#$%^&*).</li>
                    <li class=""><span class="eight-character"><i class="fal fa-exclamation-triangle" aria-hidden="true"></i></span>&nbsp; Atleast 8 Character</li>
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="input-group col-sm-12 mb-3">
                  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="fas fa-eye" id="cf-eye"></i>
                    </div>
                  </div>
                  <div class="invalid-feedback" id="cpassword-error"></div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-sm-6 mb-3">
                <strong>Warning:
                </strong> Uploading a photo is required for identification and record-keeping purposes ❗❗
                  <label for="">Profile Picture</label>
                  <span class="text-danger">*</span>
                  <input type="file" name="patient_image">
                </div>
                <div class="form-group col-sm-12">
                  <button type="submit" id="register_btn" class="btn btn-block btn-primary">
                    <span id="register_spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Register
                  </button> 
                </div>
              </div>
            </form>
            <a href="login.php" class="text-center">I already have an account</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include('includes/scripts.php'); ?>
<script>
  $(document).ready(function() {
    $('#register').on('submit', function(e) {
      e.preventDefault();

      // Hide the spinner and reset messages
      $('#register_spinner').removeClass('d-none');
      $('#register_btn').prop('disabled', true); 
      $('.invalid-feedback').text('');
      $('.form-control span').removeClass('is-invalid');
      $('#alert-message').addClass('d-none').text('');

      var formData = new FormData(this);

      $.ajax({
        url: 'register_action.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response) {
          // Hide the spinner and enable the button after the request is done
          $('#register_spinner').addClass('d-none');
          $('#register_btn').prop('disabled', false); // Re-enable the button

          if (response.success) {
            $('#alert-message').removeClass('d-none alert-danger').addClass('alert-success').text(response.message);
            $('#register')[0].reset();
          } else {
            if (response.message) {
              $('#alert-message').removeClass('d-none').addClass('alert-danger').text(response.message);
            }

            if (response.errors) {
              if (response.errors.fname) {
                $('#fname-error').text(response.errors.fname);
                $('#fname').addClass('is-invalid');
              }
              if (response.errors.lname) {
                $('#lname-error').text(response.errors.lname);
                $('#lname').addClass('is-invalid');
              }
              if (response.errors.birthday) {
                $('#birthday-error').text(response.errors.birthday);
                $('#datepicker').addClass('is-invalid');
              }
              if (response.errors.gender) {
                $('#gender-error').text(response.errors.gender);
                $('#gender').addClass('is-invalid');
              }
              if (response.errors.address) {
                $('#address-error').text(response.errors.address);
                $('#address').addClass('is-invalid');
              }
              if (response.errors.phone) {
                $('#phone-error').text(response.errors.phone);
                $('#phone').addClass('is-invalid');
              }
              if (response.errors.email) {
                $('#email-error').text(response.errors.email);
                $('#email').addClass('is-invalid');
              }
              if (response.errors.password) {
                $('#password-error').text(response.errors.password);
                $('#password').addClass('is-invalid');
              }
              if (response.errors.confirmPassword) {
                $('#confirmPassword-error').text(response.errors.confirmPassword);
                $('#confirmPassword').addClass('is-invalid');
              }
            }
          }
        }
      });
    });


    $('#password').on('input', function() {
      var password = $(this).val();
      var strength = checkStrength(password);
      setCustomValidity(password, strength);
    });
  });
</script>