<?php
/**
 * Plugin Name: Better Datelines
 * Description: Use meta field to store dateline so that they don't get included
 * Version:     0.1
 * Author:      Doejo
 * Author URI:  http://doejo.com
 * License:     GPLv2 or later
 */

/**
 * Most of the code was stolen from "Hidden Posts" plugin by Automattic
 *
 */
class Better_Datelines {

    const META_KEY = 'better-dateline';
    const NONCE_KEY = 'better-dateline-nonce';

    function __construct() {
        add_action( 'post_submitbox_misc_actions', array( $this, 'dateline_text' ) );
        add_action( 'save_post', array( $this, 'save_meta' ) );
        add_filter( 'the_content', array( $this, 'prepend_the_content_with_dateline' ) );
    }

    /**
     * Show the checkbox in the admin
     */
    function dateline_text() {
        global $post;
        $dateline = get_post_meta( $post->ID, self::META_KEY, true );
        wp_nonce_field( self::NONCE_KEY, self::NONCE_KEY );
        printf( '<div id="better-dateline-box" class="misc-pub-section"><label><b>Dateline</b></label><br/><textarea name="%s">%s</textarea></div>', self::META_KEY, esc_html( $dateline ) );
    }

    /**
     * Update the post meta
     */
    function save_meta( $post ) {
        // Verify the nonce
        if ( ! isset( $_POST[ self::NONCE_KEY ] ) || ! wp_verify_nonce( $_POST[ self::NONCE_KEY ], self::NONCE_KEY ) )
            return;

        // Update the post array if necessary
        if ( isset( $_POST[ self::META_KEY ] ) ) {

            update_post_meta( $post, self::META_KEY, sanitize_text_field( $_POST[ self::META_KEY] ) );
        }
    }

    /**
     * Filter for the_content
     * @param  [type] $content [description]
     * @return [type]          [description]
     */
    function prepend_the_content_with_dateline( $content ) {
        // By default content is not prepended with dateline unless you explicitly set better_datelines_prepend_the_content filter to return true
        if ( false === apply_filters( 'better_datelines_prepend_the_content', false ) )
            return $content;

        // Bail if there's no dateline
        $dateline = get_post_meta( get_the_id(), self::META_KEY, true );
        if ( ! $dateline )
            return $content;
        // Default format
        $formatted_content = sprintf( "%s &mdash; %s", esc_html( $dateline ), $content );

        // Filter: better_datelines_formatted_content( $formatted_content, $dateline, $original_content )
        return apply_filters( 'better_datelines_formatted_content', $formatted_content, $dateline, $content );
    }
}

new Better_Datelines;