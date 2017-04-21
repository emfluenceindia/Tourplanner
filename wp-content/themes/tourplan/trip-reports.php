<?php
/*
Template Name: Trip Report List
*/

$v = false;
update_option2('_show_index_option_false', false);

function update_option2( $option, $value, $autoload = null ) {
    global $wpdb;

    $option = trim($option);
    if ( empty($option) )
        return false;

    wp_protect_special_option( $option );

    if ( is_object( $value ) )
        $value = clone $value;

    if($value === false)
        $value = 0;

    $value = sanitize_option( $option, $value );
    $old_value = get_option( $option );

    /**
     * Filters a specific option before its value is (maybe) serialized and updated.
     *
     * The dynamic portion of the hook name, `$option`, refers to the option name.
     *
     * @since 2.6.0
     * @since 4.4.0 The `$option` parameter was added.
     *
     * @param mixed  $value     The new, unserialized option value.
     * @param mixed  $old_value The old option value.
     * @param string $option    Option name.
     */
    $value = apply_filters( "pre_update_option_{$option}", $value, $old_value, $option );

    /**
     * Filters an option before its value is (maybe) serialized and updated.
     *
     * @since 3.9.0
     *
     * @param mixed  $value     The new, unserialized option value.
     * @param string $option    Name of the option.
     * @param mixed  $old_value The old option value.
     */
    $value = apply_filters( 'pre_update_option', $value, $option, $old_value );
    //echo $value;

    // If the new and old values are the same, no need to update.
    if ( $value === $old_value )
        return false;

    /** This filter is documented in wp-includes/option.php */
    if ( apply_filters( 'default_option_' . $option, false, $option, false ) === $old_value ) {
        // Default setting for new options is 'yes'.
        if ( null === $autoload ) {
            $autoload = 'yes';
        }

        return add_option( $option, $value, '', $autoload );
    }

    $serialized_value = maybe_serialize( $value );
    //echo $serialized_value;

    /**
     * Fires immediately before an option value is updated.
     *
     * @since 2.9.0
     *
     * @param string $option    Name of the option to update.
     * @param mixed  $old_value The old option value.
     * @param mixed  $value     The new option value.
     */
    do_action( 'update_option', $option, $old_value, $value );

    $update_args = array(
        'option_value' => $serialized_value,
    );

    //echo $update_args['option_value'];

    if ( null !== $autoload ) {
        $update_args['autoload'] = ( 'no' === $autoload || false === $autoload ) ? 'no' : 'yes';
    }

    $result = $wpdb->update( $wpdb->options, $update_args, array( 'option_name' => $option ) );
    if ( ! $result )
        return false;

    $notoptions = wp_cache_get( 'notoptions', 'options' );
    if ( is_array( $notoptions ) && isset( $notoptions[$option] ) ) {
        unset( $notoptions[$option] );
        wp_cache_set( 'notoptions', $notoptions, 'options' );
    }

    if ( ! wp_installing() ) {
        $alloptions = wp_load_alloptions();
        if ( isset( $alloptions[$option] ) ) {
            $alloptions[ $option ] = $serialized_value;
            wp_cache_set( 'alloptions', $alloptions, 'options' );
        } else {
            wp_cache_set( $option, $serialized_value, 'options' );
        }
    }

    /**
     * Fires after the value of a specific option has been successfully updated.
     *
     * The dynamic portion of the hook name, `$option`, refers to the option name.
     *
     * @since 2.0.1
     * @since 4.4.0 The `$option` parameter was added.
     *
     * @param mixed  $old_value The old option value.
     * @param mixed  $value     The new option value.
     * @param string $option    Option name.
     */
    do_action( "update_option_{$option}", $old_value, $value, $option );

    /**
     * Fires after the value of an option has been successfully updated.
     *
     * @since 2.9.0
     *
     * @param string $option    Name of the updated option.
     * @param mixed  $old_value The old option value.
     * @param mixed  $value     The new option value.
     */
    do_action( 'updated_option', $option, $old_value, $value );
    return true;
}

?>