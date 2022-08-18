=== B2 Private Files ===
Contributors: darwinbiler
Donate link: https://www.buymeacoffee.com/kt7vrlS6F
Tags: media library, download, premium content, protect assets, digital rights
Requires at least: 3.0.1
Tested up to: 6.0.1
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Serve token-protected files hosted in Backblaze B2 in your WordPress Site

== Description ==

If you have a digital products (downloadable pdf, mp3, mp4 etc) that is supposedly being accessed by registered/paying users, uploading them into the standard media library have problems:

* the files in `wp-content/uploads` is publicly accessible, and anyone can basically download the file directly there
* huge files like movies or software installers will weigh your entire website down (specially when multiple users is gonna be downloading them)

This plugin allows you to securely share files to your website users by passing a token to the url. For example, here is a file hosted in B2 Backblaze

https://f001.backblazeb2.com/file/wp-b2-private-files/key.jpg?Authorization=4_0018c3b251e15120000000012_01a459bb_2f35e1_acct_QGJ-TljNx-NqgRLi1dff_XGJjlQ=

note that simply accessing `https://f001.backblazeb2.com/file/wp-b2-private-files/key.jpg` wont work, as the file is token-protected.
the plugin generates the value for `Authorization` parameter when your post/page is rendered. The token can be only generated from your website, thus its impossible for any other site to crawl your site and scrape the files.


Each token generated can be also configured to expire after N minutes. So if lets say you generated a download link to a big installer, people cant re-use the same link and paste it in public forums, chats etc.
Because the link will expire after few minutes, which makes it hard for user to share file to non-registered users.


== Installation ==

Get started by following these steps:

1. Upload `b2-private-files.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to https://www.backblaze.com/b2/sign-up.html and signup for a BackBlaze B2 account
4. Create a new Bucket, make sure it is a private one.
5. Create a new app key, in Account > App Keys > Add a New Application Key
6. In your Wordress Admin, go to Settings > B2 Private Files
7. Fill up the Account ID / Key ID, Application Key, Bucket ID, Bucket Name

== Usage ==

1. Go to Media > Add New (Private)
2. Upload any file
3. Go to Media > Library (Private)
4. Click "Shortcode" for the file you just uploaded
5. Paste the shortcode anywhere you wanted to show the link


Generally the shortcode looks like this:

[b2-private-file-button filename="my-installer.zip"]

the above shortcode will generate a button with caption "Download", pointing to the Backblaze B2 file with token passed to it.


== Frequently Asked Questions ==

= Can I upload file in B2 directly? =

Yes, you dont need to upload the file via WordPress admin. You can use any client to upload large file into B2.
The plugin will detect those and generate download link for you.

= Can i use this as an alternative to CDN? =

Its possible, but its not optimized for that use-case. As the files token is being calculated on the fly.

== Screenshots ==

1. Listing the contents of your B2 Bucket.
2. New menu item added alongside with standard Library

== Changelog ==

= 1.0.2 =
* plugin submission requirements / fixes

= 1.0.1 =
* plugin submission requirements / fixes
* fix bug wherein error message is not showing after upload to b2

= 1.0.0 =
* ability to configure B2 settings
* ability to upload files to B2.
* ability to render button shortcode
* ability to manage files in B2 (delete and list)


