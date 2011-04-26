<?php
/*
Plugin Name: Testimonials
Plugin URI: https://krisbarrett@github.com/krisbarrett/wp_testimonials.git
Description: Inserts a testimonials form at the end of a user specified page.
Version: 0.1.0
Author: Kris Barrett
Author URI: http://www.krisbarrett.com
License: GPL
*/

require 'testimonials-options.php';

function testimonials_form($content) {
	$options = load_options();
	$id = get_the_ID();
	$form = "";
	if(is_page() && $id == $options["page_id"]) {
		$form = <<<EOT
		<div id="testimonials-form">
		<br/>
		<a name="prompt"></a><strong>Current and former clients, please click <a name="show_form" id="show_form" onmouseover="this.style.cursor='pointer'">here</a> to write a testimonial.</strong>
		<br/>
		<br/>
		<form method="post" id="testimonials">
		Your email will not be published.<br/>
		<br/>
		<label for="name" id="name">Name: </label><br/>
		<input type="text" name="name" id="name" size="30"><br/>
		<br/
		<label for="email" id="email">Email: </label><br/>
		<input type="text" name="email" id="email" size="30"><br/>
		<br/>
		<label for="testimonial" id="testimonial">Testimonial: </label><br/>
		<textarea name="testimonial" id="testimonial" cols="40" rows="10">
</textarea><br/>
		<br/>
		<input type="button" value="Submit" id="submit"/>
		</form>
		</div>
EOT;
	}
	return $content . $form;
}

add_filter( 'the_content', 'testimonials_form');

function include_js() {
	$options = load_options();
	$domain = $options['domain'];
	wp_enqueue_script("jquery");
	wp_deregister_script("testimonials");
	wp_register_script("testimonials", "http://$domain/wp-content/plugins/wp-testimonials/testimonials-js.php");
	wp_enqueue_script("testimonials");
}

add_action( 'init', 'include_js');

?>