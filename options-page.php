<?php
/**
 * Output all fields of a options page.
 */
function vlnsk_option_page_output () {
    ?>
    <div class="wrap">
        <h1><?php echo get_admin_page_title(); ?></h1>
        <form action="options.php" method="POST">
            <?php
            settings_fields( 'vlnsk_options' );
            do_settings_sections( 'vlnsk_options' );
            submit_button( 'Save options' );
            ?>
        </form>
    </div>
    <?php
}

/**
 * First section description.
 */
function vlnsk_first_section_callback() {
    echo 'First section description';
}

/**
 * Create first option field.
 *
 * @param $option_props
 */
function vlnsk_first_option_callback( $option_props ) {
    $option_value = get_option( $option_props['option_name'] ) or '';

    printf(
        '<input class="regular-text" id="%s" name="%s" type="text" value="%s" placeholder="First option value" />',
        esc_attr( $option_props['id'] ),
        esc_attr( $option_props['option_name'] ),
        esc_attr( $option_value )
    );
}

/**
 * Description for second section.
 */
function vlnsk_second_section_callback() {
	echo 'Second section description';
}

/**
 * Create second option field.
 *
 * @param $option_props
 */
function vlnsk_second_option_callback( $option_props ) {
	$option_value = get_option( $option_props['option_name'] ) or '';

	printf(
		'<textarea class="large-text" id="%s" name="%s" type="text" placeholder="Second option value">%s</textarea>',
		esc_attr( $option_props['id'] ),
		esc_attr( $option_props['option_name'] ),
		esc_attr( $option_value )
	);
}

/**
 * Add new admin menu item.
 */
function vlnsk_option_page_menu() {
    add_menu_page(
        'My options', //change this
        'My options', //change this
        'manage_options',
        'vlnsk_options', //change this
        'vlnsk_option_page_output',
        'dashicons-admin-generic',
        101
    );
}

/**
 * Register all options fields.
 */
function vlnsk_option_page_register_settings() {
    register_setting(
        'vlnsk_options',
        'first_option',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

	register_setting(
		'vlnsk_options',
		'second_option',
		array(
			'sanitize_callback' => 'sanitize_textarea_field'
		)
	);

    add_settings_section(
        'first_section',
        'First section title',
        'vlnsk_first_section_callback',
        'vlnsk_options'
    );

    add_settings_field(
        'first_option',
        'First option title',
        'vlnsk_first_option_callback',
        'vlnsk_options',
        'first_section',
        array(
            'id'            => 'first-option',
            'option_name'   => 'first_option',
        )
    );

	add_settings_section(
		'second_section',
		'Second section title',
		'vlnsk_second_section_callback',
		'vlnsk_options'
	);

	add_settings_field(
		'second_option',
		'Second option title',
		'vlnsk_second_option_callback',
		'vlnsk_options',
		'second_section',
		array(
			'id'            => 'second-option',
			'option_name'   => 'second_option',
		)
	);
}

if ( is_admin() ) {
    add_action( 'admin_menu', 'vlnsk_option_page_menu' );
    add_action( 'admin_init', 'vlnsk_option_page_register_settings' );
}