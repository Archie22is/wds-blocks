<?php
/**
 * Helper functions for rendering dynamic blocks.
 *
 * @package WDS_Gutenberg
 * @since NEXT
 */

namespace WDS_Gutenberg\Src\Block_Options;

function display_block_options( $attributes ) {

	// Setup defaults.
	$defaults = array(
		'backgroundType'  => $attributes['backgroundType'],
		'textColor'       => $attributes['textColor'],
		'container'       => 'section',
		'class'           => 'content-block',
		'className'       => $attributes['className'],
	);

	// Parse args.
	$attributes = wp_parse_args( $attributes, $defaults );

	$inline_style = '';

	$background_video_markup = '';

	// Only try to get the rest of the settings if the background type is set to anything.
	if ( $attributes['backgroundType'] ) {
		if ( 'color' === $attributes['backgroundType'] ) {
			$background_color = $attributes['backgroundColor'];
			$inline_style .= 'background-color: ' . $background_color . '; ';
		}

		if ( 'image' === $attributes['backgroundType'] ) {
			$background_image = $attributes['backgroundImage'];
			$inline_style .= 'background-image: url(' . esc_url( $background_image['sizes']['full-width'] ) . ');';
			$attributes['class'] .= ' image-as-background';
		}

		if ( 'video' === $attributes['backgroundType'] ) {
			$background_video = $attributes['backgroundVideo'];
			$background_video_markup = '<video class="video-as-background" autoplay muted loop preload="auto"><source src="' . esc_url( $background_video['url'] ) . '" type="video/mp4"></video>';
		}
	}

	if ( ! $attributes['backgroundType'] ) {
		$attributes['class'] .= ' no-background';
	}

	// Set the custom font color.
	if ( $attributes['textColor'] ) {
		$inline_style .= 'color: ' . $attributes['textColor'] . '; ';
	}

	// Set the custom css class.
	if ( $attributes['className'] ) {
		$attributes['class'] .= ' ' . $attributes['className'];
	}

	// Print our block container with options.
	printf( '<%s class="%s" style="%s">', esc_html( $attributes['container'] ), esc_attr( $attributes['class'] ), esc_attr( $inline_style ) );

	// If we have a background video, echo our background video markup inside the block container.
	if ( $background_video_markup ) {
		echo $background_video_markup; // WPCS XSS OK.
	}

	echo '<xmp>: '. print_r( $attributes, true ) .'</xmp>';

	echo $inline_style;
}
