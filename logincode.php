<?php
session_start();
include('admin/config/dbconn.php');

$response = ['success' => false, 'message' => '', 'errors' => []];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) {
        $response['errors']['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['errors']['email'] = 'Invalid email format.';
    }

    if (empty($password)) {
        $response['errors']['password'] = 'Password is required.';
    }

    if (empty($response['errors'])) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            $user_status = $user['status'];

            if (password_verify($password, $user['password'])) {

                if ($user_status == '1') {
                    $_SESSION['auth'] = true;
                    $_SESSION['auth_role'] = $user['role'];
                    $_SESSION['auth_user'] = [
                        'user_id' => $user['id'],
                        'user_fname' => $user['name'],
                        'user_email' => $user['email']
                    ];

                    // Define redirect URLs based on roles
                    $role_redirects = [
                        'admin' => 'admin/pages/dashboard',
                        'patient' => 'patient/index.php',
                        '2' => 'dentist/index.php',
                        '3' => 'staff/index.php'
                    ];

                    // Check role and redirect accordingly
                    if (array_key_exists($user['role'], $role_redirects)) {
                        $response['success'] = true;
                        $response['redirect'] = $role_redirects[$user['role']];
                    } else {
                        $response['message'] = 'Access Denied for your role.';
                    }
                } elseif ($user_status == '4') {
                    // Account not confirmed
                    $response['message'] = "You have not confirmed your account yet. Please check your inbox and verify your email.";
                } else {
                    // Account disabled
                    $response['message'] = "Your account is temporarily disabled. Please contact the admin.";
                }
            } else {
                $response['message'] = 'Invalid username or password.';
            }
        } else {
            $response['message'] = 'Invalid username or password.';
        }
    }
} else {
    // Unauthorized access to this file
    $_SESSION['message'] = "Access Denied.";
    // header('Location: patients.php');
    $response['redirect'] = 'patients.php';
}

echo json_encode($response);
