<?php
function sendEmailNotification($to, $subject, $template, $data = []) {
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: ZewedJobs Admin <noreply@zewedjobs.com>\r\n";
    
    $message = file_get_contents("emails/$template.html");
    
    foreach ($data as $key => $value) {
        $message = str_replace("{{$key}}", $value, $message);
    }
    
    return mail($to, $subject, $message, $headers);
}
?>
