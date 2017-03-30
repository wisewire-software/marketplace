=== Cronjob Scheduler ===
Contributors: chrispage1
Tags: task,scheduler,automation,cron,cronjob
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RDJGUTGNX83VG
Requires at least: 3.5.1
Tested up to: 4.0
Stable tag: trunk
Plugin URI: http://wordpress.org/plugins/cronjob-scheduler/
License: GNU v3
License URI: http://www.gnu.org/licenses/gpl.html

Cronjob Scheduler allows you to automate regular tasks and actions within your WordPress installation!

== Description ==
= Cronjob Scheduler =
Cronjob Scheduler allows you to create custom WordPress tasks that are automatically triggered on a schedule you define. The motivation behind building this plugin was out of frustration with other similar plugins that claim to do the same thing.

Cronjob Scheduler allows you to run frequent tasks reliably and timely without anyone having to visit your site, all you need is at least 1 action and a Unix Crontab schedule!

= About =

This plugin was designed and built by Motocom. It is designed to make easy work of creating and managing custom cron jobs. If this plugin has been helpful for you, then please donate to keep our WordPress plugin projects running!

== Installation ==
1. Upload `cronjob-scheduler` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. You will now be able to manage your Cronjob schedule under `Settings > Cronjob Scheduler`
4. Once on this page, follow the plugins instructions to ensure everything is setup and ready to go
5. Instructions, and a template for creating new actions can be found in the plugin admin.

= Running your cron tasks =

Most shared providers offer a crontab manager, or you can speak to your shared hosting provider about setting up our cron job. If you manage the server, you can setup your cron using the crontab service. Make sure that wget is installed befor doing this.

= Creating Custom Action Example =

`function my_cronjob_action () {
    // code to execute on cron run
} add_action('my_cronjob_action', 'my_cronjob_action');`

== Frequently Asked Questions ==
= Can I create my own custom schedules? =

That's the whole idea of the plugin, you setup your schedules and the tasks you want to run and the plugin will handle the rest!

= How do I create a task to run? =

Just create a new function in your theme files (or somewhere else you will remember) and create an action with the same name.

= Can I run an event at any time? =

Sure, just go to the Cronjob Scheduler interface and hit the `Run` button against the task.

== Screenshots ==
1. Cronjob Scheduler Interface
2. Creating new schedules is easy
3. The process of creating a new scheduled task

== Changelog ==

= 1.0.8 =
Minor bug fix to stop tasks that do not recur from being a problem

= 1.0.7 =
Changed the conditions under which post events are handled to prevent interference with any other elements of the WordPress admin.

= 1.0.6 =
Added facility to edit cronjobs.php file which allows you to create and manage cronjobs
actions all from within the WordPress admin.

= 1.0.5 =
Created function to get crontab structure and modified it to a more reliable wget method

= 1.0.4 =
Updated plugin folder structure

= 1.0.1 - 1.0.3 =
Minor changes to readme files & author URL

= 1.0 =
Plugin creation, extensive testing and deployment to a number of our live environments.