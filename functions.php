<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package DentalFunnelThePlatformChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define child theme version - matching style.css version
define( 'DFP_THEME_CHILD_VERSION', '1.0.1' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function dfp_theme_child_scripts_styles() {
	// Enqueue child theme stylesheet with parent theme as dependency
	wp_enqueue_style(
		'dental-funnel-platform-style', // Custom handle for child theme
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style', // REQUIRED: Parent theme handle - DO NOT CHANGE
		],
		DFP_THEME_CHILD_VERSION
	);
	
	// Optional: Add custom JavaScript if needed
	// wp_enqueue_script(
	//     'dental-funnel-platform-script',
	//     get_stylesheet_directory_uri() . '/js/custom.js',
	//     array( 'jquery' ),
	//     DFP_THEME_CHILD_VERSION,
	//     true
	// );
}
add_action( 'wp_enqueue_scripts', 'dfp_theme_child_scripts_styles', 20 );


// *********** DFP CUSTOMIZATION ************************

/**
 * Function to allow iFrames in Option Pages for NPG etc.
 *
 * @return array Modified tags array
 */
add_filter( 'wp_kses_allowed_html', function ( $tags, $context ) {
	if ( 'post' === $context ) {
		
		$tags['iframe'] = array(
			'src' => true,
			'title'	=> true,
			'id' => true,	
			'width' => true,
			'height' => true,
			'scrolling' => true,
			'style'	=> true, 
			'frameborder' => true,
			'allowtransparency' => true,
			'allow' => true,
		);
		
		$tags['script'] = array(
			'src' => true,
		);
	}
	
	return $tags;
}, 10, 2 );


/**
 * Simple Reading Time Shortcode [reading_time]
 *
 * @return int Reading time in minutes
 */
function dfp_reading_time_shortcode() {
	// Get current post content
	$content = get_post_field( 'post_content', get_the_ID() );
	
	// Strip tags and get word count
	$word_count = str_word_count( strip_tags( strip_shortcodes( $content ) ) );
	
	// Calculate reading time (200 words per minute)
	$reading_time = ceil( $word_count / 200 );
	
	// Return just the number
	return $reading_time;
}
// Register the shortcode
add_shortcode( 'reading_time', 'dfp_reading_time_shortcode' );
