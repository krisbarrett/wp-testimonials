<?php

require 'testimonials-options.php';

$options = load_options();

$name = $_POST["name"];
$email= $_POST["email"];
$testimonial = $_POST["testimonial"];

if($name != "" && $email != "" && $testimonial != "") {
	$ip = $_SERVER["REMOTE_ADDR"];
	$to = $options["send_to"];
	$domain = $options["domain"];
	$subject = "$name wrote a testimonial!";
	$body = "Name: $name\nEmail: $email\nIP:$ip\n\n$testimonial";
	mail($to, $subject, $body, "From: noreply@".$domain);
	echo "success!";
}
else {
	echo "$name $email $testimonial";
}

?>