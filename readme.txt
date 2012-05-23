=== Comic Easel ===
Contributors: frumph
Tags: comiceasel, easel, webcomic, comic, webcomic
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 1.0
Donate link: http://frumph.net
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Comic Easel allows you to post webcomics to your theme.


== Description ==

Comic Easel allows you to incorporate a WebComic using the WordPress Media Library functionality with Navigation into almost any WordPress theme. With just a few modifications of adding *injection* action locations into a theme, you can have the theme of your choice display a comic.

The core reason to use Comic Easel above other WordPress theme's is that you are not limited to the basic ComicPress & Other themes that are specifically designed for WebComics that utilize structures that you do not require or want to make use of. There are a plentiful amount of themes in the WordPress repository that you can now take advantage of that give you tons of options you otherwise wouldn't have had.

With Comic Easel's extra taxonomies to control Character and Locations, you can provide your end readers with a plethora of information that wouldn't have had before that is auto-generated. The Cast Page itself shows how many times a character was in a comic as well as the first comic they were seen in.

To Convert your existing ComicPress theme comics to Comic Easel's post type there is a plugin available called CP2CE.

= Features of 1.0 =

- Custom Post Type control of posts.
- Media Library handling of comics.
- As many chapters/stories as you would like.
- Individual navigation per chapter or all.
- Character and Location settings per Comic
- As many comic posts you can do in a day as you want.

= Widgets =

- Chapter Dropdown, brings you to the first comic in the chapter (story)
- Calendar display, show's you what days comic posts were made on, can add images and links to backgrounds.
- Recent Comics, a list of comics that have been posted as of late.
- Thumbnail, display a thumbnail of a random comic, or first/latest comic in a chapter (or all)

= Redirects = 

- `/?latest`  or `/?latest=<chapter-id>` in the url will automatically take the end user to the latest comic, or latest of a specific chapter
- `/?random` in the url will redirect to a random comic out of all the comics.

= Short Codes =

Shortcodes are simple embed statements that you can put into pages/post that display information.

- `[comic-archive]` Display a list of your comics by individual chapters or all.
- `[cast-page]` Display a list of all of your characters, how many comics they were in and when they first appeared

= Action Injection Locations =

A number of injection snippets that you add to your theme, mini navigation for the menubar, comic area and comic blost post area, including post-information is available to customize your theme out with auto generated information.


== Installation == 

= Modifying themes to use =

* Modify your theme adding `<?php do_action('comic-area'); ?>` in a position where to display the comic, generally it should be right above the #content and under the menu bar.

Generally the two files to edit is the index.php and the single.php, however some layouts are auto-generated with code and those you will need to seek advice out from their designers, the makers of those particular themes.

There are other "action" area's that you can put into your theme, not just the comic-area.  Those are being documented and will be available this coming week.


`do_action('comic_area');` - This is for the area you want your comic displayed on the home page and single pages.

`do_action('comic_blog_area');` - This is for the blog portion of the comic for the home page only.

`do_action('comic-mini-navigation');` - For menubar's to have mini navigation (prev/next) in them.

`do_action('comic-post-info');` - For inside of the single/archive/search post pages posts, showing more comic info.


== Frequently Asked Questions ==

= The permalinks are not working to go to the comic =

Go to your settings -> permalinks and just click save, the wp_rewrite will refresh.  This generally happens after it is first installed and should not happen again.


== Changelog ==

= 1.0 =
Last Updated: 05/23/2012 10am Pacific


== Upgrade Notice ==

= 1.0 =
Additions and fixes of 1.0 - reinstall it.




