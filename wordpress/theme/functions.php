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
    add_settings_field('google-profile',
                       'Google Profile URL',
                       'nefertem_setting_string',
                       'nefertem',
                       'nefertem-options-section',
                       array('id' => "google-profile"));

    add_settings_field('metro-link-1', 'Link for Metro 1', 'nefertem_setting_page', 'nefertem', 'nefertem-options-section', array('id' => "metro-link-1"));

    add_settings_field('metro-snip-1', 'Snippet for Metro 1', 'nefertem_setting_textarea', 'nefertem', 'nefertem-options-section', array('id' => "metro-snip-1"));
    add_settings_field('metro-link-2', 'Link for Metro 2 (Blog)', 'nefertem_setting_page', 'nefertem', 'nefertem-options-section', array('id' => "metro-link-2"));
    add_settings_field('metro-link-3', 'Link for Metro 3', 'nefertem_setting_page', 'nefertem', 'nefertem-options-section', array('id' => "metro-link-3"));
    add_settings_field('metro-snip-3', 'Snippet for Metro 3', 'nefertem_setting_textarea', 'nefertem', 'nefertem-options-section', array('id' => "metro-snip-3"));
    add_settings_field('metro-link-4', 'Link for Metro 4', 'nefertem_setting_page', 'nefertem', 'nefertem-options-section', array('id' => "metro-link-4"));
    add_settings_field('metro-snip-4', 'Snippet for Metro 4', 'nefertem_setting_textarea', 'nefertem', 'nefertem-options-section', array('id' => "metro-snip-4"));
}

function nefertem_options_section_text() {
    echo '<p>Configure theme settings</p>';
}

function nefertem_setting_string($args) {
    $id = $args['id'];
    $options = get_option('nefertem-options');
    echo "<input id='$id' name='nefertem-options[{$id}]' size='40' type='text' value='{$options[$id]}' />";
}

function nefertem_setting_textarea($args) {
    $id = $args['id'];
    $options = get_option('nefertem-options');
    echo "<textarea rows=\"4\" cols=\"40\" id='$id' name='nefertem-options[{$id}]'>{$options[$id]}</textarea>";
}

function nefertem_setting_page($args) {
    $id = $args['id'];
    $options = get_option('nefertem-options');

    echo "<select name=\"nefertem-options[{$id}]\" id=\"$id\">";
    echo '<option value=""></option>';
    $pages = get_pages();
    foreach ($pages as $page) {
        $link = get_page_link( $page->ID );
        echo '<option value="' . $link .'"';
        if ($options[$id] == $link) {
            echo ' selected="selected"';
        }
        echo '>';
        echo "{$page->post_title} ({$page->ID})";
        echo '</option>';
    }
    echo '</select>';

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

function nefertem_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

    if ($comment->comment_type == 'pingback' || $comment->comment_type == 'trackback') {
?>
        <li class="post pingback">
            <p><?php _e( 'Pingback:', 'toolbox' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'toolbox' ), ' ' ); ?></p>
<?php
    } else {
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'toolbox' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'toolbox' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'toolbox' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'toolbox' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
    }
}

?>