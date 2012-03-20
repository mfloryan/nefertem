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

<?php get_sidebar('narrow'); ?>

        <div class="grid_9">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content');
					?>

				<?php endwhile; ?>

                <?php comments_template( '', true ); ?>


        </div>

        <div class="grid_12">
            <nav id="roll">
                <ul>
                    <li id="prev"><?php previous_post_link('&laquo; %link') ?></li>
                    <li id="next"><?php next_post_link('%link &raquo;') ?></li>
                </ul>
                <br class="clear" />
            </nav>

        </div>

<?php get_footer(); ?>
