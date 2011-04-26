<?php
	require 'testimonials-options.php';
	$options = load_options();
	$domain = $options['domain'];
?>

var $j = jQuery.noConflict();

$j(document).ready(function(){
	$j("form#testimonials").hide(0);
	$j("a#show_form").click(function() {
		$j("form#testimonials").slideToggle('slow');
	});
	$j("input#submit").click(function() {
		
		var name = $j("input#name");
		var email = $j("input#email");
		var testimonial = $j("textarea#testimonial");
		if(name.val() == "") {
			$j("label#name").attr("style", "color:red");
		}
		else {
			$j("label#name").attr("style", "color:black");
		}
		if(email.val() == "") {
			$j("label#email").attr("style", "color:red");
		}
		else {
			$j("label#email").attr("style", "color:black");
		}
		if(testimonial.val() == "") {
			$j("label#testimonial").attr("style", "color:red");
		}
		else {
			$j("label#testimonial").attr("style", "color:black");
		}
		if(name.val() == "" || email.val() == "" || testimonial.val() == "") {
			alert("Please include required fields.");
		}
		else {
			$j.post(
  				"http://<?php echo $domain ?>/wp-content/plugins/wp-testimonials/testimonials-email.php",
			  	{name: $j("input#name").val(), email: $j("input#email").val(), testimonial: $j("textarea#testimonial").val()},
			  	function(data) {
			  		if(data == "success!") {
			  			alert("Thank you for submitting a testimonial.");
			  			$j("form#testimonials").slideUp('slow');
			  		}
			  		else {
			  			alert("An error occurred while submitting your testimonial. Please try again.  If  the problem persists, then please contact website administrator.");
			  		}
			  	},
			  	"text"
			);
		}
	});
});