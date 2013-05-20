=== Comic Easel ===
Contributors: Frumph
Tags: comiceasel, easel, webcomic, comic, webcomic
Requires at least: 3.2
Tested up to: 3.5.1
Stable tag: 1.3.10
Donate link: http://frumph.net
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Comic Easel allows you to post webcomics to your theme.


== Description ==

Comic Easel Website: [Comic Easel](http://comiceasel.com/ "Comic Easel - Plugin your WebComic")
Tech Support Forum: [Frumph.NET Forums](http://forum.frumph.net/ "The Forums for Frumph.NET")

Comic Easel allows you to incorporate a WebComic using the WordPress Media Library functionality with Navigation into almost any WordPress theme. With just a few modifications of adding *injection* action locations into a theme, you can have the theme of your choice display a comic.

The core reason to use Comic Easel above other WordPress theme's is that you are not limited to the basic ComicPress & Other themes that are specifically designed for WebComics that utilize structures that you do not require or want to make use of. There are a plentiful amount of themes in the WordPress repository that you can now take advantage of that give you tons of options you otherwise wouldn't have had.

With Comic Easel's extra taxonomies to control Character and Locations, you can provide your end readers with a plethora of information that wouldn't have had before that is auto-generated. The Cast Page itself shows how many times a character was in a comic as well as the first comic they were seen in.

Comic Easel is *not* an upgrade to ComicPress, it is a different CMS that has a migration path available from ComicPress to Comic Easel.   The ComicPress theme has functionality that the theme you choose might not.

To Convert your existing ComicPress theme comics to Comic Easel's post type there is a plugin available called CP2CE.

= Features =

- Custom Post Type control of posts.
- Media Library handling of comics.
- As many chapters/stories as you would like.
- Individual navigation per chapter or all.
- Character and Location settings per Comic
- As many comic posts you can do in a day as you want.
- Hovertext on the comic
- Using translate plugins, every comic and post can be multilanguage
- Navigation widget that mimics ComicPress's navigation widget including custom graphic sets that can be pulled from themes
- chapter navigation in a variety of different methods
- can create a gallery of comics for a post
- transcripts
- And more!

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

- `[comic-archive list=0/1/2 chapter=# thumbnail=0/1]` Display a list of your comics by individual chapters or all.
* list=0 (default) - All chapters, not in parent->child relationship
* chapter=# if list=0 and chapter=# (# = chapter ID number) do a singular view
* list=1 if list=1 do it for series that has parent->child book->chapter (chapter= will not work)
* list=2 by year archive, will print a list of years the comic has been made in and show all comics for that year
* thumbnail=1 display the thumbnail of the first post it finds 
- `[cast-page]` Display a list of all of your characters, how many comics they were in and when they first appeared
- `[transcript]` Display the transcript of the comic whereever you like within the post
* display=(raw/br/styled*) styled = default [transcript display=raw] = no special output.

= Action Injection Locations =

A number of injection snippets that you add to your theme, mini navigation for the menubar, comic area and comic blost post area, including post-information is available to customize your theme out with auto generated information.


== Installation == 

= Setting up Thumbnail sizes before adding your comics =

In the WP-ADMIN -> Settings -> Media, you can set the thumbnail widths that you would want to use on your site.

The "thumbnail size" default 150x150 cropped works just fine.  Some users of Comic Easel have noted that it doesn't look the greatest for all comics so they suggest unchecking the box for crop thumbnil and setting the width to 198 (barely less then the width of the sidebars) and then removing the contents of height on thumbnail medium and large sizes.  This is all depends on your comic.

Further down the Media page is the [x] Organize my uploads into month- and year-based folders, this is a *must* have since it will organize your comics into sep. directories for you.

If you don't like the size of your thumbnails you have set, there are several plugins available on the WordPress repository available to regenerate all of your thumbnails.


= Modifying themes to use =

* Modify your theme adding `<?php do_action('comic-area'); ?>` in a position where to display the comic, generally it should be right above the #content and under the menu bar.

Generally the two files to edit is the index.php and the single.php, however some layouts are auto-generated with code and those you will need to seek advice out from their designers, the makers of those particular themes.

There are other "action" area's that you can put into your theme, not just the comic-area.  


`do_action('comic_area');` - This is for the area you want your comic displayed on the home page and single pages.

`do_action('comic_blog_area');` - This is for the blog portion of the comic for the home page only.

`do_action('comic-mini-navigation');` - For menubar's to have mini navigation (prev/next) in them.

`do_action('comic-post-info');` - For inside of the single/archive/search post pages posts, showing more comic info.

`do_action('comic-post-extras');` - Inside the individual post loop, preferably at the bottom after the post div.  Show's a list of related comics.

`do_action('comic-transcript');` - generally used under the_content() to display the transcript of the post, if you do not want to use the [transcript] shortcode, this will make it so that it always displays if there is a transcript

= Adding the Comic area sidebars =

Sidebars for Comic Easel are added automatically since 05/28/2012 They should appear above all of your other sidebars in the widget panel; and can be toggled on and off in the config.


== Frequently Asked Questions ==

Comic Easel Website, Troubleshoot Page: [Comic Easel](http://comiceasel.com/faqs/troubleshoot/ "Comic Easel - Plugin your Website - Troubleshooting Comic Easel")

= The permalinks are not working to go to the comic =

Go to your settings -> permalinks and just click save, the wp_rewrite will refresh.  You need to go to the settings -> permalinks if you ever upgrade enable or disable the Comic Easel plugin.

= Where is Comic Easel's navigation widget? =

The comic navigation widget is only seen if you have the comic sidebar's enabled; even then it only works in the comic sidebars themself, nowhere else.


== Changelog ==
= 1.3.10 =
removed some taxonomies from having their own feed, caused search engines to freak out
replaced some home_url with admin_url for admin location links in the admin_meta
restored the protect/unprotect but renamed them ceo_protect ceo_unprotect, wp_reset_query was having 'issues'
added injection of the comic-easel version number as a meta tag for the <head> section
fixed some injection code where it was returning at the wrong time for the post-info
started working on adding chapter= references to the cast-page (not working yet, don't use)
chapter= argument now works inside cast-page so that you can seperate the casts between different comics


= 1.3.9 =
New widget, which displays mini thumbnails with hovercards of the cast members who are in the current comic - courtesy of Chris Maverick.   Fixed navigation issues, added another option to navigation widget; It no longer erases the titles when clicking save on first time adding it to the sidebar.  Cleaned up some coding in all of the other widgets. Replaced most of the protect() unProtect() with wp_reset_query().  Comic blog post widget now has an Ordering based on the option in the config.  

= 1.3.8 =
Revamped the cast-page shortcode, in tables now, also shows most recent comic the character was in, cast-page now accepts order=(asc/desc) and limit=# arguments documentation now available at comiceasel.com

= 1.3.7 =
New debug screen for variables and system information. (for me to help people with mainly)
New option to enable transcripts to appear at the bottom of posts if the transcript exists instead of using the shortcode.  Disable if you want to use the shortcode instead.
added: 
bug fix for default values not setting when plugin updates, if the option for transcripts is enables in the config disable use of the shortcode [transcript] while it's active

= 1.3.6 =
Introducing Comic Easel - Import  (comic -> import in the wp-admin)

= 1.3.5 =
Added multi thumbnail plugin coding so you can have 2 images per comic, one teaser image used  in the thumbnail widget and wherever else you code it in.
CSS Adjustments to some of the navigation images
added esc_attr checks to the thumbnail widget for extra security


= 1.3.3 =
added new list= to the shortcode for [comic-archive list=3] will show yearly archive of comics, all on one page

= 1.3.2 =
Added new list= to the shortcode for [comic-archive list=2] will show a yearly archive of comics split up into linkable pages

= 1.3 =
Chapter Order Fields fixed

= 1.2 =
Attempt at a navigation fix for the widget for front page ASC/DESC changes
Also fixed (hopefully) the name change after saving the widget

= 1.1 =
Added option to allow making the first comic appear on the home page
the comic's blog post now will search for content-comic.php in the theme/child themes directory and use that if it exists

= 1.0.19 = 
Fixed problem with tags and the archive
reverted previous change to not showing chapters that were empty in the archive dropdown
not flushing wp_rewrite on deactivation - should set the permalinks properly now on activation

= 1.0.16 =
Added #blogheader div that appears under the comic's blog post on the home page.

= 1.0.14 =
Made it so that the navigation widget shows up whether the comic sidebars are active or not.  They should work in any sidebar now.
added function ceo_in_comic_category() for a conditional statement to check if the page is in the comic category

= 1.0.13 =
Some additions to the language code, possible fox for the undefined problem with archive comic post types, various css fixes

= 1.0.12 =
Never program while mad at the world ;/ apparently you make some mistakes in backwards compatibility.

= 1.0.11 =
Removed URLRewrite /comic/#date#/ code since it was causing behavior problems
Fixed the click to next and mini navigation to navigate per the setting in the config all chapters or just in chapter

= 1.0.10 = 
Fix for RSS feeds, the problem was the action hook for it
update: possible fix for clearing cache when custom post type is published with w3 total cache

= 1.0.9 =
Use hovertext as well as comic-hovertext in the meta fields for those coming from ComicPress

= 1.0.8 =
Bug fixes for shortcodes, and placement of shortcodes.

= 1.0.7 =
Chapter ordering is now part of the plugin, if you see any errors report them, deactivate the plugin and reactivate.

= 1.0.5 =
Chapter Navigation (prev/next chapter)
Various little bug fixes here and there

= 1.0.4 =
Fixed wrong function in filter for archive
added option for turning off the mininav if it's implemented
fixed the mininav to not be enabled of on the home page the comic is diabled

= 1.0.3 =
Navigation Widget, Calendar widget, bug fixes and new code for navigating in chapters/all.
New options for setting the thumbnail size for various locations that use thumbnails

= 1.0.2 =
Added Sidebar generators for no matter what theme you use.
Added the Navigation Widget, which replaces the default navigation, it shares the same skinning as ComicPress and will often times be able to use the navstyle from ComicPress.

= 1.0.1 =
Updated: 05/26/2012 12:25am Pacific
- Made the prev/next link rel's properly navigate for comic posts

Updated: 05/26/2012 5:25pm Pacific
- Sidebar locations for the comic-area


== Upgrade Notice ==
= 1.0.16 =
You should go to settings -> permalinks and click save again.




