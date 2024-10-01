<?php
// function rj_bookmarks_add_custom_controls() {
// 	load_template( trailingslashit( get_template_directory() ) . '/inc/rj-customizer/rj-toggle-controls.php' );
// }
// add_action( 'customize_register', 'rj_bookmarks_add_custom_controls' );

function rj_bookmarks_customizer_register( $wp_customize ){

  wp_enqueue_script('customizer-repeater', get_template_directory_uri() . '/js/customizer-repeater.js', array('jquery', 'customize-controls'), '1.0', true);

  $wp_customize->add_panel( 'rj_employee_portal_add_panel', array(
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => esc_html__( 'Employee Portal Settings', 'astra-child' ),
    'priority' => 10,
  ));

  $wp_customize->add_section('rj_bookmarks_topabr', array(
	'title'    => __('Custom Portals', 'your-theme-textdomain'),
	'panel' => 'rj_employee_portal_add_panel',
	'priority' => 30,
));

// Add setting for portals
	$wp_customize->add_setting('custom_portals', array(
		'default'           => json_encode(array(
			array(
				'title' => 'HR and Benefits',
				'icon'  => '<svg viewBox="0 0 640 512">...</svg>',
				'link'  => 'HR Benefits'
			),
			// Add other default portals here
		)),
		'sanitize_callback' => 'custom_portals_sanitize',
	));

	
	$wp_customize->add_section('rj_bookmarks_topabr' , array(
		'title' => __( 'Main Page', 'astra-child' ),
		'panel' => 'rj_employee_portal_add_panel'
	) );



    // Add setting for the number of portals
    $wp_customize->add_setting('custom_portals_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('custom_portals_count', array(
        'label'    => __('Number of Portals', 'your-theme-textdomain'),
        'section'  => 'rj_bookmarks_topabr',
        'type'     => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ),
    ));

   
	
	}
add_action( 'customize_register', 'rj_bookmarks_customizer_register' );


