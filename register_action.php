<?php
session_start();
include('admin/config/dbconn.php');
include('superglobal.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

date_default_timezone_set("Asia/Manila");

function sendmail_verify($email, $verify_token, $system_name, $mail_link, $mail_host, $mail_username, $mail_password)
{
    // $mail->SMTPDebug = 2;	
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $mail_host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $mail_username;
    $mail->Password   = $mail_password;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom($mail_username,$system_name);
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Email verification from ' . $system_name;

    $email_template = "	
            <h2>  registered with $system_name </h2> 	
            <p> Please click the link below to verify your email address and complete the registration process.</p>	
            <p> You will be automatically redirected to sign in page.</p>	
            <p>Please click below to activate your account:</p>	
            <a href='$mail_link/verify_email.php?token=$verify_token'> Click Here </a>	
            ";
    $mail->Body = $email_template;
    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$response = ['success' => false, 'message' => '', 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and validate inputs
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $dob = isset($_POST['birthday']) ? trim($_POST['birthday']) : ''; 
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $regdate = date('Y-m-d H:i:s');
    $verify_token = md5(rand());
    $filename = '';

    // Validate required fields
    if (empty($fname)) {
        $response['errors']['fname'] = 'First name is required.';
    }
    if (empty($lname)) {
        $response['errors']['lname'] = 'Last name is required.';
    }
    if (empty($address)) {
        $response['errors']['address'] = 'Address is required.';
    }
    if (empty($phone)) {
        $response['errors']['phone'] = 'Phone is required.';
    }
    if (empty($email)) {
        $response['errors']['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['errors']['email'] = 'Invalid email format.';
    }
    if (empty($password)) {
        $response['errors']['password'] = 'Password is required.';
    }
    if (empty($confirmPassword)) {
        $response['errors']['confirmPassword'] = 'Confirm password is required.';
    } elseif ($password !== $confirmPassword) {
        $response['errors']['confirmPassword'] = 'Passwords do not match.';
    }
    if (empty($gender)) {
        $response['errors']['gender'] = 'Gender is required.';
    }
    if (empty($dob)) {
        $response['errors']['birthday'] = 'Date of birth is required.';
    }
    if (empty($address)) {
        $response['errors']['address'] = 'Address is required.';
    }
    if (empty($phone)) {
        $response['errors']['phone'] = 'Phone number is required.';
    }

    // Return errors if validation fails
    if (!empty($response['errors'])) {
        echo json_encode($response);
        exit;
    }

    // Check if email already exists
    $checkemail = "SELECT * FROM users WHERE email='$email'";
    $checkemail_run = mysqli_query($conn, $checkemail);
    if (mysqli_num_rows($checkemail_run) > 0) {
        $response['message'] = 'Email already exists.';
        echo json_encode($response);
        exit;
    }

    // Handle file upload if provided
    if (isset($_FILES['patient_image']) && $_FILES['patient_image']['name'] != '') {
        $image = $_FILES['patient_image']['name'];
        $allowed_file_format = ['jpg', 'png', 'jpeg'];
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);

        if (!in_array($image_extension, $allowed_file_format)) {
            $response['message'] = 'Invalid file format. Only JPG, PNG, or JPEG allowed.';
            echo json_encode($response);
            exit;
        }

        if ($_FILES['patient_image']['size'] > 5000000) { // 5MB limit
            $response['message'] = 'File size exceeds 5MB limit.';
            echo json_encode($response);
            exit;
        }

        $filename = time() . '.' . $image_extension;
        move_uploaded_file($_FILES['patient_image']['tmp_name'], 'upload/service/' . $filename);
    } else {
        // Generate a placeholder image
        $character = strtoupper($fname[0]); // Use the first letter of the first name
        $path = time() . ".png";
        $imagecreate = imagecreate(200, 200);
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);
        imagecolorallocate($imagecreate, 230, 230, 230);
        $textcolor = imagecolorallocate($imagecreate, $red, $green, $blue);
        imagettftext($imagecreate, 100, 0, 55, 150, $textcolor, 'admin/font/arial.ttf', $character);
        imagepng($imagecreate, 'upload/service/' . $path);
        imagedestroy($imagecreate);
        $filename = $path;
    }

    // Hash the password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $sql = "INSERT INTO tblpatient (fname, lname, address, dob, gender, phone, email, image, password, role, verify_token, created_at)
            VALUES ('$fname', '$lname', '$address', '$dob', '$gender', '$phone', '$email', '$filename', '$hash', 'patient', '$verify_token', '$regdate')";

    $patient_query_run = mysqli_query($conn, $sql);

    if ($patient_query_run) {
        // Send verification email
        sendmail_verify("$email", "$verify_token", $system_name, $mail_link, $mail_host, $mail_username, $mail_password);
        $response['success'] = true;
        $response['message'] = "We've sent an email to $email. Please check your email and click the link to verify.";
    } else {
        $response['message'] = 'Registration failed. Please try again later.';
    }

    echo json_encode($response);
}