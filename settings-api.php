<?php 
add_action( 'admin_menu', 'parcel_api_add_admin_menu' );
add_action( 'admin_init', 'parcel_api_settings_init' );

function parcel_api_add_admin_menu(  ) {
    add_options_page('Parcel Address Settings', 'Parcel Address Settings', 'manage_options', 'settings-api-page', 'parcel_api_options_page');
}

function parcel_api_settings_init(  ) {
    register_setting( 'apiPlugin', 'parcel_api_settings' );
    add_settings_section(
        'parcel_api_apiPlugin_section',
        __( '', 'apiPlugin' ),
        'parcel_api_settings_section_callback',
        'apiPlugin'
    );

    add_settings_field(
        'parcel_client_id',
        __( 'Client ID', 'apiPlugin' ),
        'parcel_client_id_render',
        'apiPlugin',
        'parcel_api_apiPlugin_section'
    );

   add_settings_field(
        'parcel_client_secret',
        __( 'Client Secret', 'apiPlugin' ),
        'parcel_client_secret_render',
        'apiPlugin',
        'parcel_api_apiPlugin_section'
    );

    // add_settings_field(
    //     'parcel_api_username',
    //     __( 'Username', 'apiPlugin' ),
    //     'parcel_api_username_render',
    //     'apiPlugin',
    //     'parcel_api_apiPlugin_section'
    // );

    //  add_settings_field(
    //     'parcel_api_password',
    //     __( 'Password', 'apiPlugin' ),
    //     'parcel_api_password_render',
    //     'apiPlugin',
    //     'parcel_api_apiPlugin_section'
    // );

}

function parcel_client_id_render(  ) {
    $options = get_option( 'parcel_api_settings' );
    ?>
  <input type='text' name='parcel_api_settings[parcel_client_id]' placeholder="Client ID" style="width:350px" value='<?php echo $options['parcel_client_id']; ?>'>
  
    <?php
}

function parcel_client_secret_render(  ) {
    $options = get_option( 'parcel_api_settings' );
    ?>
  
  <input type='text' name='parcel_api_settings[parcel_client_secret]' placeholder="Client Secret" style="width:350px"  value='<?php echo $options['parcel_client_secret']; ?>'>
    <?php
}

function parcel_api_username_render(  ) {
    $options = get_option( 'parcel_api_settings' );
    ?>
  
  <input type='text' name='parcel_api_settings[parcel_api_username]' placeholder="Username"  style="width:350px" value='<?php echo $options['parcel_api_username']; ?>'>
    <?php
}

function parcel_api_password_render(  ) {
    $options = get_option( 'parcel_api_settings' );
    ?>
  
  <input type='password' name='parcel_api_settings[parcel_api_password]' placeholder="Password" style="width:350px" value='<?php echo $options['parcel_api_password']; ?>'>
    <?php
}

function parcel_api_settings_section_callback(  ) {
    echo __( 'Thsi clever plugin uses the NZ Post API to auto complete Woocommerce shipping addresses.<br><br>', 'apiPlugin' );
    echo __( 'Please add client id, client secret to call the API.', 'apiPlugin' );
}

function parcel_api_options_page() {
	 settings_errors( 'apiPlugin_messages' );
    ?>
    <form action='options.php' method='post'>

        <h2>Parcel Address API Settings </h2>

        <?php
        settings_fields( 'apiPlugin' );
        do_settings_sections( 'apiPlugin' );
        submit_button();
        ?>

    </form>
    <?php
}
?>