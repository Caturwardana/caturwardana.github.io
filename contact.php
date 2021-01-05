
<?php
    $mail_to = 'reynaldopratama84@gmail.com'; // specify your email here

    // Assigning data from the $_POST array to variables
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Construct email body
    $headers = 'From: ' . $name . "\r\n";
    $headers .= 'E-mail: ' . $email . "\r\n";
    $headers .= 'Phone: ' . $phone . "\r\n";
    $headers .= 'Message: ' . $message;

    // Construct email headers
    $body_message = 'From: ' . $email . "\r\n";
    $body_message .= 'Reply-To: ' . $email. "\r\n";

    $mail_sent = mail($mail_to, $body_message, $headers);

    if ($mail_sent == true){ ?>
        <script language="javascript" type="text/javascript">
        alert('Thank you for the message. We will contact you shortly.');
        window.location = 'index.php?sent';
        </script>
    <?php } else { ?>
    <script language="javascript" type="text/javascript">
        alert('Message not sent. Please, notify the site administrator admin@admin.com');
        window.location = 'index.php?error';
    </script>
    <?php
    }
?>
