<?php
function my_error_notice($message) {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( $message ); ?></p>
    </div>
    <?php
}
add_action('my-error-notice','my_error_notice');

function my_success_notice($message) {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( $message ); ?></p>
    </div>
    <?php
}
add_action('my-success-notice','my_success_notice');


function my_warning_notice($message) {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( $message ); ?></p>
    </div>
    <?php
}
add_action('my-warning-notice','my_warning_notice');

