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
<?php get_header(); ?>

<div class="clear spacer2"></div>
<div class="grid_8">

    <article>
        <div class="header"><h2>Blog archive</h2></div>

<?php
        $year = 0;
        $allPosts = get_posts(array('numberposts' => -1));
        ?>

        <?php foreach ($allPosts as $post) : ?>
        <?php
            if (get_the_time('Y') != $year) {
                $year = get_the_time('Y');
                echo "<h3>$year</h3>";
        }
        ?>
        <span style="width: 4em; display: inline-block; text-align: right;"><time datetime="<?php the_date('Y-m-d') ?>"><?php the_time('M d:'); ?></time></span> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br />
        <?php endforeach; ?>

    </article>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>