<?php
/**
 * Plugin Name: Cap Web Solutions Display Support Widget 
 * Plugin URI: https://github.com/CapWebSolutions/DisplaySupportWidget
 * Description: This plugin displays the WPcare support widget on pages based on login status. 
 * Version: 1.0.1
 * Author: Matt Ryan [Cap Web Solutions]
 * Author URI: https://github.com/CapWebSolutions/DisplaySupportWidget
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Plugin Directory. Set constant so we know where we are installed.
$plugin_url = plugin_dir_url( __FILE__ );
/**
 * If user is logged in and on one of the My Account / Dashboard pages, or the Contact Us page,
 * show the Request Support Freshdesk widget.
 * If user is not logged on, and on the Contact Us page, show the widget also.
 * aka. Always show the Freshdesk "Request Support" widget on the Contact Us page.
 */
function capweb_display_freshdesk_support_widget () {
	$contact_pid = '1185';
    if ( capweb_is_tree( $contact_pid ) ) {
        /* Run javascript code to display widget w/o  pre-pops*/
		echo '<script type="text/javascript" src="https://s3.amazonaws.com/assets.freshdesk.com/widget/freshwidget.js"></script>';
		echo '<script type="text/javascript">';
		echo 'FreshWidget.init("", {"queryString": "&widgetType=popup&formTitle=Request+Help&submitThanks=Thanks+for+requesting+support+from+Cap+Web+Solutions.+&screenshot=no&searchArea=no",
		   "utf8": "✓", "widgetType": "popup", "buttonType": "text", "buttonText": "Request Help",
		    "buttonColor": "white", "buttonBg": "#546E91", "alignment": "2", "offset": "235px",
		     "submitThanks": "Thanks for requesting support online. ", "formHeight": "500px",
		      "screenshot": "no", "url": "https://capwebsolutions.freshdesk.com"} );';
		echo '</script>';
    } else {  /* Here not the Contact Page */
    	if ( is_user_logged_in() ) {
    		if ( is_page( 'my-account') ) {
    			$current_user = wp_get_current_user();
        /* Run javascript code to display widget with pre-populated email field */

				echo '<script type="text/javascript" src="https://s3.amazonaws.com/assets.freshdesk.com/widget/freshwidget.js"></script>';
				echo '<script type="text/javascript">';
				echo 'FreshWidget.init("", {"queryString": "&helpdesk_ticket[requester]=' . $current_user->user_email . '&widgetType=popup&formTitle=Request+Help&submitThanks=Thanks+for+requesting+support+from+Cap+Web+Solutions.+&screenshot=yes&searchArea=no",
				   "utf8": "✓", "widgetType": "popup", "buttonType": "text", "buttonText": "Request Help",
				    "buttonColor": "white", "buttonBg": "#546E91", "alignment": "2", "offset": "235px",
				     "submitThanks": "Thanks for requesting support online. ", "formHeight": "500px",
				      "screenshot": "no", "url": "https://capwebsolutions.freshdesk.com"} );';
				echo '</script>';

    		}
    	} else {
    		return;
    	}
    }
}
add_action( 'loop_start', 'capweb_display_freshdesk_support_widget' );
