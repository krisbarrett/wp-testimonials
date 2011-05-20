<?php
/*
Plugin Name: Testimonials
Plugin URI: https://krisbarrett@github.com/krisbarrett/wp_testimonials
Description: Inserts a testimonials form at the end of a user specified page.
Version: 0.1.1
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
		<label for="name" id="name_label">Name: </label><br/>
		<input type="text" name="name" id="name" size="30"><br/>
		<br/>
		<label for="email" id="email_label">Email: </label><br/>
		<input type="text" name="email" id="email" size="30"><br/>
		<br/>
		<label for="testimonial" id="testimonial_label">Testimonial: </label><br/>
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

add_action('admin_init', 'kb_testimonials_options_init' );
add_action('admin_menu', 'kb_testimonials_add_page');

// Init plugin options to white list our options
function kb_testimonials_options_init(){
        register_setting( 'kb_testimonials_options', 'options');
}

// Add menu page
function kb_testimonials_add_page () {
        add_options_page('Testimonials Options', 'Testimonials', 'manage_options', 'kb_testimonials_options', 'kb_testimonials_options_do_page');
}

// Draw the menu page itself
function kb_testimonials_options_do_page() {
        ?>
        <div class="wrap">
                <h2>Testimonials Options</h2>
                <form method="post" action="options.php">
                        <?php settings_fields('kb_testimonials_options'); ?>
                        <?php $options = get_option('options'); ?>
                        <table class="form-table">
                                <tr valign="top"><th scope="row">Page ID</th>
                                        <td><input type="text" name="options[page_id]" value="<?php echo $options['page_id']; ?>" /></td>
                                </tr>
 <tr valign="top"><th scope="row">Email</th>
                                        <td><input type="text" name="options[email]" value="<?php echo $options['email']; ?>" /></td>
                                </tr>
 </tr>
 <tr valign="top"><th scope="row">Domain</th>
                                        <td><input type="text" name="options[domain]" value="<?php echo $options['domain']; ?>" /></td>
                                </tr>                        
</table>
                        <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                        </p>
                </form>
        </div>
        <?php
}
?>
