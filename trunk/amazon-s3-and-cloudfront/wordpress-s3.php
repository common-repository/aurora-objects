<?php
/*
Plugin Name: Amazon S3 and CloudFront
Plugin URI: https://github.com/bradt/wp-tantan-s3
Description: Automatically copies media uploads to Amazon S3 for storage and delivery. Optionally configure Amazon CloudFront for even faster delivery.
Author: Brad Touesnard
Version: 0.5
Author URI: http://bradt.ca

// Copyright (c) 2013 Brad Touesnard. All rights reserved.
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************
//
// Forked Amazon S3 for WordPress with CloudFront (http://wordpress.org/extend/plugins/tantan-s3-cloudfront/)
// which is a fork of Amazon S3 for WordPress (http://wordpress.org/extend/plugins/tantan-s3/).

*/
if (class_exists('AuroraObjectsForWordpressS3Plugin')) return;

// s3 lib requires php5
//if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/') >= 0) { // just load in admin
if (is_admin()) {
	$ver = get_bloginfo('version');
    if (version_compare(phpversion(), '5.0', '>=') && version_compare($ver, '2.1', '>=')) {
        require_once(dirname(__FILE__).'/wordpress-s3/class-plugin.php');
        global $AuroraObjectsForWordpressS3Plugin;
	    $AuroraObjectsForWordpressS3Plugin = new AuroraObjectsForWordpressS3Plugin();
	} elseif (ereg('wordpress-mu-', $ver)) {
        require_once(dirname(__FILE__).'/wordpress-s3/class-plugin.php');
        $AuroraObjectsForWordpressS3Plugin = new AuroraObjectsForWordpressS3Plugin();
    } else {
        class AuroraObjectsForWordpressS3Error {
        function AuroraObjectsForWordpressS3Error() {add_action('admin_menu', array(&$this, 'addhooks'));}
        function addhooks() {add_options_page('Aurora Objects', 'Aurora Objects', 10, __FILE__, array(&$this, 'admin'));}
        function admin(){include(dirname(__FILE__).'/wordpress-s3/admin-version-error.html');}
        }
        $error = new AuroraObjectsForWordpressS3Error();
    }
} else {
    require_once(dirname(__FILE__).'/wordpress-s3/class-plugin-public.php');
    $AuroraObjectsForWordpressS3Plugin = new AuroraObjectsForWordpressS3PluginPublic();
}
?>
