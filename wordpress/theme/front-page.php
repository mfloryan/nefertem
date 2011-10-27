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

<div class="grid_8">
    <nav class="metro">
        <div class="grid_4 alpha">
            <a class="metro" href="marcin.html">
                <section>
                    <h2>Marcin</h2>
                    <img src="images/marcin-85px.png" class="marcin100" alt="Marcin Floryan"/>
                    Suspendisse potenti. Nunc felis magna, consequat ut venenatis eu, consequat vitae ante. Donec
                    lobortis facilisis metus, at tincidunt mauris sodales at.
                </section>
            </a>
        </div>
        <div class="grid_4 omega">
                <section>
                    <a class="metro" href="blog.html">
                    <h2>Blog</h2>
                    </a>
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
<!--        <div class="clear spacer"></div>-->
<!--        <div class="grid_4 alpha">-->
<!--            <section>-->
<!--                <h2>Reading</h2>-->
<!--                Suspendisse potenti. Nunc felis magna, consequat ut venenatis eu, consequat vitae ante. Donec lobortis-->
<!--                facilisis metus, at tincidunt mauris sodales at.-->
<!--            </section>-->
<!--        </div>-->
<!--        <div class="grid_4 omega">-->
<!--            <section>-->
<!--                <h2>Quotes</h2>-->
<!--                Suspendisse potenti. Nunc felis magna, consequat ut venenatis eu, consequat vitae ante. Donec lobortis-->
<!--                facilisis-->
<!--                metus, at tincidunt mauris sodales at.-->
<!--            </section>-->
<!--        </div>-->
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