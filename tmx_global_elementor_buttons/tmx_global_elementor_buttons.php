<?php
/*
 Plugin Name: Global Elementor Buttons
 Plugin URI: https://github.com/sdegetaus/Global-Elementor-Buttons
 Description: Standarizes the Elementor buttons with global classes that can be managed in a single place with custom css.
 Version: 1.1.0
 Author: Santiago Degetau
 Author URI: https://github.com/sdegetaus
 License: GPL2
 text-domain: tmx-global-elementor-buttons
*/

/*
 Plugin Workflow
 1. Create the plugin's main class, which checks compatibility
	and registers the default stylesheet and the Elementor Widget.
 2. The TMX_Widget_Button class inherits from Elementor's Widget_Button
	class, and changes its functionality (and it is added as a new,
	different Elementor Widget for flexibility purposes).
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TMX_Global_Buttons {

	const PLUGIN_NAME = 'Global Elementor Buttons';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.0';

	public function __construct() {
		// load the localization text domain
		add_action( 'init', array( $this, 'i18n' ) );
		// then do the checks for compatibility which
		// if successful the plugin will get iterated
		add_action( 'plugins_loaded', array( $this, 'tmx_check_compatibility' ) );
	}
	
	public function i18n() {
		load_plugin_textdomain( 'tmx-global-elementor-buttons' );
	}
	
	public function tmx_check_compatibility() {
			
		// check if Elementor is active
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'tmx_admin_notice_missing_elementor' ) );
			return;
		}
			
		// check for Elementor's minimum version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'tmx_admin_notice_minimum_elementor_version' ) );
			return;
		}
			
		// check for minimum PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'tmx_admin_notice_minimum_php_version' ) );
			return;
		}
			
		// once all the checks were successfully passed,
		// lets enqueue the default stylesheet
		// and register the button widget
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'tmx_enqueue_default_stylesheet' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'tmx_register_button_widget' ] );
	}

	public function tmx_enqueue_default_stylesheet() {
		$should_enqueue = true; // the default value...
		$should_enqueue = apply_filters( "tmx_should_enqueue_default_stylesheet", $should_enqueue ); // which can be hooked in...
		// and changed so the stylesheet is never enqueued
		if( $should_enqueue ) wp_enqueue_style( 'tmx-buttons', ( plugin_dir_url( __FILE__ ) . 'buttons.min.css' ) );
	}

	public function tmx_register_button_widget() {
			// include the global button class ( Elementor > Widget_Button )
			require_once( __DIR__ . '/tmx_global_button.php' );
			// register the button widget
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TMX_Global_Button() );
	}
	
	#region ADMIN NOTICES

	public function tmx_admin_notice_missing_elementor() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '%1$s requires %2$s to be installed and activated.', 'tmx-global-elementor-buttons' ),
			'<strong>' . self::PLUGIN_NAME . '</strong>',
			'<strong>Elementor</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function tmx_admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '%1$s requires %2$s version %3$s or greater.', 'tmx-global-elementor-buttons' ),
			'<strong>' . self::PLUGIN_NAME . '</strong>',
			'<strong>Elementor</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	
	public function tmx_admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '%1$s requires %2$s version %3$s or greater.', 'tmx-global-elementor-buttons' ),
			'<strong>' . self::PLUGIN_NAME . '</strong>',
			'<strong>PHP</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	
	#endregion
}
// instantiate this class
new TMX_Global_Buttons();