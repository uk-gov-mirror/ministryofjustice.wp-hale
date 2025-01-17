<?php
/**
 * Hale Theme Customizer
 *
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0 Oct 2020
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nightingale_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'nightingale_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'nightingale_customize_partial_blogdescription',
			)
		);
	}

	/*
	 * ------------------------------------------------------------
	 * SECTION: Header
	 * ------------------------------------------------------------
	 */
	$wp_customize->add_section(
		'section_header',
		array(
			'title'       => esc_html__( 'Header', 'nightingale' ),
			'description' => esc_attr__( 'Customise your header display', 'nightingale' ),
			'priority'    => 10,
		)
	);

	/*
	 * -----------------------------------------------------------
	 * SHOW / HIDE Search
	 * -----------------------------------------------------------
	 */
	$wp_customize->add_setting(
		'show_search',
		array(
			'default'           => 'yes',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'show_search',
		array(
			'label'       => esc_html__( 'Show Search Box?', 'nightingale' ),
			'description' => esc_html__( 'Would you like to show a search box in the top right of your site?', 'nightingale' ),
			'section'     => 'section_header',
			'type'        => 'radio',
			'choices'     => array(
				'yes' => esc_html__( 'Yes', 'nightingale' ),
				'no'  => esc_html__( 'No', 'nightingale' ),
			),
		)
	);

    /*
   * -----------------------------------------------------------
   * SHOW / HIDE Main Menu
   * -----------------------------------------------------------
   */
    $wp_customize->add_setting(
        'show_header_menu',
        array(
            'default'           => 'yes',
            'sanitize_callback' => 'nightingale_sanitize_select',
        )
    );
    $wp_customize->add_control(
        'show_header_menu',
        array(
            'label'       => esc_html__( 'Show Menu?', 'nightingale' ),
            'description' => esc_html__( 'Would you like to show the main menu in the header?', 'nightingale' ),
            'section'     => 'section_header',
            'type'        => 'radio',
            'choices'     => array(
                'yes' => esc_html__( 'Yes', 'nightingale' ),
                'no'  => esc_html__( 'No', 'nightingale' ),
            ),
        )
    );

    /*
     * Header Styles
     */
	$wp_customize->add_setting(
		'header_styles',
		array(
			'default'           => 'normal',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'header_styles',
		array(
			'label'       => esc_html__( 'Header Colour', 'nightingale' ),
			'description' => esc_html__( 'What background would you like for your header region?', 'nightingale' ),
			'section'     => 'section_header',
			'type'        => 'radio',
			'choices'     => array(
				'normal'   => esc_html__( 'Solid Colour', 'nightingale' ),
				'inverted' => esc_html__( 'White Logo Bar', 'nightingale' ),
			),
		)
	);

    /*
     * -----------------------------------------------------------
     * SHOW / HIDE Breadcrumb
     * -----------------------------------------------------------
     */
    $wp_customize->add_setting(
        'show_breadcrumb',
        array(
            'default'           => 'yes',
            'sanitize_callback' => 'nightingale_sanitize_select',
        )
    );
    $wp_customize->add_control(
        'show_breadcrumb',
        array(
            'label'       => esc_html__( 'Show Breadcrumb?', 'nightingale' ),
            'description' => esc_html__( 'Would you like to show the breadcrumb section on the site?', 'nightingale' ),
            'section'     => 'section_header',
            'type'        => 'radio',
            'choices'     => array(
                'yes' => esc_html__( 'Yes', 'nightingale' ),
                'no'  => esc_html__( 'No', 'nightingale' ),
            ),
        )
    );

    /*
        Show/Hide Site Title
    */
    $wp_customize->add_setting(
        'show_sitename',
        array(
            'default'           => 'yes',
            'sanitize_callback' => 'nightingale_sanitize_select',
        )
    );
    $wp_customize->add_control(
        'show_sitename',
        array(
            'label'       => esc_html__( 'Show Site Name?', 'nightingale' ),
            'description' => esc_html__( 'Would you like to show the site name in the header?', 'nightingale' ),
            'section'     => 'title_tagline',
            'type'        => 'radio',
            'choices'     => array(
                'yes' => esc_html__( 'Yes', 'nightingale' ),
                'no'  => esc_html__( 'No', 'nightingale' ),
            ),
        )
    );

    /*
    * Logo/Sitename Has Link?
    */
    $wp_customize->add_setting(
        'logo_has_link',
        array(
            'default'           => 'yes',
            'sanitize_callback' => 'nightingale_sanitize_select',
        )
    );
    $wp_customize->add_control(
        'logo_has_link',
        array(
            'label'       => esc_html__( 'Logo/Site Name Link?', 'nightingale' ),
            'description' => esc_html__( 'Would you like the site name and/or logo  to be a link? You can set a custom link or the default link is to the homepage.', 'nightingale' ),
            'section'     => 'title_tagline',
            'type'        => 'radio',
            'choices'     => array(
                'yes' => esc_html__( 'Yes', 'nightingale' ),
                'no'  => esc_html__( 'No', 'nightingale' ),
            ),
        )
    );

    /*
     * Logo/Site name custom link
     */
    $wp_customize->add_setting(
        'logo_custom_link',
        array(
            'sanitize_callback' => 'nightingale_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'logo_custom_link',
        array(
            'label'           => esc_html__( 'Logo/Site Name custom link', 'nightingale' ),
            'description' => esc_html__( 'Link defaults to homepage if it is not set', 'nightingale' ),
            'section'         => 'title_tagline',
            'type'            => 'text',
            'active_callback' => function () use ( $wp_customize ) {
                return 'yes' === $wp_customize->get_setting( 'logo_has_link' )->value();
            },
        )
    );

	/*
	 * Show Organisation Name?
	 */
	$wp_customize->add_setting(
		'org_name_checkbox',
		array(
			'default'           => 'no',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'org_name_checkbox',
		array(
			'label'       => esc_html__( 'Do you wish to add an organisation name to the logo and copyright?', 'nightingale' ),
			'description' => esc_html__( 'This is used if your oganisation name should be different from the site title. It is also picked up for the copyright statement in your footer', 'nightingale' ),
			'section'     => 'title_tagline',
			'type'        => 'radio',
			'choices'     => array(
				'yes' => esc_html__( 'Yes', 'nightingale' ),
				'no'  => esc_html__( 'No', 'nightingale' ),
			),
		)
	);

	$wp_customize->add_setting(
		'org_name_field',
		array(
			'sanitize_callback' => 'nightingale_sanitize_nohtml',
		)
	);

	$wp_customize->add_control(
		'org_name_field',
		array(
			'label'           => esc_html__( 'Enter Organisation name', 'nightingale' ),
			'section'         => 'title_tagline',
			'type'            => 'text',
			'active_callback' => function () use ( $wp_customize ) {
				return 'yes' === $wp_customize->get_setting( 'org_name_checkbox' )->value();
			},
		)
	);

    $wp_customize->add_setting('copyright_img', array(
        'sanitize_callback' => 'nightingale_sanitize_image'
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'copyright_img_control', array(
        'label'       => esc_html__( 'Footer Copyright Image?', 'nightingale' ),
        'description' => esc_html__( 'Select a copyright image for the footer', 'nightingale' ),
        'settings'  => 'copyright_img',
        'section'   => 'title_tagline'
    ) ));

    $wp_customize->add_setting(
        'copyright_additional_text',
        array(
            'sanitize_callback' => 'wp_kses_post',
            'transport'   => 'refresh'
        )
    );

    $wp_customize->add_control(
        'copyright_additional_text',
        array(
            'label'           => esc_html__( 'Copyright Additional Text', 'nightingale' ),
            'description' => esc_html__( 'This text is shown next to copyright. It can include links.', 'nightingale' ),
            'section'         => 'title_tagline',
            'type'            => 'textarea',
        )
    );

	/*
	 * -----------------------------------------------------------
	 * Theme colour chooser
	 * -----------------------------------------------------------
	 */
	$wp_customize->add_setting(
		'theme_colour',
		array(
			'default'           => 'blue',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'theme_colour',
		array(
			'label'       => esc_html__( 'Theme Colour', 'hale' ),
			'description' => esc_html__( 'If you wish to change the default colour of the theme.', 'hale' ),
			'section'     => 'colors',
			'type'        => 'select',
			'choices'     => hale_get_theme_colours(),
		)
	);

    /*
     * -----------------------------------------------------------
     * Header colour chooser
     * -----------------------------------------------------------
     */
    $wp_customize->add_setting(
        'page_header_colour',
        array(
            'default'           => '',
            'sanitize_callback' => 'nightingale_sanitize_select',
        )
    );
    $wp_customize->add_control(
        'page_header_colour',
        array(
            'label'       => esc_html__( 'Page Header Colour', 'nightingale' ),
            'description' => esc_html__( 'Sets the background color of page headers. Please note all colours are set to 10% opacity', 'nightingale' ),
            'section'     => 'colors',
            'type'        => 'select',
            'choices'     => hale_get_theme_colours(),
        )
    );


	/*
	 * ------------------------------------------------------------
	 * SECTION: Layout
	 * ------------------------------------------------------------
	 */
	$wp_customize->add_section(
		'section_layout',
		array(
			'title'       => esc_html__( 'Layout', 'nightingale' ),
			'description' => esc_attr__( 'Customise your site layout', 'nightingale' ),
			'priority'    => 30,
		)
	);

	/*
	 * Display Featured image on post / page?
	 */
	$wp_customize->add_setting(
		'featured_img_display',
		array(
			'default'           => 'true',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'featured_img_display',
		array(
			'label'       => esc_html__( 'Display Featured Image on posts / pages single view', 'nightingale' ),
			'description' => esc_html__( 'Featured images are really useful for search results and listing pages. Sometimes its handy to have them for this, but you don\'t want the image to show on the individual page. If thats the case, turn them off here.', 'nightingale' ),
			'section'     => 'section_layout',
			'priority'    => '100',
			'type'        => 'radio',
			'choices'     => array(
				'true'  => esc_html__( 'Yes', 'nightingale' ),
				'false' => esc_html__( 'No', 'nightingale' ),
			),
		)
	);

	$wp_customize->add_setting(
	// $id
		'blog_fimage_display',
		// $args
		array(
			'default'           => 'top',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
	// $id
		'blog_fimage_display',
		// $args
		array(
			'settings'    => 'blog_fimage_display',
			'section'     => 'section_layout',
			'priority'    => '110',
			'type'        => 'radio',
			'label'       => esc_html__( 'Featured images display', 'nightingale' ),
			'description' => esc_html__( 'Show Featured Image at top of individual posts, or to the side. (If Display Featured Image above is set to no, this setting is ignored)', 'nightingale' ),
			'choices'     => array(
				'top'   => esc_html__( 'Top of post', 'nightingale' ),
				'left'  => esc_html__( 'Floated left', 'nightingale' ),
				'right' => esc_html__( 'Floated right', 'nightingale' ),
			),
		)
	);
}

add_action( 'customize_register', 'nightingale_customize_register' );

/**
 * Settings to customise blog pages.
 *
 * @param array $wp_customize all the saved settings for the theme customiser.
 */
function nightingale_add_blog_settings( $wp_customize ) {

	$wp_customize->add_section(
		'blog_panel',
		array(
			'title'          => esc_html__( 'Blog Settings', 'nightingale' ),
			'description'    => esc_html__( 'Extra settings for the Blog page', 'nightingale' ),
			'capability'     => 'edit_theme_options',
			'theme-supports' => '',
			'priority'       => '150',
		)
	);

	$wp_customize->add_setting(
	// $id
		'blog_sidebar',
		// $args
		array(
			'default'           => 'true',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
	// $id
		'blog_sidebar',
		// $args
		array(
			'settings'    => 'blog_sidebar',
			'section'     => 'blog_panel',
			'type'        => 'radio',
			'label'       => esc_html__( 'Display Sidebar', 'nightingale' ),
			'description' => esc_html__( 'Choose whether or not to display the sidebar on the blog page', 'nightingale' ),
			'choices'     => array(
				'true'  => esc_html__( 'Sidebar', 'nightingale' ),
				'false' => esc_html__( 'No Sidebar', 'nightingale' ),
			),
		)
	);

	$wp_customize->add_setting(
	// $id
		'blog_author_display',
		// $args
		array(
			'default'           => 'true',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
	// $id
		'blog_author_display',
		// $args
		array(
			'settings'    => 'blog_author_display',
			'section'     => 'blog_panel',
			'type'        => 'radio',
			'label'       => esc_html__( 'Show Author Name on Blog Posts?', 'nightingale' ),
			'description' => esc_html__( 'Choose whether or not to display the authors name (and link) on the blog page', 'nightingale' ),
			'choices'     => array(
				'true'  => esc_html__( 'Show author', 'nightingale' ),
				'false' => esc_html__( 'Dont show author', 'nightingale' ),
			),
		)
	);

	$wp_customize->add_setting(
	// $id
		'blog_date_display',
		// $args
		array(
			'default'           => 'true',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_select',
		)
	);

	$wp_customize->add_control(
	// $id
		'blog_date_display',
		// $args
		array(
			'settings'    => 'blog_date_display',
			'section'     => 'blog_panel',
			'type'        => 'radio',
			'label'       => esc_html__( 'Show Post Date on Blog Posts?', 'nightingale' ),
			'description' => esc_html__( 'Choose whether or not to display the date a post was made on the blog page', 'nightingale' ),
			'choices'     => array(
				'true'  => esc_html__( 'Show date', 'nightingale' ),
				'false' => esc_html__( 'Dont show date', 'nightingale' ),
			),
		)
	);

	$wp_customize->add_setting(
	// $id
		'blog_fallback',
		// $args
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'nightingale_sanitize_image',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'blog_fallback',
			array(
				'settings'    => 'blog_fallback',
				'mime_type'   => 'image',
				'section'     => 'blog_panel',
				'label'       => esc_html__( 'Blog Fallback Image', 'nightingale' ),
				'description' => esc_html__( 'Select a fallback image if the blog post does not have a featured image. Leave blank if no fallback wanted', 'nightingale' ),
			)
		)
	);

    $wp_customize->remove_control( 'custom_css' );
}

add_action( 'customize_register', 'nightingale_add_blog_settings' );

/**
 * Clean the date output up.
 *
 * @param datetime $input raw date.
 *
 * @return string.
 */
function nightingale_sanitize_date( $input ) {
	$date = new DateTime( $input );

	return $date->format( 'd-m-Y' );
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function nightingale_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function nightingale_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function nightingale_customize_preview_js() {
	wp_enqueue_script( 'nightingale-customizer', get_template_directory_uri() . '/js/customizer.js', array(
		'jquery',
		'customize-preview'
	), '20151215', true );
}

add_action( 'customize_preview_init', 'nightingale_customize_preview_js' );


add_action( 'customize_register', 'nightingale_add_typography_settings' );

function nightingale_add_typography_settings( $wp_customize )
{
    $wp_customize->add_section(
        'typography_panel',
        array(
            'title' => esc_html__('Typography', 'nightingale'),
            'description' => esc_html__('Typography settings', 'nightingale'),
            'capability' => 'edit_theme_options',
            'theme-supports' => '',
            'priority' => '151',
        )
    );


    $wp_customize->add_setting(
    // $id
        'primary_font',
        // $args
        array(
            'default'           => 'true',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'nightingale_sanitize_select',
        )
    );


    $wp_customize->add_control(
    // $id
        'primary_font',
        // $args
        array(
            'settings'    => 'primary_font',
            'section'     => 'typography_panel',
            'type'        => 'select',
            'label'       => esc_html__( 'Primary Font', 'nightingale' ),
            'description' => esc_html__( 'Main font used on headings and text', 'nightingale' ),
            'choices'     => array(
                'frutiger'  => esc_html__( 'Frutiger', 'nightingale' ),
                'pt-sans' => esc_html__( 'PT Sans', 'nightingale' ),
            ),
        )
    );


}


add_action( 'customize_register', 'hale_add_blocks_settings' );

function hale_add_blocks_settings( $wp_customize )
{

    if( current_user_can('administrator') ) {

        $wp_customize->add_section(
            'blocks_panel',
            array(
                'title' => esc_html__('Blocks', 'hale'),
                'description' => esc_html__('Blocks settings', 'hale'),
                'capability' => 'edit_theme_options',
                'theme-supports' => '',
                'priority' => '151',
            )
        );

        /*
        *  Restrict Blocks Settings
        */
        $wp_customize->add_setting(
            'restrict_blocks',
            array(
                'default' => 'yes',
            )
        );

        $wp_customize->add_control(
            'restrict_blocks',
            array(
                'label' => esc_html__('Restrict Blocks', 'hale'),
                'description' => esc_html__('Hides some core Wordpress blocks that are not currently compatible with Hale theme', 'hale'),
                'section' => 'blocks_panel',
                'priority' => '100',
                'type' => 'radio',
                'choices' => array(
                    'yes' => esc_html__('Yes', 'hale'),
                    'no' => esc_html__('No', 'hale'),
                ),
            )
        );
    }


}
