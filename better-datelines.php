<?php
/**
 * Plugin Name: Better Datelines
 * Description: Use meta field to store dateline so that datelines aren't included in autoexcerpts and the_content as well
 * Version:     0.1
 * Author:      Doejo
 * Author URI:  http://doejo.com
 * License:     GPLv2 or later
 */

/**
 * Some of the code was stolen from "Hidden Posts" plugin by Automattic:
 *
 * @see https://github.com/Automattic/hidden-posts
 *
 */
class Better_Datelines {

    const META_KEY = 'better-dateline';
    const NONCE_KEY = 'better-dateline-nonce';
    const PER_POST_SETTING_KEY = 'better-dateline-hide';

    public $should_auto_prepend;

    function __construct() {
        add_action( 'init', array( $this, 'action_init' ) );
    }


    function action_init() {
        // Whether autoprepend the content
        $this->should_auto_prepend = apply_filters( 'better_datelines_prepend_the_content', false );
        add_action( 'post_submitbox_misc_actions', array( $this, 'dateline_text' ) );
        add_action( 'save_post', array( $this, 'save_meta' ) );
        add_filter( 'the_content', array( $this, 'prepend_the_content_with_dateline' ) );
        add_shortcode('better-dateline', array( $this, 'shortcode_callback' ) );
    }

    /**
     * Show the checkbox in the admin
     */
    function dateline_text() {
        global $post;
        $dateline = get_post_meta( $post->ID, self::META_KEY, true );
        wp_nonce_field( self::NONCE_KEY, self::NONCE_KEY );
        printf( '<div id="better-dateline-box" class="misc-pub-section"><label><b>Dateline</b></label><br/><textarea name="%s" style="width: 100%%">%s</textarea></div>', self::META_KEY, esc_html( $dateline ) );

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
        if ( false === $this->should_auto_prepend )
            return $content;

        // Bail if there's no dateline
        $dateline = trim( get_post_meta( get_the_id(), self::META_KEY, true ) );

        if ( ! $dateline )
            return $content;

        // Account for wpautop filter, ensuring that the dateline is in the same paragraph as the actual content
        $autop = preg_replace( '/^\<p\>/i', "<p>" . sprintf( "%s &mdash; ", esc_html( $dateline ) ), $content );

        // Filter: better_datelines_formatted_content( $formatted_content, $dateline, $original_content )
        return apply_filters( 'better_datelines_formatted_content', $autop, $dateline, $content );
    }

    /**
     * Basic shortcode callback [better-dateline]
     * @param  array  $atts [description]
     * @return [type]       [description]
     */
    function shortcode_callback( $atts = array() ) {
        $atts = shortcode_atts( array(
            'before' => '',
            'after' => ' &mdash; ',
        ), $atts );
        $dateline = get_post_meta( get_the_id(), self::META_KEY, true );
        if ( $dateline )
            return sprintf( "%s %s %s", esc_html( $atts['before'] ), esc_html( $dateline ), esc_html( $atts['after'] ) );
    }
}

new Better_Datelines;