<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'include/PHPMailer/Exception.php';
require 'include/PHPMailer/PHPMailer.php';
require 'include/PHPMailer/SMTP.php';

function sendWelcomeEmail($user_email, $user_name) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-email@gmail.com'; 
        $mail->Password   = 'your-gmail-app-password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('your-email@gmail.com', 'Eventsiful');
        $mail->addAddress($user_email, $user_name);

        $mail->isHTML(true);
        $mail->Subject = 'Welcome to the Events Registration System!';
        $mail->Body    = "Hi $user_name,<br><br>Thank you for registering on our platform. We're excited to have you!";
        $mail->AltBody = "Hi $user_name,\n\nThank you for registering on our platform. We're excited to have you!";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// --- Example usage (e.g., in register.php after success) ---
// if (mysqli_stmt_execute($stmt)) {
//     sendWelcomeEmail($email, $name);
//     echo "Registration successful! A confirmation email has been sent.";
// }
?>
