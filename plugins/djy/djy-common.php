<?php
/**
 * @package DJY
 * @version 1.6
 */
/*
Plugin Name: DJY Common
Plugin URI: http://epochtimes.com
Description: This is a plugin.
Author: Ken
Version: 1.0
Author URI: http://epochtimes.com
*/

add_action( 'pre_get_posts', 'djy_pre_get_posts' );
if( !function_exists( 'djy_pre_get_posts' ) ) {
    function djy_pre_get_posts ($query) {
        //if ( $query->is_main_query() ) {
        /*var_dump( $GLOBALS['wp_query']->request );*/
//			var_dump($query);
        if($query->get('posts_per_page') == -1) {
            $query->set( 'posts_per_archive_page', 100 );
        }

        if($query->get('posts_per_archive_page') == -1) {
            $query->set( 'posts_per_archive_page', 100 );
        }
        //}
    }
}