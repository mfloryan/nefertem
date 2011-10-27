<?php
/*
    nefertem - A WordPress template

    Copyright (C) 2011 Marcin Floryan, mmsquare limited, http://www.mmsquare.com/

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    For the full license see the LICENSE file.
 */

?>


<?php
if (function_exists('register_sidebar')) {
    register_sidebar(array(
                          'id' => 'nefertem-sidebar',
                          'name' => 'Regular Sidebar',
                          'description' => 'Widgets on most pages',
                          'before_widget' => '<section>',
                          'after_widget' => '</section>',
                          'before_title' => '<h3>',
                          'after_title' => '</h3>',
                     ));
    register_sidebar(array(
                          'id' => 'nefertem-metro-sidebar',
                          'name' => 'Metro Sidebar',
                          'description' => 'Widgets on the home page',
                          'before_widget' => '<section>',
                          'after_widget' => '</section>',
                          'before_title' => '<h3>',
                          'after_title' => '</h3>',
                     ));
    register_sidebar(array(
                          'id' => 'nefertem-metro-nav',
                          'name' => 'Metro Navigation',
                          'description' => 'Widgets for navigation on the home page',
                          'before_widget' => '<section>',
                          'after_widget' => '</section>',
                          'before_title' => '<h3>',
                          'after_title' => '</h3>',
                     ));
}

function register_my_menus() {
  register_nav_menus(
    array('header-menu' => __( 'Header Menu' ) )
  );
}

function nefertem_theme_admin_menu() {
	add_theme_page('Nefertem Theme Options', 'Nefertem Theme', 'read', 'nefertem-theme-options', 'nefertem_theme_admin_options');
}

function nefertem_theme_admin_options_init() {
    register_setting( 'nefertem-theme', 'nefertem-options' , 'nefertem_options_validate');
    add_settings_section('nefertem-options-section', 'Main Settings', 'nefertem_options_section_text', 'nefertem');
    add_settings_field('google-profile', 'Google Profile URL', 'nefertem_setting_string', 'nefertem', 'nefertem-options-section');
}

function nefertem_options_section_text() {
    echo '<p>Configure custom plugin settings</p>';
}

function nefertem_setting_string() {
    $options = get_option('nefertem-options');
    echo "<input id='google-profile' name='nefertem-options[google-profile]' size='40' type='text' value='{$options['google-profile']}' />";
}

function nefertem_options_validate($input) {
    return $input;
}


function nefertem_theme_admin_options() {
?>
    <div>
    <h2>Nefertem Theme Options</h2>
    Options to tweak for the Nefertem Theme.
    <form action="options.php" method="post">
    <?php settings_fields('nefertem-theme'); ?>
    <?php do_settings_sections('nefertem'); ?>
    <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form></div>
<?php
}

add_action( 'init', 'register_my_menus' );
add_action('admin_menu', 'nefertem_theme_admin_menu');
add_action('admin_init', 'nefertem_theme_admin_options_init');


?>
