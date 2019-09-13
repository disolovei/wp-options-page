<?php
/**
 * 
 */
function vlnsk_output_option_page() {
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
				settings_fields( 'rvr_profile_settings_section' );
				do_settings_sections( 'rvr_profile_settings' );
			} else {
				settings_fields( 'rvr_primary_settings_section' );
				do_settings_sections( 'rvr_primary_settings' );
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
    add_submenu_page( 
        'options-general.php', 
        'Custom options page', 
        'Custom options page', 
        'manage_options', 
        'custom_option_page_slug', 
        'vlnsk_output_option_page'
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
function vlnsk_create_options() {
    // add_settings_section( 'vlnsk_first_section', 'First section title', null, 'options' );
    // or
    add_settings_section( 'vlnsk_first_section', 'First section title', 'vlnsk_first_section_desc', 'options' );
    add_settings_section( 'vlnsk_second_section', 'Second section title', 'vlnsk_second_section_desc', 'options' );
}
add_action( 'admin_init', 'vlnsk_create_options' );