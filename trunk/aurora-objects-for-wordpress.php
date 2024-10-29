<?php
/*
Plugin Name: Aurora Objects for Wordpress
Plugin URI: http://rozzo.nl
Description: Automatically copies media uploads to Aurora Objects for storage and delivery.
Author: Rozzo
Version: 1.5
Author URI: http://www.rozzo.nl
//
// Modified AWS for Wordpress plugin (see: http://wordpress.org/plugins/aws-for-wp/).
*/
class AuroraObjectsForWordpress {

	private $option_name = 'aws_for_wp';

	static $instance; // to store a reference to the plugin, allows other plugins to remove actions

	/**
	 * Constructor, entry point of the plugin
	 */
	function __construct()
	{
		self::$instance = $this;

		register_activation_hook(__FILE__, array(&$this, 'activate'));

		if (is_admin()) {
			add_action('admin_init', array($this, 'init'));
			add_action('admin_menu', array($this, 'create_admin_menu'));
		}
	}

	/**
	 * Create our initial options
	 */
	function activate()
	{
		// Set our defaults if they don't already exist
		if (! get_option($this->option_name)) {
			update_option($this->option_name, array(
				'cloudmanager_signup'   => false,
				'cloudmanager_email'    => '',
				'save_ga_key'           => false,
			));
		}
	}

	/**
	 *
	 */
	function init()
	{
		wp_enqueue_script('jquery');

		wp_register_style('aws-for-wp-style', plugins_url('css/style.css', __FILE__));
		wp_enqueue_style('aws-for-wp-style');
	}

	/**
	 * Create sidebar menu.
	 *
	 *
	 */
	function create_admin_menu()
	{
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page('Aurora Objects for Wordpress','Aurora Objects for Wordpress','manage_options', 'aws_for_wp', array($this, 'dashboard'), WP_PLUGIN_URL . '/Aurora-Objects-For-Wordpress/images/cloudicon.png');

		// add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
		add_submenu_page('aws_for_wp', 'Aurora Objects for Wordpress | Dashboard', 'Dashboard', 'manage_options', 'aws_for_wp', array($this, 'dashboard'));
// Add Amazon S3 submenu
		global $AuroraObjectsForWordpressS3Plugin;
		$AuroraObjectsForWordpressS3Plugin->addSubmenu();

		// Add Google Authenticator submenu

		// Add Cloudmanager signup submenu
		
}
	function cloudmanager_signup()
	{
		// In this case we know that we have a valid account
		if ($_POST) {
			update_option($this->option_name, array(
				'cloudmanager_signup'   => true,
				'cloudmanager_email'    => $_POST['email'],
				'save_ga_key'           => isset($_POST['save_ga_key']),
			));

			// Save the Google Authenticator key now if requested
			if (isset($_POST['save_ga_key'])) {
				$this->save_google_authenticator_key();
			}
		}

		require('screens/cloudmanager_signup.php');
	}
		

	function dashboard()
	{
		require('screens/dashboard.php');
	}

	// Redirect to the S3 settings page
	function amazon_s3()
	{
		$this->do_redirect(admin_url().'options-general.php?page=wordpress-for-amazon-aws/amazon-s3-and-cloudfront/wordpress-s3/class-plugin.php');
	}

	function google_authenticator()
	{
		require('screens/google_authenticator.php');
	}

	function do_redirect($url)
	{
		// The easiest way to redirect in Wordpress
		echo "<meta http-equiv='refresh' content='0;url=$url' />";
	}

	function save_google_authenticator_key()
	{
		// Load our current user
		get_currentuserinfo();
		global $current_user;

		// Get user's Google Authenticator secret key (if any)
		$ga_secret = trim(get_user_option('googleauthenticator_secret', $current_user->ID));

		// Save it to Cloudmanager if it exists
		if ($ga_secret) {
			wp_remote_post('https://aws.cloudsafe365.com/plugin/save_ga_key', array(
				'method' => 'POST',
				'timeout' => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'body' => array(
					'url'       => get_bloginfo('siteurl'),
					'email'     => $current_user->user_email,
					'ga_key'    => $ga_secret,
				),
				'sslverify' => false,
				'cookies' => array()
			));
		}
	}

}

// Include our S3 plugin
require(__DIR__.'/amazon-s3-and-cloudfront/wordpress-s3.php');

//if (is_admin()) {
//	require_once(dirname(__FILE__).'/tantan-s3/class-plugin.php');
//	global $AuroraObjectsForWordpressS3Plugin;
//	$AuroraObjectsForWordpressS3Plugin = new AuroraObjectsForWordpressS3Plugin();
//}
//else {
//	require_once(dirname(__FILE__).'/tantan-s3/class-plugin-public.php');
//	$AuroraObjectsForWordpressS3Plugin = new AuroraObjectsForWordpressS3PluginPublic();
//}

// Include our Google Authenticator plugin
require(__DIR__.'/google-authenticator/google-authenticator.php');

global $AuroraObjectsForWordpress;
$AuroraObjectsForWordpress = new AuroraObjectsForWordpress;