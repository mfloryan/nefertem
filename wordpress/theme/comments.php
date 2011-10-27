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

<div id="comments">
<?php if ( post_password_required() ) : ?>
    <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'toolbox' ); ?></p>
</div><!-- #comments -->
<?php
        return;
    endif;
?>

<?php if ( have_comments() ) : ?>
    <h3 id="comments-title">
        <?php
            printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'toolbox' ),
                number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
        ?>
    </h3>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <nav id="comment-nav-above">
        <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'toolbox' ); ?></h1>
        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'toolbox' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'toolbox' ) ); ?></div>
    </nav>
    <?php endif; // check for comment navigation ?>

    <ol class="commentlist">
        <?php
            /* Loop through and list the comments. Tell wp_list_comments()
             * to use toolbox_comment() to format the comments.
             * If you want to overload this in a child theme then you can
             * define toolbox_comment() and that will be used instead.
             * See toolbox_comment() in toolbox/functions.php for more.
             */
            wp_list_comments( array( 'callback' => 'nefertem_comment' ) );
        ?>
    </ol>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <nav id="comment-nav-below">
        <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'toolbox' ); ?></h1>
        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'toolbox' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'toolbox' ) ); ?></div>
    </nav>
    <?php endif; // check for comment navigation ?>

<?php endif; ?>

<?php comment_form(); ?>

</div>