<?php
/**
 *  nefertem - A WordPress template
 *
 *  Copyright (C) 2011 Marcin Floryan, mmsquare limited, http://www.mmsquare.com/
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *   For the full license see the LICENSE file.
 *
 * @package WordPress
 * @subpackage Nefertem
 * @since Nefertem 1.0
 */
?>
<?php get_header('home'); ?>
<?php $options = get_option('nefertem-options'); ?>

<div class="grid_8">
    <nav class="metro">
<?php if ($options['metro-link-1']):?>
        <div class="grid_4 alpha">
                <section onclick="document.location='<?php echo get_page_link($options['metro-link-1']);?>'">
                    <a class="metro" href="<?php echo get_page_link($options['metro-link-1']);?>"><h2>Marcin</h2></a>
                    <?php echo $options['metro-snip-1'] ?>
                </section>
            </a>
        </div>
<?php endif; ?>
<?php if ($options['metro-link-2']):?>
        <div class="grid_4 omega">
                <section onclick="document.location='<?php echo get_page_link($options['metro-link-2']);?>'">
                    <a class="metro" href="<?php echo get_page_link($options['metro-link-2']);?>"><h2>Blog</h2></a>
                    Recent blog posts:
                    <?php
                    {
                        $my_query = new WP_Query(array('posts_per_page'=>5));
                        echo '<ul>';
                    while ( $my_query->have_posts() ) : $my_query->the_post();
                        echo '<li><a href="';
                        the_permalink();
                        echo '">';
                        the_title();
                        echo "</a></li>\n";
                    endwhile;
                        echo "</ul>";
                        wp_reset_postdata();
                    }
                    ?>
                </section>
        </div>
<?php endif; ?>
        <div class="clear spacer"></div>
<?php if ($options['metro-link-3']):?>
        <div class="grid_4 alpha">
            <section onclick="document.location='<?php echo get_page_link($options['metro-link-3']);?>'">
                <a class="metro" href="<?php echo get_page_link($options['metro-link-3']);?>"><h2>Books</h2></a>
                <?php echo $options['metro-snip-3'] ?>
            </section>
        </div>
<?php endif; ?>
<?php if ($options['metro-link-4']):?>
        <div class="grid_4 omega">
            <section onclick="document.location='<?php echo get_page_link($options['metro-link-4']);?>'">
                <a class="metro" href="<?php echo get_page_link($options['metro-link-3']);?>"><h2>Quotes</h2></a>
                <?php echo $options['metro-snip-4'] ?>
            </section>
        </div>
<?php endif; ?>
    </nav>

    <div class="clear spacer"></div>

    <div class="grid_8 alpha omega">

        <?php while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; // end of the loop. ?>

    </div>
</div>

<?php get_sidebar('home'); ?>
<?php get_footer(); ?>