<?php
add_action( 'admin_menu', 'simple_banner_add_admin_menu' );
add_action( 'admin_init', 'simple_banner_settings_init' );

function simple_banner_add_admin_menu(  ) {

    add_options_page( 'Simple banner', 'Simple banner', 'manage_options', 'simple_banner', 'simple_banner_options_page' );

}

function simple_banner_settings_init(  ) {

    register_setting( 'pluginPages', 'simple_banner_settings' );

    add_settings_section(
        'simple_banner_pluginPage_section',
        __( 'Settings:', 'simple-banner' ),
        'simple_banner_settings_section_callback',
        'pluginPages'
    );

    add_settings_section(
        'simple_banner_settings_section_info',
        __( 'Settings:', 'simple-banner' ),
        'simple_banner_settings_section_info',
        'pluginPages'
    );

    add_settings_field(
        'simple_banner_checkbox_css',
        __( 'Gỡ bỏ css mặc định, sử dụng css tự định nghĩa', 'simple-banner' ),
        'simple_banner_checkbox_css_render',
        'pluginPages',
        'simple_banner_pluginPage_section'
    );

}

function simple_banner_checkbox_css_render(  ) 
{
    $options = get_option( 'simple_banner_settings' );
    ?>
    <input type='checkbox' name='simple_banner_settings[simple_banner_checkbox_css]' <?php checked( (int)$options, 1 ); ?> value='1'>
    <?php
}

function simple_banner_settings_section_callback() 
{
    echo '<p class="simple_banner_info">' . __( 'Tự định nghĩa image size, css, format date theo mong muốn.', 'simple-banner' ) . '</p>';
}

function simple_banner_settings_section_info() 
{
    echo '<div class="simple-banner-info">';
    echo '<p><strong>Hướng dẫn sử dụng Shortcodes:</strong><br /><em>' . __( '[banner cat=1,2 limitwordtitle=4 limitwordcontent=5 formatdate=Y-m-d imgtype = full]' ) . '</em></p>';
    echo '</div>';
}

function simple_banner_options_page() 
{ ?>
<style>
    .form-table th {min-width: 280px;}
    p.simple_banner_info {background: chocolate;padding: 1em;color: #fff;}
    h2 {display: none;}
    .simple-banner-info {background:rgba(212, 105, 6, 0.1);padding: 1em;}
</style>
<form action='options.php' method='post' style="background-color: #fff;padding: 1em 2em;margin: 20px 20px 20px 0; box-shadow: 0 0 1px #000;">
<h1>Simple banner</h1>
<?php
    settings_fields( 'pluginPages' );
    do_settings_sections( 'pluginPages' );
    submit_button();
?>
</form>
<?php
} 
?>