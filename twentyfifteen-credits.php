<?php
/*
Plugin Name: Twenty Fifteen Credits
Description: Add a credit, e.g. a copyright notice, in the footer of Twenty Fifteen
Version: 0.1
Author: Bjørn Johansen
Author URI: https://bjornjohansen.no
License: GPL2

    Copyright 2014  Bjørn Johansen  (twitter : @bjornjohansen)

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


class BJ_Twentyfifteen_Credits {

    function __construct() {
        add_action( 'plugins_loaded', array( __CLASS__, 'load_textdomain' ), 10, 0 );
        add_action( 'init', array( __CLASS__, 'init' ), 10, 0 );
    }

    static function init() {
        if ( 'twentyfifteen' == get_template() ) {
            add_action( 'twentyfifteen_credits', array( __CLASS__, 'output' ), 10, 0 );
            add_action( 'customize_register', array( __CLASS__, 'customizer' ), 10, 1 );
        }
    }

    static function load_textdomain() {
        load_plugin_textdomain( 'twentyfifteen-credits', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    static function output() {
        $credits = trim( get_theme_mod( 'credits', '' ) );
        if ( strlen( $credits ) ) {
           printf( apply_filters( 'bj_twentyfifteen_credits', '<span class="twentyfifteen_credits">%s</span>' ), esc_html( $credits ) );
        }
    }

    static function customizer( $wp_customize ) {

        $wp_customize->add_section(
            'section_footer_credits',
            array(
                'title' => __( 'Footer Credits', 'twentyfifteen-credits' ),
                'priority' => 35,
            )
        );

        $wp_customize->add_setting(
            'credits',
            array(
                'default' => '',
            )
        );

        $wp_customize->add_control(
            'credits',
            array(
                'label' => __( 'Credits text', 'twentyfifteen-credits' ),
                'section' => 'section_footer_credits',
                'type' => 'text',
            )
        );
    }

}

new BJ_Twentyfifteen_Credits;

