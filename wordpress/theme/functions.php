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
?>
