<script>
jQuery(document).ready(function() {

	jQuery('#first_name').focus();

	var submitting = false;

	jQuery('#cloudmanager_signup_form').submit(function(e, validated) {

		if (validated) {
			return;
		}
		else {
			e.preventDefault();
		}

		// Check for empty fields
		var fields = ['#first_name', '#last_name', '#email'];

		for (var i = 0; i < fields.length; i++) {
			if (jQuery(fields[i]).val().trim() == '') {
				jQuery('div#signup-error').text('Please complete all fields').show();
				jQuery(fields[i]).select();
				return;
			}
		}

		// Check that we have a valid email address
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if( ! emailReg.test(jQuery('#email').val())) {
			jQuery('div#signup-error').text('Please enter a valid email address').show();
			jQuery('#email').select();
			return;
		}

		// Hide the form and show the loader
		jQuery('form#cloudmanager_signup_form').hide();
		jQuery('div#signup-error').hide();
		jQuery('div#loading').show();

		// Create an account.
		jQuery.ajax({
			// url: 'http://cloudmanager/signup/plugin',
			url: 'https://aws.cloudsafe365.com/signup/plugin',
			data: {
				firstName: 		jQuery('#first_name').val(),
				lastName: 		jQuery('#last_name').val(),
				email: 			jQuery('#email').val(),
				wordpressUrl:   '<?php echo get_bloginfo('siteurl');?>'
			},
			async: false,
			jsonpCallback: 'jsonCallback',
			contentType: "application/json",
			dataType: 'jsonp',
			success: function(json) {
				// check whether user's email address is already in use
				if (json.success)
				{
    				jQuery('#cloudmanager_signup_form').trigger("submit", [true]);
				}
				else
				{
					jQuery('div#signup-error').text('Sorry, that email address is already taken. Please enter a different one.').show();
					jQuery('div#loading').hide();
					jQuery('form#cloudmanager_signup_form').show();
					jQuery('#email').select();
				}
			},
			error: function(e) {}
		});
	});

});
</script>

<div class="wrap">

	<h2 id="write-post">AWS For Wordpress - Cloudmanager</h2>

	<div class="separator"></div>

	<div class="postbox-container" style="width:600px; padding: 0 20px 0 0;">

		<?php $options = get_option('aws_for_wp'); ?>

		<?php if ($options['cloudmanager_signup']):?>

		<p>Thanks for signing up with Cloudmanager!</p>

		<p>We have sent a confirmation email containing your login details to <strong><?php echo $options['cloudmanager_email'];?></strong></p>

		<p><a href="https://aws.cloudsafe365.com" target="_blank">Login to your Cloudmanager account</a></p>

		<?php else: ?>

		<p>Cloudmanager is a new service which makes managing your AWS account easier than ever.</p>

		<p>We can also save a backup of your Google Authenticator key in case you lose it.</p>

		<p><a href="http://www.cloudsafe365.com" target="_blank">Click here for more information about the features offered by Cloudmanager</a></p>

		<p>To sign up for a free Cloudmanager Lite account, please enter your details below:</p>

		<div class="separator"></div>

		<div id="loading" style="display:none">
			<p>Creating Cloudmanager account...</p>
			<img src="<?php echo plugins_url();?>/aws-for-wp/images/ajax-loading.gif" alt="" />
		</div>

		<div id="signup-error" style="display:none"></div>

		<form id="cloudmanager_signup_form" action="" method="POST">

			<input type="hidden" name="cloudmanager_signup" value="1" />

			<table>
				<tr>
					<td>First name: </td>
					<td><input type="text" name="first_name" id="first_name" /></td>
				</tr>
				<tr>
					<td>Last name: </td>
					<td><input type="text" name="last_name" id="last_name" /></td>
				</tr>
				<tr>
					<td>Email address: </td>
					<td><input type="text" name="email" id="email" /></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input class="checkbox double" type="checkbox" id="save_ga_key" name="save_ga_key" checked="checked" />
						<label for="save_ga_key">Save a backup of my Google Authenticator key</label>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" id="btn-submit" value="Create Cloudmanager account" /></td>
				</tr>
			</table>
		</form>

		<?php endif; ?>

	</div>
</div>
