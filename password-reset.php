<?php
session_start();
include('includes/header.php');
?>

<body class="hold-transition login-page">
    <div class="login-box">
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
        <div class="card card-outline card-primary shadow">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                <form id="password-reset-link" method="POST">
                    <div id="alert-message" class="alert d-none" role="alert"></div>
                    <div class="input-group mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="email-error"></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link
                                <span id="reset_spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="login.php">Login</a>
                </p>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
<?php include('includes/scripts.php'); ?>
<script>
    $(document).ready(function() {
        $('#password-reset-link').on('submit', function(e) {
            e.preventDefault();

            $('#reset_spinner').removeClass('d-none');
            $('#register_btn').prop('disabled', true); 
            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');
            $('#alert-message').addClass('d-none').removeClass('alert-success alert-danger').text('');

            const formData = {
                email: $('#email').val(),
            };

            $.ajax({
                url: 'password-reset-link.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    $('#reset_spinner').addClass('d-none');
                    $('#register_btn').prop('disabled', false);

                    if (response.success) {
                        $('#alert-message').removeClass('d-none').addClass('alert-success').text(response.message);
                    } else {
                        // Handle error response
                        if (response.message) {
                            $('#alert-message').removeClass('d-none').addClass('alert-danger').text(response.message);
                        }

                        // Handle form validation errors
                        if (response.errors) {
                            if (response.errors.email) {
                                $('#email-error').text(response.errors.email);
                                $('#email').addClass('is-invalid');
                            }
                        }
                    }
                }
            });
        });
    });
</script>