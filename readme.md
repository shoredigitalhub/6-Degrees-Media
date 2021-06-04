#Light AXe

**Contributors:** axenaqvi

**Theme URI:** [https://bitbucket.org/AXeNaqvi/light-axe-wp/](https://bitbucket.org/AXeNaqvi/light-axe-wp/)

**Author:** AZ Naqvi

**Author URI:** [https://bitbucket.org/AXeNaqvi/](https://bitbucket.org/AXeNaqvi/)

**Version:** 1.1.6

**Stable tag:** 1.1.6

**Requires at least:** Wordpress 4.7

**Tested up to:** Wordpress 5.0.2

**Text Domain:** light-axe

**License:** GNU General Public License v2.0 and above

**License URI:** http://www.gnu.org/licenses/gpl-2.0.html

**Description:** Light weight, ultra fast theme that can be used as base theme for custom child themes.

**Tags:** theme-options, two-columns, left-sidebar, right-sidebar,custom-menu,full-width-template,custom-header,flexible-header,custom-logo,featured-image-header,featured-images,footer-widgets,sticky-post,threaded-comments,translation-ready

**Subject Tags:** blog

##Description

This is a light weight theme to be used as parent theme. Major styling and template setups are to be done in child themes. This is just a bare bones framework for that.

##Changelog:
---
###Ver 1.1.6
1. Added a trigger in axeCarousel after carousel setup.
2. Fixed width change issue with screen resize in axeCarousel horizontal mode.
3. Fixed getimagesize warning.
---

###Ver 1.1.5
1. Fixed WP Themes compabiltity issues.
2. Fixed css minor issues.
3. Upgraded fontawesome to ver 5.x.x
4. Changed changelog.txt to readme.txt
5. Ready for first submission to WP Themes repository
---

---
###Ver 1.1.4
1. Added function to get logo and added filter for logo.
2. Added support for gFonts with fallback font family.
3. Fixed CSS for logo's line-height.
4. Updated template for WooCommerce.
5. Added Embed Map option to bypass API key issues with GMaps.
6. Updated GMap Widget to include the iFrame embed option.
7. Fixed search page irrelevant data showing up.
---

---
###Ver 1.1.3
1. Added support for transparent blocks.
2. Added title and made minor edit to axebutton shortcode.
3. Added wpautop to page template.
4. Added support to add custom sidebars to pages.
---

---
###Ver 1.1.2
1. Fixed custom fonts folder read issue.
2. Updated #mainmenu css to .axemainmenu css.
---

---
###Ver 1.1.1
1. Added separator block.
2. Added filter to manipulate main menu.
3. Fixed Adbox widget's issue with new window opening.
4. CSS updates in main theme.
---

---
###Ver 1.1.0
1. Fixed minor PHP issues.
2. Added basefooterinner div.
3. Updated 404 page.
4. Added support in admin to add more types of after content blocks.
5. Added some basic helper functions.
6. Added filters to current admin after content fields blocks updated the way the sections were created.
7. Added subtitle field to after content meta box.
8. Added support to enable/disable after content blocks.
9. Added new after content blocks, rich text, text, clear block, section start, section end.
10. Updated axeCarousel basic css.
11. Major changes in after content section.
---

---
###Ver 1.0.29
1. After after content div not closing properly issue.
2. Added action 'above_main_content' in header.php.
3. Added action in after content metabox for additional fields.
4. Added support to use simple text in social media links. Simply remove the icon path.
5. Added item class to social media link.
6. Updated class for 'before_axe_get_footer' hook container.
7. Added a basefooter div around all footer divs.
8. Added a maincontentinner wrapper with two new actions.
9. Added restrictions on theme settings add / update.
10. Added support for autopara enable/disable in after content sections.
---

---
###Ver 1.0.28
1. Removed some unneeded css from main theme.
2. Fixed wpauto issue for adbox filters, added a function to manage the process.
3. Added class to sidebox caller.
4. Added a trigger after carouosel items are moved.
---

---
###Ver 1.0.27
1. Fixed axecarousel's rotation glitch.
2.
---

---
###Ver 1.0.26
1. Fixed and smoothen carousel play/pause animation.
2.
---

---
###Ver 1.0.25
1. Added partial support for play/pause button on sliders.
2. Added support for SVG files.
---

---
###Ver 1.0.24
1. Added short code for any content blocks to scroll. Uses axeSlider.
2. Added button shortcode.
3. Removed shadow from form input fields.
4. Fixed carousel multiple firing.
5. Added data field support to scrolleritem shortcode.
6. Added rel field support to scrolleritem shortcode.
7. Changed childclass field to class field in scrolleritem shortcode.
8. Changed how AdBox Ids are being created.
9. Added sub heading to AXe Ad Box.
10. Added support to show loader in axeCarousel on direction switch using the buttons.
11. Fixed minor issues in functions.php and sociallinks shortcode.
---

---
###Ver 1.0.23
1. Fixed home page divs.
2.
---

---
###Ver 1.0.22
1. Removed unnecessary css from parent theme.
2. Added banner support on Blog Page.
3. Changed how blog page title is fetched.
4. Added a banner filter.
5. Added support to skip slider option in post sliders.
6. Updated after content sections Within wrapper option.
7. Updated title for admin side of after content blocks where title is not present, id will be shown.
8. Added filters to add extra fields to after content admin blocks.
9. Added support to add font sizes for tablets and mobile devices in Typography section.
10. Applied some translation ready options.
---

---
###Ver 1.0.21
1. Changed featured image layout. Rather than BG it is now used as an img.
2. Added Theme settings sub-items in Admin menu tab.
3. Fixed reloading on tab clicks in theme settings.
4. Added GoUp to main theme.
5. Renamed slider Js to axeTheme and added additional front related js along with sliders.
---

---
###Ver 1.0.20
1. Added id support to axebox shortcodes.
2. Added support to auto adjust height of carousels on move.
3. Added support to use fonts in social shortcodes.
---

---
###Ver 1.0.19
1. Updated vcard widget added new filters.
2. Updated vcard shortcode added new filters.
3. Updated default theme css.
4. Added default values o###Verride option in vcard widget.
---

---
###Ver 1.0.18
1. Added shortcode for sociallinks.
2. Updated social links widget to use the shortcode.
---

---
###Ver 1.0.17
1. Updated vCard Widget and Shortcode. Added support for sorting and selected items for displaying. Values can be changed at individual widget level. Helpful for customers with multiple business addresses.
2. Updated GMap widget. Added support to update address at individual widget level. Defaults to contact address set under Settings.
3. Updated After Content section. Added support for placing either the container or content within wrapper.
4. Added support for flex blocks. New container class "axeflex" is introduced, inner items must use class "w" and any from "w1-w12" classes.
5. Added flex class to templates.
6. Updated admin settings page. Allowing current tab to be active after update.
7. Changed the way settings tabs are created. Allowing filters to modify the blocks and its navigation.
8. Settings can be manipulated at init and before update time using new filters.
9. Added support to get RGB values from HEX colors, useful for creating themed transparent overlays.
10. Added classes to login logout shortcode.
11. Added Office Hours to Contact Settings.
12. Added confirmation at deleting after content sections and settings addable rows.
13. Added support to adjust After Content BG Styling and Position.
---

---
###Ver 1.0.16
1. Added color init support at time of after content block creation.
2.
---

---
###Ver 1.0.15
1. Fixed minor issues.
2. Added Support for Blog Page Image.
3. Updated AdBox with adbox image wrapper.
4. Added support for address line 2 under Contact Settings tab.
5. Updated single post page. Added actions to template.
6. Added direction to carousel.
---

---
###Ver 1.0.14
1. Fixed minor issues.
2. Fixed templates layouts.
3. Added background support for after content sections.
4. Added id support for after content sections.
5. Added shortcode column in sidebar settings.
6. Updated AXe Adbox widget. Changed excerpt to multiline.
7. Added Support for Blog Page Image.
---

---
###Ver 1.0.13
1. Fixed minor issues.
2. Updated after content sections to be more easy to migrate.
3. Updated left and right sidebar templates to add after content sections.
4. Added custom classes support for pages and posts.
5. Added custom classes support for ad box widgets.
6. Disabled AXe Slides.
7. Added wpad, wpadfirst and wpadlast for container classes in css.
---

---
###Ver 1.0.12
1. Fixed minor issues.
2. Added filters for vacrd labels and values. vcard_label_filter, vcard_value_filter
3. Added hook axe_before_footer_bottom in footer.php
4. Removed clear divs
5. Added default classes to box shortcodes.
6. Added main title action with subactions and filters.
7. Changed after page content heading from h3 to h2.
8. Fixed AXeSlider.js issues.
9. Added items to show field in Slider Widgets.
10. Banner will not be shown on Blog, Archives, Categories and Taxonomies by default.
---

---
###Ver 1.0.11
1. Fixed minor issues.
2. Added fontawesome support for social media icons.
3. Added same favicon to login screen and admin panel.
4. Added filters to banner section and featured image.
5. Added class support in sidebox shortcode.
6. Updated multilingual support.
---

---
###Ver 1.0.10
1. Updated carousel code. Added items to show option.
2.
---

---
###Ver 1.0.9
1. Updated css
2.
---

---
###Ver 1.0.8
1. Fixed minor issues.
2. Added sidebar.php
3. Fixed some css.
---

---
###Ver 1.0.7
1. Fixed minor issues.
2. Improved after content section.
3. Updated axeSlider.js
4. Fixed meta and featured image warnings on certain templates.
---

---
###Ver 1.0.6
1. Updated SEO tags on pages and posts.
2. Minified default theme css.
3. Updated axeSlider.js
4. Added after content extra sections. Helpful in dynamic layouts.
---

---
###Ver 1.0.5
1. Added SEO tags on pages and posts.
2. Added page level banner section.
3. Added youtube, vimeo and dailymotion video embed codes.
4. Added 5 different blog styles.
---

---
###Ver 1.0.4
1. Added primary and secondary colors.
2. Added wrapper style and width control from admin panel.
3. Updated theme with hooks.
4. Added featured image width option.
5. Added predefined templates for ads and page/post carousels.
---

---
###Ver 1.0.3
1. Fixed blog navigation.
2. Updated base stylesheet.
3. Shuffled shortcodes in files.
4. Added template themes and related filters for carousel.
---

---
###Ver 1.0.2
1. Added import/export settings feature.
2. Added Page Carousel Widget.
3. Added Prefooter section. Add as many from the custom fields in the pages.
4. A caller added for left and right sidebars. Adds widgets per page basis. Works with respective sidebar page template.
---

---
###Ver 1.0.1
1. First ever version of axetheme.
2.
---