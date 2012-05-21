=== Comic Easel ===
Contributors: frumph
Tags: comiceasel, easel, webcomic, comic, webcomic
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 1.0
Donate link: http://frumph.net

Comic Easel allows you to post webcomics to your theme.

== Description ==

Comic Easel is a plugin that allows you to incorporate webcomics into your existing WordPress theme.

To Convert your existing ComicPress theme comics to Comic Easel's post type there is a plugin available called CP2CE.

[WARNING] This plugin is currently - In Developement

Updated 1:15am 05/21/2012
- Fixed the config screens to allow tabbed config panels, created couple more options

Updated 8:15pm 05/20/2012
- Comic posts on the front page now have the correct post ;/

Updated 6:25pm 05/20/2012
- Added syndication filters so that the comic posts appear in the main feed w/medium sized thumbnail

Ver 1.0 - Updated 5:30pm 05/20/2012
- Added shortcode `[cast-page]` - Create a page, add the shortcode and it will take all your "characters" and make a page for them, you can add descriptions in the wp-admin -> comics -> characters interface.

== Other Notes == 

= Modifying themes to use =

* Modify your theme adding `<?php do_action('comic-area'); ?>` in a position where to display the comic, generally it should be right above the #content and under the menu bar.

Generally the two files to edit is the index.php and the single.php, however some layouts are auto-generated with code and those you will need to seek advice out from their designers, the makers of those particular themes.

There are other "action" area's that you can put into your theme, not just the comic-area.  Those are being documented and will be available this coming week.


`do_action('comic_area');` - This is for the area you want your comic displayed on the home page and single pages.

`do_action('comic_blog_area');` - This is for the blog portion of the comic for the home page only.


== Screenshots == 

1. The Comic Editor Section
