<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package   Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version   1.1 21st August 2019
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function nightingale_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	$classes[] = nightingale_get_header_style();

	return $classes;
}

add_filter( 'body_class', 'nightingale_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function nightingale_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'nightingale_pingback_header' );

if ( ! function_exists( 'nightingale_get_header_style' ) ) {
	/**
	 * Figure whether we are using standard blue header with white text, or an inverse header which is white with blue / grey text.
	 *
	 * @return string $default_position.
	 */
	function nightingale_get_header_style() {

		$themeoptions_header_style = get_theme_mod( 'theme-header-style', 'default' );

		if ( 'default' === $themeoptions_header_style ) {
			$default_position = 'page-header-default';
		} elseif ( 'centered' === $themeoptions_header_style ) {
			$default_position = 'page-header-white';
		}

		return $default_position;
	}
}

/*
 * Add excerpt ability to posts so the excerpt can be used in search results.
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Shortens the excerpt to 20 char
 *
 * @param int $length length to shorten content to.
 */
function nightingale_shorten_excerpt( $length ) {
	if ( is_admin() ) {
		return $length;
	}

	return 20;
}

add_filter( 'excerpt_length', 'nightingale_shorten_excerpt', 10 );

/**
 * Adds the readmore link to excerpts
 *
 * @param string $more the default more string.
 */
function nightingale_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	global $post;
	$link  = '';
	$title = get_the_title( $post->ID );

	return nightingale_read_more_posts( $title, $link );
}

add_filter( 'excerpt_more', 'nightingale_excerpt_more' );
/**
 * Customise the read more link.
 *
 * @param string $title The title for the link (used in visually hidden area for screen readers to better describe the link).
 * @param string $link  The href of the resource being linked to.
 *                      return string output html.
 */
function nightingale_read_more_posts( $title, $link ) {

	$readmorelink = '<div class="nhsuk-action-link nhsuk-readmore">';
	if ( '' !== $link ) {
		$readmorelink .= '<a class="nhsuk-action-link__link" href="' . $link . '">';
	}
	$readmorelink .= '<span class="nhsuk-action-link__text">' . esc_html__( 'read more ', 'nightingale' ) . '</span><span class="nhsuk-u-visually-hidden">' . esc_html__( ' about ', 'nightingale' ) . $title . '</span><svg class="nhsuk-icon nhsuk-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
	  <path d="M0 0h24v24H0z" fill="none"></path>
	  <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
	</svg>';
	if ( '' !== $link ) {
		$readmorelink .= '</a>';
	}
	$readmorelink .= '</div>';

	return $readmorelink;

}

/**
 * Whether show sidebar returns true or false
 */
function nightingale_show_sidebar() {
	return ( 'true' === get_theme_mod( 'blog_sidebar' ) );
}

/**
 * Determine if page should have sidebar on left or right, and return additional class if required.
 *
 * @param string $sidebar location string for sidebar.
 */
function nightingale_sidebar_location( $sidebar ) {
	$sidebar_location = get_theme_mod( 'sidebar_location', 'right' );
	$sidefloat        = 'contentleft';
	if ( 'right' !== $sidebar_location ) {
		if ( is_active_sidebar( $sidebar ) ) {
			$sidefloat = ' contentright';
		}
	}

	return $sidefloat;
}

/**
 * Get the custom colour name to return into the body class if required
 *
 * @param array $classes the pre-existing classes for a WordPress page.
 */
function nightingale_custom_page_colour( $classes ) {

    $colour_array      = array(
        '005eb8' => 'blue',
        '0c223f' => 'dark-blue',
        '336c83' => 'teal',
        '00a19a' => 'light-teal',
    );

	$colour = get_theme_mod( 'theme_colour', 'blue' );

	if ( !empty($colour) ) {
		$theme_colour_name = 'page-colour--' . $colour_array[ $colour ];
		$classes[]         = $theme_colour_name;
	}

    //Add page header colour class
    $page_header_colour = get_theme_mod( 'page_header_colour', '' );

    if(!empty($page_header_colour)){
        $page_header_colour_name = 'page-header-color--' . $colour_array[ $page_header_colour ];
        $classes[] = $page_header_colour_name;
    }


    return $classes;
}

add_filter( 'body_class', 'nightingale_custom_page_colour' );


function nightingale_custom_typography( $classes ) {
    $font = get_theme_mod( 'primary_font', 'frutiger' );
    if ( !empty($font) ) {
        $font_class = 'primary-font--'. $font;
        $classes[]         = $font_class;
    }

    return $classes;
}

add_filter( 'body_class', 'nightingale_custom_typography' );

function nightingale_admin_custom_typography( $classes ) {

    global $pagenow;

    if ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow ) {
        return;
    }

    $font = get_theme_mod( 'primary_font', 'frutiger' );
    if ( !empty($font) ) {
        $font_class = 'primary-font-admin--' . $font;

        $classes = "$classes $font_class";
    }

    return $classes;

}

add_filter( 'admin_body_class', 'nightingale_admin_custom_typography', 10, 1);
/**
 * Function to sanitise content and remove empty elements that cause a11y and w3c validation errors.
 *
 * @param bool $b_print Boolean argument specifying whether or not to print the function output.
 *
 * @return mixed|string|string[]|void|null Return the sanitised output, or original output if flag set to false.
 */
function nightingale_clean_bad_content( $b_print = false ) {

	global $post;
	$nightingale_post_content  = $post->post_content;
	$nightingale_remove_filter = array( '~<p[^>]*>\s?</p>~', '~<a[^>]*>\s?</a>~', '~<h[^>]*>\s?</h[^>]>~', '~<font[^>]*>~', '~<\/font>~' );
	$nightingale_post_content  = preg_replace( $nightingale_remove_filter, '', $nightingale_post_content );
	$nightingale_post_content  = apply_filters( 'the_content', $nightingale_post_content );
	if ( false === $b_print ) {
		return $nightingale_post_content;
	} else {
		echo $nightingale_post_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
