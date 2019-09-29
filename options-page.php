<?php
/**
 * 
 */
function vlnsk_selected( $curr_value, $values, $print = true ) {
    if ( ! is_array( $values ) ) {
        $value =  '';
    } elseif ( in_array( $curr_value, $values ) ) {
        $value = ' selected="selected"';
    } else {
        $value = '';
    }

    if ( $print ) {
        echo $value;
    } else {
        return $value;
    }
}

/**
 * 
 */
function vlnsk_input_text_option_callback( $args ) {
    $class          = ! empty( $args['class'] ) ? esc_attr( $args['class'] ) : 'regular-text';
    $option_value   = get_option( $args['name'] );

    if ( ! $option_value && ! empty( $args['default'] ) ) {
        $option_value = esc_attr( $args['default'] );
    }

    ?>

    <label>
        <input 
            class="<?php echo $class; ?>" 
            type="text" 
            id="<?php echo esc_attr( $args['id'] ); ?>" 
            name="<?php echo esc_attr( $args['name'] ); ?>" 
            value="<?php echo $option_value; ?>" 

            <?php if ( isset( $args['readonly'] ) && true === $args['readonly'] ) {
                echo ' readonly="readonly"';
            } ?>

            <?php if ( isset( $args['disabled'] ) && true === $args['disabled'] ) {
                echo ' disabled="disabled"';
            } ?>

            />

            <?php if ( ! empty( $args['desc'] ) ) {
                printf( '<p class="description">%s</p>', strip_tags( $args['desc'], '<b><i><strong><em>' ) );
            } ?>

    </label>

    <?php
}

/**
 * 
 */
function vlnsk_input_number_option_callback( $args ) {
    $class          = ! empty( $args['class'] ) ? esc_attr( $args['class'] ) : 'small-text';
    $option_value   = get_option( $args['name'] );

    if ( ! $option_value && ! empty( $args['default'] ) ) {
        $option_value = esc_attr( $args['default'] );
    }

    ?>

    <label>
        <input 
            class="<?php echo $class; ?>" 
            type="number" 
            id="<?php echo esc_attr( $args['id'] ); ?>" 
            name="<?php echo esc_attr( $args['name'] ); ?>" 
            value="<?php echo $option_value; ?>" 

            <?php if ( true === $args['readonly'] ) {
                echo ' readonly="readonly"';
            } ?>

            <?php if ( true === $args['disabled'] ) {
                echo ' disabled="disabled"';
            } ?>

            />

            <?php if ( ! empty( $args['desc'] ) ) {
                printf( '<p class="description">%s</p>', strip_tags( $args['desc'], '<b><i><strong><em>' ) );
            } ?>

    </label>

    <?php
}

/**
 * 
 */
function vlnsk_select_option_callback( $args ) {
    if ( empty( $args['options'] ) ) {
        return;
    }

    $option_value   = get_option( $args['name'] );
    $multiple       = isset( $args['multiple'] ) ? (bool)$args['multiple'] : false;
    ?>

    <label>
        <select 
            name="<?php printf( 
                '%s%s', 
                esc_attr( $args['name'] ), 
                $multiple ? '[]' : ''
                );?>" 
            id="<?php echo esc_attr( $args['id'] ); ?>"

            <?php if ( $multiple ) {
                echo ' multiple="multiple"';
            } ?>

            >

            <?php foreach( $args['options'] as $value => $text ) {
                printf( 
                    '<option value="%s" %s>%s</option>',
                    esc_attr( $value ),
                    $multiple ? vlnsk_selected( $value, $option_value, false ) : selected( $option_value, $value, false ),
                    $text
                );
            } ?>

            </select>

            <?php if ( ! empty( $args['desc'] ) ) {
                printf( '<p class="description">%s</p>', strip_tags( $args['desc'], '<b><i><strong><em>' ) );
            } ?>

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
        'vlsnk_custom_option_page_general', 
        'vlnsk_first_section', 
        array( 
            'id'        => 'vlnsk-first-select-option',
            'name'      => 'vlnsk_first_select_option',
            'options'   => array( 'One select option', 'Two select option', 'Three select option' ),
        )
    );

    add_settings_field( 
        'vlnsk_first_input_text_option', 
        'First input text option', 
        'vlnsk_input_text_option_callback', 
        'vlsnk_custom_option_page_general', 
        'vlnsk_first_section', 
        array( 
            'id'        => 'vlnsk-first-input-text-option',
            'name'      => 'vlnsk_first_input_text_option',
            'default'   => '',
            'readonly'  => false,
            'class'     => 'large-text',
        )
    );

    register_setting( 'vlnsk_first_settings_group', 'vlnsk_first_select_option' );
    register_setting( 'vlnsk_first_settings_group', 'vlnsk_first_input_text_option' );

     //Second tab
    add_settings_section( 'vlnsk_second_section', 'Second section title', 'vlnsk_second_section_desc', 'vlsnk_custom_option_page_second' );

    add_settings_field( 
        'vlnsk_second_select_option', 
        'Second select option', 
        'vlnsk_select_option_callback', 
        'vlsnk_custom_option_page_second', 
        'vlnsk_second_section', 
        array( 
            'id'        => 'vlnsk-second-select-option',
            'name'      => 'vlnsk_second_select_option',
            'options'   => array( 'One select option', 'Two select option', 'Three select option' ),
            'multiple'  => true,
        )
    );

    add_settings_field( 
        'vlnsk_second_input_text_option', 
        'Second input text option', 
        'vlnsk_input_text_option_callback', 
        'vlsnk_custom_option_page_second', 
        'vlnsk_second_section', 
        array( 
            'id'        => 'vlnsk-second-input-text-option',
            'name'      => 'vlnsk_second_input_text_option',
            'default'   => 'Default value',
            'readonly'  => true,
            'desc'      => 'Field description',
        )
    );

    register_setting( 'vlnsk_second_settings_group', 'vlnsk_second_select_option' );
    register_setting( 'vlnsk_second_settings_group', 'vlnsk_second_input_text_option' );
}
add_action( 'admin_menu', 'vlnsk_create_options' );
