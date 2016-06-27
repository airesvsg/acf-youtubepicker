=== ACF YouTube Picker ===
Contributors: airesvsg
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=airesvsg%40gmail%2ecom&lc=BR&item_name=Aires%20Goncalves&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest
Tags: acf, youtube, picker, custom field, search, simple, field, custom
Requires at least: 3.5.0
Tested up to: 4.5.2
Stable tag: 3.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Search and select videos on YouTube without leaving the page.

== Description ==
Search and select videos on YouTube without leaving the page.

= Field Types =
This ACF field type is compatible with:

* ACF 5
* ACF 4

== Installation ==
1. Copy the `acf-youtubepicker` folder into your `wp-content/plugins` folder
2. Activate the `ACF YouTube Picker` plugin via the plugins admin page
3. Create a new field via ACF and select the `ACF YouTube Picker` type

== Screenshots ==
1. Field for you select the videos
2. Options 

== Frequently Asked Questions ==

= How to Obtain the API KEY? =
https://developers.google.com/youtube/v3/getting-started

== Changelog ==

= 3.1.0 =
* bugfix selecting single video ( https://github.com/airesvsg/acf-youtubepicker/issues/10 )
* bugfix css input non-webkit browsers ( https://github.com/airesvsg/acf-youtubepicker/issues/11 ) 

= 3.0.0 =
* rewrite ACF YouTubePicker ( https://github.com/airesvsg/acf-youtubepicker )
* rewrite YouTubePicker.js ( http://github.com/airesvsg/youtubepicker )
* bugfix when video is picked into Repeater or Flexible Content Field

= 2.4.1 =
* bugfix channelType parameter

= 2.4 =
* improve support acf-repeater

= 2.3 =
* added video duration in the answer

= 2.2 =
* added video url in the answer
* added options to choose the keys in the answer 

= 2.1 =
* added button for preview of videos