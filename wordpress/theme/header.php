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

<?php get_template_part("head") ?>

<body <?php body_class('page'); ?>>
<div class="page_container">

<div class="container_12">
        <div class="clear spacer"></div>
        <header class="grid_12">
            <div class="alpha grid_4">
                <a href="<?php echo get_home_url(); ?>" class="header"><h1 class="pad10"><?php bloginfo( 'name' ); ?></h1></a>
            </div>
            <div class="grid_4">
                <div id="tagline" class="pad10"><?php bloginfo( 'description' ); ?></div>
            </div>
            <div class="omega grid_4">
                <a href="<?php echo get_bloginfo('rss2_url'); ?>http://rrs.com" class="rss" title="rss feed"></a>
            </div>
        </header>
        <div class="clear spacer2"></div>
        <div class="grid_12 yellow">
            <div class="grid_8 alpha">
                <nav class="topbar">
                    <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>

<!--                    <ul>-->
<!--                        <li><a href="">Home</a></li>-->
<!--                        <li><a href="">Marcin</a></li>-->
<!--                        <li><a href="">Blog</a></li>-->
<!--                        <li><a href="">Reading</a></li>-->
<!--                        <li><a href="">Quotes</a></li>-->
<!--                    </ul>-->
                </nav>
            </div>
            <div class="grid_4 right omega">
                <input type="text" class="search"/>
            </div>
        </div>