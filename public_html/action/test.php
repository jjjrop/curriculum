<?php
$to = "to@example.com";
$subject = "TEST";
$message = "This is TEST.\r\nHow are you?";
$headers = "From: jjjrop@jjjrop.com";
mb_send_mail($to, $subject, $message, $headers);