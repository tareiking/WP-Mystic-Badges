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

		if ( $id_or_email->comment_parent != '0') {
			return $avatar;
		}

		$user_subscription_level = mystic_badges_get_subscription_level();
		$avatar = $avatar .  "<span class=\"mystic-badge mystic-badge-$user_subscription_level \"> $user_subscription_level </span>";
	}

	return $avatar;
}
add_filter( 'get_avatar', 'mystic_show_avatar_badge', 99, 3 );

function mystic_badge_show_inline( $return, $author, $comment_ID ){

	global $comment;

	if ( $comment->comment_parent != '0' ) {

		$user_subscription_level = mystic_badges_get_subscription_title( $comment_ID );
		$return = $return . " <span class=\"mystic-badge mystic-badge-inline mystic-badge-$user_subscription_level \">$user_subscription_level</span>";

	}

	return $return;
}
add_filter( 'get_comment_author_link', 'mystic_badge_show_inline', 99, 3 );

/**
 * TODO
 */
function mystic_badges_get_subscription_title( $comment_ID ){

	$comment = get_comment( $comment_ID );
	$author_id = $comment->user_id;

	if ( ! $subscription = WC_Subscriptions_Manager::get_users_subscriptions( $author_id ) ) {
		return;
	}

	$products = wp_list_pluck( $subscription, 'product_id' );

	foreach ($products as $sub_id => $product) {
		$product_id = $product;
	}

	$subscription_title = strtolower( get_the_title( $product_id ) );

	if ( strstr( $subscription_title, 'bliss' ) ){
		return 'Bliss';
	} else if ( strstr( $subscription_title, 'mega' ) ){
		return 'Mega';
	} else {
		return 'no subscription';
	}

}

function mystic_badges_init(){

	add_action( 'wp_enqueue_scripts', 'mystic_badges_enqueue_scripts' );
}
add_action( 'plugins_loaded', 'mystic_badges_init' );


function mystic_badges_enqueue_scripts(){

	wp_register_style( 'mystic-badges', plugin_dir_url( __FILE__ ) . '/css/mystic-badges.css' );
	wp_enqueue_style( 'mystic-badges' );

}
