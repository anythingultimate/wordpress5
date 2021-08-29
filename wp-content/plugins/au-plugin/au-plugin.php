<?php

/**
 * Plugin Name: Plugin Practice
 * Plugin URI: https://example.com/plugins/aupp
 * Description: A short description of the plugin.
 * Version: 1.0.0
 * Requires at least: 5.3
 * Requires PHP: 5.6
 * Author: John Doe
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: aupp
 * Domain Path: /public/lang
 */


// Register our uninstall function
register_uninstall_hook( __FILE__, 'aupp_plugin_uninstall' );

// Deregister our settings group and delete all options
function aupp_plugin_uninstall() {

    // Clean de-registration of registered setting
    unregister_setting( 'aupp_plugin_options', 'aupp_plugin_options' );

    // Remove saved options from the database
    delete_option( 'aupp_plugin_options' );

}

// Add a menu for our option page
add_action( 'admin_menu', 'aupp_plugin_add_settings_menu' );

function aupp_plugin_add_settings_menu() {

    add_options_page( 'AUPP Plugin Settings', 'AUPP Settings', 'manage_options',
        'aupp_plugin', 'aupp_plugin_option_page' );

}

// Create the option page
function aupp_plugin_option_page() {
    ?>
    <div class="wrap">
        <h2>My plugin</h2>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'aupp_plugin_options' );
            do_settings_sections( 'aupp_plugin' );
            submit_button( 'Save Changes', 'primary' );
            ?>
        </form>
    </div>
    <?php
}

// Register and define the settings
add_action('admin_init', 'aupp_plugin_admin_init');

function aupp_plugin_admin_init(){

    // Define the setting args
    $args = array(
        'type' 				=> 'string',
        'sanitize_callback' => 'aupp_plugin_validate_options',
        'default' 			=> NULL
    );

    // Register our settings
    register_setting( 'aupp_plugin_options', 'aupp_plugin_options', $args );

    // Add a settings section
    add_settings_section(
        'aupp_plugin_main',
        'AUPP Plugin Settings',
        'aupp_plugin_section_text',
        'aupp_plugin'
    );

    // Create our settings field for name
    add_settings_field(
        'aupp_plugin_name',
        'Your Name',
        'aupp_plugin_setting_name',
        'aupp_plugin',
        'aupp_plugin_main'
    );


    // Create our settings field for favorite holiday
    add_settings_field(
        'aupp_plugin_fav_holiday',
        'Favorite Holiday',
        'aupp_plugin_setting_fav_holiday',
        'aupp_plugin',
        'aupp_plugin_main'
    );

    // Create our settings field for beast mode
    add_settings_field(
        'aupp_plugin_beast_mode',
        'Enable Beast Mode?',
        'aupp_plugin_setting_beast_mode',
        'aupp_plugin',
        'aupp_plugin_main'
    );

}

// Draw the section header
function aupp_plugin_section_text() {

    echo '<p>Enter your settings here.</p>';

}

// Display and fill the Name text form field
function aupp_plugin_setting_name() {

    // Get option 'text_string' value from the database
    $options = get_option( 'aupp_plugin_options' );
    $name = $options['name'];

    // Echo the field
    echo "<input id='name' name='aupp_plugin_options[name]'
        type='text' value='" . esc_attr( $name ) . "' />";

}

// Display and select the favorite holiday select field
function aupp_plugin_setting_fav_holiday() {

    // Get option 'fav_holiday' value from the database
    // Set to 'Halloween' as a default if the option does not exist
    $options = get_option('aupp_plugin_options', [ 'fav_holiday' => 'Halloween' ] );
    $fav_holiday = $options['fav_holiday'];

    // Define the select option values for favorite holiday
    $items = array( 'Halloween', 'Christmas', 'New Years');

    echo "<select id='fav_holiday' name='aupp_plugin_options[fav_holiday]'>";

    foreach( $items as $item ) {

        // Loop through the option values
        // If saved option matches the option value, select it
        echo "<option value='" . esc_attr( $item ) . "' ".selected( $fav_holiday, $item, false ).">" . esc_html( $item ) . "</option>";

    }

    echo "</select>";

}

//Display and set the Beast Mode radion button field
function aupp_plugin_setting_beast_mode() {

    // Get option 'beast_mode' value from the database
    // Set to 'disabled' as a default if the option does not exist
    $options = get_option( 'aupp_plugin_options', [ 'beast_mode' => 'disabled' ] );
    $beast_mode = $options['beast_mode'];

    // Define the radio button options
    $items = array( 'enabled', 'disabled' );

    foreach( $items as $item ) {

        // Loop the two radio button options and select if set in the option value
        echo "<label><input " . checked( $beast_mode, $item, false ) . " value='" . esc_attr( $item ) . "' name='aupp_plugin_options[beast_mode]' type='radio' />" . esc_html( $item ) . "</label><br />";

    }

}

// Validate user input for all three options
function aupp_plugin_validate_options( $input ) {

    // Only allow letters and spaces for the name
    $valid['name'] = preg_replace(
        '/[^a-zA-Z\s]/',
        '',
        $input['name'] );

    if( $valid['name'] !== $input['name'] ) {

        add_settings_error(
            'aupp_plugin_text_string',
            'aupp_plugin_texterror',
            'Incorrect value entered! Please only input letters and spaces.',
            'error'
        );

    }

    // Sanitize the data we are receiving
    $valid['fav_holiday'] = sanitize_text_field( $input['fav_holiday'] );
    $valid['beast_mode'] = sanitize_text_field( $input['beast_mode'] );

    return $valid;
}
?>

