<?php
/**
 * 
 */
function vlnsk_select_option_callback( $args ) {
    ?>

    <label>
        <select 
            name="<?php echo esc_attr( $args['name'] ); ?>" 
            id="<?php echo esc_attr( $args['id'] ); ?>"
            >
            <option value="1">1</option>
            </select>
    </label>

    <?php
}

/**
 * 
 */
function vlsnk_custom_option_page_callback() {
    $active_tab = ! empty( $_GET['tab'] ) ? strip_tags( $_GET['tab'] ) : 'general';
    ?>

    <div class="wrap">
        <h2><?php echo get_admin_page_title(); ?></h2>
    </div>
    <p class="nav-tab-wrapper">
		<a href="?page=custom_option_page_slug&tab=general" class="nav-tab<?php echo 'general' == $active_tab ?  ' nav-tab-active': ''; ?>">General section</a>
		<a href="?page=custom_option_page_slug&tab=second" class="nav-tab<?php echo 'second' == $active_tab ?  ' nav-tab-active': ''; ?>">Second section</a>
	</h2>

    <?php settings_errors(); ?>

    <form method="post" action="options.php">

		<?php
			if ( 'general' == $active_tab ) {
				settings_fields( 'vlnsk_first_settings_group' );
				do_settings_sections( 'vlsnk_custom_option_page_general' );
			} else {
				settings_fields( 'vlnsk_second_settings_group' );
				do_settings_sections( 'vlsnk_custom_option_page_second' );
			}
			submit_button();
		?>

	</form>

    <?php
}

/**
 * 
 */
function vlnsk_add_option_page() {
    add_menu_page( 
        'Custom option page',
        'Custom option page',
        'manage_options',
        'custom_option_page_slug',
        'vlsnk_custom_option_page_callback',
        'dashicons-admin-generic',
        81
     );

     add_submenu_page( 
        'options-general.php', 
        'Custom options page', 
        'Custom options page', 
        'manage_options', 
        'custom_option_page_slug', 
        'vlsnk_custom_option_page_callback'
     );
}
add_action( 'admin_menu', 'vlnsk_add_option_page' );

/**
 * 
 */
function vlnsk_first_section_desc() {
    echo '<p>First section description</p>';
}

/**
 * 
 */
function vlnsk_second_section_desc() {
    echo '<p>First section description</p>';
}

/**
 * 
 */
function vlnsk_create_options() {
    //First tab
    add_settings_section( 'vlnsk_first_section', 'First section title', 'vlnsk_first_section_desc', 'vlsnk_custom_option_page_general' );

    add_settings_field( 
        'vlnsk_first_select_option', 
        'First select option', 
        'vlnsk_select_option_callback', 
        'vlsnk_custom_option_page_slug', 
        'vlnsk_first_section', 
        array( 
            'id'        => 'vlnsk-first-select-option',
            'name'      => 'vlnsk_first_select_option',
            'options'   => array(),
        )
    );

    register_setting( 'vlnsk_first_settings_group', 'vlnsk_first_select_option' );

     //Second tab
    add_settings_section( 'vlnsk_second_section', 'Second section title', 'vlnsk_second_section_desc', 'vlsnk_custom_option_page_second' );

    add_settings_field( 
        'vlnsk_second_select_option', 
        'Second select option', 
        'vlnsk_select_option_callback', 
        'vlsnk_custom_option_page_slug', 
        'vlnsk_first_section', 
        array( 
            'id'        => 'vlnsk-first-select-option',
            'name'      => 'vlnsk_first_select_option',
            'options'   => array(),
        )
    );

    register_setting( 'vlnsk_first_settings_group', 'vlnsk_first_select_option' );
}
add_action( 'admin_menu', 'vlnsk_create_options' );