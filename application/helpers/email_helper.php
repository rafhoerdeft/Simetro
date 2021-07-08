<?php    
    if (!function_exists('kirim_email')) {
        function kirim_email($email='', $pesan=''){
            $CI = &get_instance();
            // Load PHPMailer library
            $CI->load->library('phpmailer_library');
            
            // PHPMailer object
            $mail = $CI->phpmailer_library->load();
            
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host     = 'ssl://smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kabmgl.diskominfo@gmail.com';
            $mail->Password = 'diskominfob0r0budur123';
            $mail->From = 'diskominfokabmgl@gmail.com';
            $mail->SMTPSecure = 'ssl';
            $mail->Port     = 465;
            
            $mail->setFrom('diskominfokabmgl@gmail.com', 'Diskominfo Kabupaten Magelang');
            $mail->addReplyTo('diskominfokabmgl@gmail.com', 'Diskominfo Kabupaten Magelang');
            
            // penerima
            $mail->addAddress($email);
            
            // Email subject
            $mail->Subject = 'Akun Simetro';
            
            // Set email format to HTML
            $mail->isHTML(true);
            
            // Email body content
            $mailContent = $pesan;
            $mail->Body = $mailContent;
            
            // Send email
            if(!$mail->send()){
                return false;
                // echo 'Message could not be sent.';
                // echo 'Mailer Error: ' . $mail->ErrorInfo;
            }else{
                return true;
            }
        }
    }
?>