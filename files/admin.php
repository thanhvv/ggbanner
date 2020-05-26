<?php
add_action( 'admin_menu', 'breaking_add_admin_menu' );
add_action( 'admin_init', 'breaking_settings_init' );

function breaking_add_admin_menu(  ) {

    add_options_page( 'Breaking News', 'Breaking News', 'manage_options', 'breaking', 'breaking_options_page' );

}

function breaking_settings_init(  ) {

    register_setting( 'pluginBreakingNews', 'breaking_settings' );

    add_settings_section(
        'breaking_pluginPage_section',
        __( 'Settings:', 'breaking-news' ),
        'breaking_settings_section_callback',
        'pluginBreakingNews'
    );

    add_settings_section(
        'breaking_settings_section_info',
        __( 'Settings:', 'breaking-news' ),
        'breaking_settings_section_info',
        'pluginBreakingNews'
    );

    add_settings_field(
        'breaking_checkbox_css',
        __( 'Gỡ bỏ css mặc định, sử dụng css tự định nghĩa', 'breaking-news' ),
        'breaking_checkbox_css_render',
        'pluginBreakingNews',
        'breaking_pluginPage_section'
    );

}

function breaking_checkbox_css_render(  ) 
{
    $options = get_option( 'breaking_settings' );
    ?>
    <input type='checkbox' name='breaking_settings[breaking_checkbox_css]' <?php checked( (int)$options, 1 ); ?> value='1'>
    <?php
}

function breaking_settings_section_callback() 
{
    echo '<p class="breaking_info">' . __( 'Tự định nghĩa image size, css, format date theo mong muốn.', 'breaking-news' ) . '</p>';
}

function breaking_settings_section_info() 
{
    echo '<div class="breaking-news-info">';
    echo '<p><strong>Hướng dẫn sử dụng Shortcodes:</strong><br /><em>' . __( '[breaking-news number=3 col=3 offset=1 cat=42 post_type=hoi-vien taxonomy=chuyen-muc-hoi-vien limit_word_title=4 limit_word_content=5 format_date=Y-m-d img_type=breaking_news_plugin_small]' ) . '</em></p>';
    echo '</div>';
}

function breaking_options_page() 
{ ?>
<style>
    .form-table th {min-width: 280px;}
    p.breaking_info {background: chocolate;padding: 1em;color: #fff;}
    h2 {display: none;}
    .breaking-news-info {background:rgba(212, 105, 6, 0.1);padding: 1em;}
</style>
<form action='options.php' method='post' style="background-color: #fff;padding: 1em 2em;margin: 20px 20px 20px 0; box-shadow: 0 0 1px #000;">
<h1>Breaking News</h1>
<?php
    settings_fields( 'pluginBreakingNews' );
    do_settings_sections( 'pluginBreakingNews' );
    submit_button();
?>
</form>
<?php
} 
?>