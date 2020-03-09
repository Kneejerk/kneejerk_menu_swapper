=== Kneejer Menu Swapper ===
Contributors: RedEarRyan (Ryan "Rohjay" Oeltjenbruns)
Donate link: coming soon?
Tags: Menus, Navigation, Logged in
Requires at least: 5.0
Tested up to: 5.3
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Contextually swaps menus in your theme for logged in users.

== Description ==

### What is KJD Menu Swapper

This Plugin designed to allow you to contextualize the menus in your theme based on
whether or not your visitor is logged in or not. It's especially handy when this functionality is
not built into your theme!

Please report any bugs or feel free to give me any feedback at
[https://kneejerk.dev/](https://kneejerk.dev/) via the contact form at the bottom.

### How does it work

After installing KJD Menu Swapper, you'll see the Menu Swapper on the left admin navigation (at this
point, you're probably already familiar with it). Once you click there, you'll be presented with the
configuration for the plugin. This plugin does a few things to work:

1.  KJD grabs the menus that your theme has registered. Whatever your theme, if it registers its menus
    properly, KJD Menu Swapper will find it =]

2.  KJD then grabs the menus that you've configured under Appearance -> Menus

3.  If a menu is configured for a registered theme menu, KJD Menu Swapper will show you. Otherwise,
    it'll say "None Selected" like this:
    ![Example](/assets/twenty_twenty_example.png)

4.  In the dropdown next to what the theme is configured for, you have the option to "swap" it when the
    visitor is logged in:\
    ![Menu Select](/assets/twenty_twenty_menu_select.png)

5.  Click the enable checkbox for that menu to enable the swap:\
    ![Enable Swap](/assets/twenty_twenty_configure_enable.png)

6.  Next, bonk the "Save" button, and the menu swap is live!\
    ![Bonk save](/assets/twenty_twenty_save.png)

== Installation ==

1. Upload the `kneejerk_menu_swapper` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin through the wp-admin area from the "Menu Swapper" navigation link on the left

== Frequently Asked Questions ==

= Why should I used this plugin? =

The best examples of how to use this plugin are where you have a navigation menu with login/logout functionality, or
perhaps you'd like to add items to your navigation menus for when someone is logged in. In these scenarios, figure out
which location the menu title is describing, create another menu in the wp-admin's Appearance -> Menus similar to it
(with the additions and/or changes), and use that menu for the swap.

= How do I create new menus to swap to? =

All of the menus the KJD Menu Swapper knows about are created in the wp-admin area's Appearance -> Menus. Once you've
created a menu there, set it as the menu for different registered menu locations in your theme as usual. Once that's
done, the KJD Menu Swapper can allow you to swap that menu to a separate one designed for users that are logged in.

= Why does it say "No registered menus found for the current theme"? =

This is because your active theme doesn't have any registered nav menus. In this scenario, the KJD Menu Swapper plugin
isn't going to be able to swap any of your menus when someone is logged in.

= Why isn't KJD Menu Swapper disabling my nav menu when none is selected and it's enabled? =

KJD Menu Swapper isn't built to disable menus by design. If this is a feature that KJD Menu Swapper ***should*** work
for, I'd love to hear that feedback. As it sits, I've made the conscience decision (perhaps in error) to not honor
those swaps.

== Screenshots ==

1. This is an example of what the plugin's config might look like for an install using the Twentytwenty Theme (after
bonking save)
2. This shows you where it gets the list of menus you can use. Create, set them to locations in your theme, then come
back to the KJD Menu Swapper page to configure which ones you'd like to swap to!

== Changelog ==

= 1.0.0 =
Initial Version (first round of WP Plugin Repo code review)

== Arbitrary section ==

### A Note from the Author

It's designed to be pretty easy to use, but this plugin will only get better with constructive feedback
from people who are using it like you!

More great plugins to come, so keep in touch, and stay tuned to Kneejerk Development!

Sincerely,\
Ryan "Rohjay" Oeltjenbruns\