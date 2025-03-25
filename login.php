<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reñon Dental Clinic - Appointment Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            width: 800px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background: #ffffff;
            padding: 30px;
            text-align: center;
            border-top: 5px solid #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            font-size: 1.1rem;
            border-radius: 25px;
            padding: 10px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .header-text {
            font-weight: bold;
            font-size: 1.8rem;
            color: #007bff;
            margin-bottom: 10px;
        }
        .input-group-text {
            background: #007bff;
            color: white;
            border: none;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .circle {
            width: 80px;
            height: 80px;
            background: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
        }
        .circle i {
            font-size: 2rem;
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="card">
            <div class="circle">
                <i class="fas fa-user-md"></i>
            </div>
            <h3 class="header-text">RENON DENTAL CLINIC</h3>
            <p class="text-muted">Sign in to manage your appointments</p>
            <form id="login-form">
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" placeholder="Email">
                    <div class="invalid-feedback" id="email-error"></div>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    <div class="invalid-feedback" id="password-error"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log In</button>
            </form>
            <p class="mt-3">
                <a href="password-reset.php">Forgot password?</a> | <a href="register.php">Create Account</a>
            </p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#login-form').on('submit', function (e) {
                e.preventDefault();
                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');
                
                const formData = {
                    email: $('#email').val(),
                    password: $('#password').val()
                };

                $.ajax({
                    url: 'logincode.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            window.location.href = response.redirect;
                        } else {
                            if (response.errors) {
                                if (response.errors.email) {
                                    $('#email-error').text(response.errors.email).addClass('d-block');
                                    $('#email').addClass('is-invalid');
                                }
                                if (response.errors.password) {
                                    $('#password-error').text(response.errors.password).addClass('d-block');
                                    $('#password').addClass('is-invalid');
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>