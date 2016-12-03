<?php
    if ($_POST && isset($_FILES['uploaded_file'])) {
        $from_email = 'dheeraj.karnati1@marist.edu'; //sender email
        $recipient_email = 'dheeraj.karnati1@marist.edu'; //recipient email
        $subject = 'Test mail'; //subject of email
        $message = 'This is body of the message'; //message body

        //get file details we need
        $file_tmp_name = $_FILES['uploaded_file']['tmp_name'];
        $file_name = $_FILES['uploaded_file']['name'];
        $file_size = $_FILES['uploaded_file']['size'];
        $file_type = $_FILES['uploaded_file']['type'];
        $file_error = $_FILES['uploaded_file']['error'];
        // $user_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        if ($file_error > 0) {
            die('Thankyou for submitting the form. If you want to attach the file, please submit again with attachment.');
        }
        //read from the uploaded file & base64_encode content for the mail
        $handle = fopen($file_tmp_name, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $encoded_content = chunk_split(base64_encode($content));


        $boundary = md5("sanwebe");
        //header
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "From:" . $from_email . "\r\n";
        //$headers .= "Reply-To: ".$user_email."" . "\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n";

        //plain text
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($message));

        //attachment
        $body .= "--$boundary\r\n";
        $body .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "X-Attachment-Id: " . rand(1000, 99999) . "\r\n\r\n";
        $body .= $encoded_content;

        $sentMail = @mail($recipient_email, $subject, $body, $headers);
        if ($sentMail) //output success or failure messages
        {
            die('Thank you for your email');
        } else {
            die('Could not send mail! Please check your PHP mail configuration.');
        }

}
?>