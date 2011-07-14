<?php

require_once( '../../../../wp-load.php' );

$sitename = get_bloginfo( 'name' );
$siteurl =  get_bloginfo( 'siteurl' );

$to = isset( $_POST['contact_to'] ) ? trim( $_POST['contact_to'] ) : '';
$name = isset( $_POST['contact_name'] ) ? trim( $_POST['contact_name'] ) : '';
$email = isset( $_POST['contact_email'] ) ? trim( $_POST['contact_email'] ) : '';
$content = isset( $_POST['contact_content'] ) ? trim( $_POST['contact_content'] ) : '';

$error = false;

if ($to === '' || $email === '' || $content === '' || $name === ''){
	$error = true;
}
if ( ! preg_match( '/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email ) ) {
	$error = true;
}
if ( ! preg_match( '/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $to ) ) {
	$error = true;
}

if ( $error == false ) {
	$subject = "New message from $name";
	$body = "Site: $sitename ($siteurl) \r\nName: $name \r\nEmail: $email \r\nMessages: $content";
	$headers = "From: $sitename <$to>\r\nReply-To: $email\r\n";
	
	if ( wp_mail( $to, $subject, $body, $headers ) ) {
        echo '<div class="success">Your mail was sent successfully! <strong>Thank you!</strong></div>';
    }
    else {
        echo '<div class="error">Something went wrong with sending your e-mail. Please try again!</div>';
    }
}