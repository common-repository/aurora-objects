=== Aurora Objects for WordPress ===
Modified AWS for Wordpress plugin to update all files automatically to Aurora Objects in stead of Amazon S3.

=== Aurora Objects for WordPress ===
Tags: uploads, amazon, aws, s3, mirror, admin, media, cdn, cloudfront, security, google authenticator, 2-factor authentication, cloudmanager, aurora, auroraobjects,pcextreme,rozzo
Author URI: http://www.rozzo.nl
Author: roZZo
Requires at least: 3.2
Tested up to: 3.5.1
Stable tag: 2.0
Version: 2.0
License: GPLv3

Copy media uploads to Aurora Cloudstack for storage and delivery. 
== Description ==

This plugin automatically copies any media added through WordPress' media uploader to [Aurora Objects](https://www.pcextreme.nl/en/aurora/). It then automatically replaces the URL to each media file with their respective AuroraObjects URL. Image thumbnails are also copied to Aurora Objects and delivered through there.

Uploading files *directly* to your Aurora Objects account/bucket is not currently supported by this plugin. Also, if you're adding this plugin to a site that's been around for a while, your existing media files will not be copied or served from Aurora Objects. Only newly uploaded files will be copied and served from Aurora Objects.

You'll also find a new icon next to the "Add Media" button when editing a post. This allows you to easily browse and manage files in your Aurora Objects Bucket.

*This plugin is based on an existing plugin:
[Amazon Web Services for WordPress](http://wordpress.org/plugins/amazon-web-services/).*

== Installation ==

1. Use WordPress' built-in installer
2. Access the Aurora Objects for Wordpress option under Aurora Objects For Wordpress > Aurora Objects and configure your details

== Screenshots ==

1. Plugin dashboard
2. Configure Aurora Objects
3. Browse Aurora Objects bucket
