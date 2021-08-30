<?php
/**
 * Plugin Name: Nonce Example
 * Plugin URI: http://example.com/
 * Description: Displays an example nonce field and verifies it.
 * Author: WROX
 * Author URI: http://wrox.com
 */
add_action( 'admin_menu', 'aupp_nonce_example_menu' );
add_action( 'admin_init', 'aupp_nonce_example_verify' );
function aupp_nonce_example_menu() {
    add_menu_page(
        'Nonce Example',
        'Nonce Example',
        'manage_options',
        'aupp-nonce-example',
        'aupp_nonce_example_template'
    );
}
function aupp_nonce_example_verify() {
    // Bail if no nonce field.
    if ( ! isset( $_POST['aupp_nonce_name'] ) ) {
        return;
    }
    // Display error and die if not verified.
    if ( ! wp_verify_nonce( $_POST['aupp_nonce_name'], 'aupp_nonce_action' ) ) {
        wp_die( 'Your nonce could not be verified.' );
    }
    // Sanitize and update the option if it's set.
    if ( isset( $_POST['aupp_nonce_example'] ) ) {
        update_option(
            'aupp_nonce_example',
            wp_strip_all_tags( $_POST['aupp_nonce_example'] )
        );
    }
}
function aupp_nonce_example_template() { ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Nonce Example</h1>
        <?php $value = get_option( 'aupp_nonce_example' ); ?>
        <form method="post" action="">
            <?php wp_nonce_field( 'aupp_nonce_action', 'aupp_nonce_name' ); ?>
            <p>
                <label>
                    Enter your name:
                    <input type="text" name="aupp_nonce_example"
                           value="<?php echo esc_attr( $value ); ?>"/>
                </label>
            </p>
            <?php submit_button( 'Submit', 'primary' ); ?>
        </form>
    </div>
<?php }

