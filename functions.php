<?php

function eyfe_pre_get_posts( &$query ) {
	if ( is_home() && $query->is_main_query() ) {
		// Images are first-class post citizens.
		$query->set( 'post_type', array( 'xpost', 'attachment' ) );
		$query->set( 'post_status', array( 'inherit', 'publish' ) );
		$query->set( 'posts_per_page', 30 );
	}
}
	
add_action( 'pre_get_posts', 'eyfe_pre_get_posts' );

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

function eyfe_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Eyfe, use a find and replace
	 * to change 'eyfe' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'eyfe', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'eyfe' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'image', 'video' ) );
}

add_action( 'after_setup_theme', 'eyfe_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function eyfe_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'eyfe' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'eyfe_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function eyfe_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
	
	wp_enqueue_script( 'layout', get_template_directory_uri() . '/js/layout.js', array( 'jquery' ), '20130321', true );
}
add_action( 'wp_enqueue_scripts', 'eyfe_scripts' );