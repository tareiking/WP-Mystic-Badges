<?php
/*
Plugin Name: Mystic Subscriber Badges
Version: 1.0.0
Description: Show your subscribers how much you love them by giving them a badge when they post comments
Author: Sennza
Author URI: http://sennza.com.au
Plugin URI: http://sennza.com.au
Text Domain: mystic-subscriber-badges
License: GPL3 or later
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function mystic_show_avatar_badge( $avatar, $id_or_email, $size ){

	if ( is_object( $id_or_email ) && property_exists( $id_or_email, 'comment_ID' ) ) {

		// Dummy data
		$user_subscription_level = array( 'bliss', 'flash', 'casual' );
		$user_subscription_level = $user_subscription_level[ rand( 0, sizeof( $user_subscription_level ) -1 ) ];
		// $user_subscription_level = mystic_badges_get_subscriber_level();

		$avatar = $avatar .  "<span class=\"mystic-badge mystic-badge-$user_subscription_level \"> $user_subscription_level </span>";
	}

	return $avatar;
}
add_filter( 'get_avatar', 'mystic_show_avatar_badge', 99, 3 );

function mystic_badges_init(){

	add_action( 'wp_enqueue_scripts', 'mystic_badges_enqueue_scripts' );
}
add_action( 'plugins_loaded', 'mystic_badges_init' );


function mystic_badges_enqueue_scripts(){

	wp_register_style( 'mystic-badges', plugin_dir_url( __FILE__ ) . '/css/mystic-badges.css' );
	wp_enqueue_style( 'mystic-badges' );

}

function mystic_badges_get_subscriber_level(){

	// Get subscriber level of commenter 
	// todo

}