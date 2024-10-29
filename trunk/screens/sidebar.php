<!-- todo: update this message to check whether we have cloudmanager signup yet -->

<div class="postbox-container" style="width:300px;margin-left:30px">

	<div id="sidebar">

		<h2>Cloudmanager</h2>

		<p><a href="http://www.cloudsafe365.com" target="_blank">Cloudmanager</a> is a new service which makes managing your AWS account easier than ever.</p>

		<?php
		$options = get_option('aws_for_wp');

		if ($options['cloudmanager_email'] == ''):
			?>

			<p><a href="<?php echo admin_url();?>admin.php?page=aws_for_wp_cloudmanager_signup">Sign up for a free Cloudmanager Lite account today!</a></p>

		<?php else: ?>

			<p><a href="https://aws.cloudsafe365.com" target="_new">Login to your Cloudmanager account</a></p>

		<?php endif;?>

		<a href="http://www.cloudsafe365.com" target="_blank"><img width="300" src="<?php echo WP_PLUGIN_URL;?>/Aurora-Objects-For-Wordpress/images/cloudmanager-screenshot.png" alt="" /></a>

		<br />

	</div>
</div>
