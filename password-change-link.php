<?php
session_start();
include('admin/config/dbconn.php');
include('superglobal.php');

if (isset($_POST['update_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password =   mysqli_real_escape_string($conn, $_POST['newPassword']);
    $confirm_password =  mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    $token = mysqli_real_escape_string($conn, $_POST['password_token']);

    if (!empty($token)) {
        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
            $check_token = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if (mysqli_num_rows($check_token_run)) {
                if ($new_password == $confirm_password) {
                    $hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $sql = "SELECT role FROM users WHERE email='$email' ";
                    $query_run = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                            $role = $row['role'];
                        }
                    }
                    if ($role == 'admin') {
                        $update_password = "UPDATE tbladmin SET password='$hash' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($conn, $update_password);
                    } else if ($role == '2') {
                        $update_password = "UPDATE tbldoctor SET password='$hash' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($conn, $update_password);
                    } else if ($role == '3') {
                        $update_password = "UPDATE tblstaff SET password='$hash' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($conn, $update_password);
                    } else if ($role == 'patient') {
                        $update_password = "UPDATE tblpatient SET password='$hash' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($conn, $update_password);
                    }

                    if ($update_password_run) {
                        $new_token = md5(rand()) . "feliztooth";

                        if ($role == 'admin') {
                            $update_to_new_token = "UPDATE tbladmin SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
                        } else if ($role == '2') {
                            $update_to_new_token = "UPDATE tbldoctor SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
                        } else if ($role == '3') {
                            $update_to_new_token = "UPDATE tblstaff SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
                        } else if ($role == 'patient') {
                            $update_to_new_token = "UPDATE tblpatient SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
                        }

                        $_SESSION['success'] = "Password has been changed";
                        header("Location:login.php");
                    } else {
                        $_SESSION['error'] = "Did not update password. Something went wrong!";
                        header("Location:password-change.php?token=$token&email=$email");
                    }
                } else {
                    $_SESSION['error'] = "Password and Confirm Password does not match";
                    header("Location:password-change.php?token=$token&email=$email");
                }
            } else {
                $_SESSION['error'] = "Invalid Token";
                header("Location:password-change.php?token=$token&email=$email");
            }
        } else {
            $_SESSION['error'] = "Please Complete All Fields";
            header("Location:password-change.php?token=$token&email=$email");
        }
    } else {
        $_SESSION['error'] = "No Token Available";
        header("Location:password-change.php");
    }
}
