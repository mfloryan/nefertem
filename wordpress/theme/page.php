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

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						get_template_part( 'content','page');
					?>
				<?php endwhile; ?>
        </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>