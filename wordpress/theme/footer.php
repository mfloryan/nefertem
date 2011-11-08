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
</div> <!-- container_12 -->
</div> <!-- page_container -->

<div class="container_12">
    <div class="grid_12">
        <footer id="page-footer">
            Copyright &copy;
<?php
    $options = get_option('nefertem-options');
    global $wpdb;
    $post_datetimes = $wpdb->get_row($wpdb->prepare("SELECT YEAR(min(post_date_gmt)) AS firstyear, YEAR(max(post_date_gmt)) AS lastyear FROM $wpdb->posts WHERE post_date_gmt > 1970"));
    if ($post_datetimes) {
        $firstpost_year = $post_datetimes->firstyear;
        $lastpost_year = $post_datetimes->lastyear;

        $copyright = $firstpost_year;
        if($firstpost_year != $lastpost_year) {
            $copyright .= ' &ndash; '. $lastpost_year;
        }
        echo $copyright;
    }
?>
 <b><a href="<?php echo $options['google-profile'];?>" rel="author"><?php bloginfo('name'); ?></a></b>
            licensed under <a rel="license" href="license.html"><img alt="Creative Commons Licence" class="cc-logo" src="http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png"></a>
            | Powered by <a href="http://wordpress.org/" rel="generator" title="Semantic Personal Publishing Platform">WordPress</a>
            | <a href="https://github.com/mfloryan/nefertem">nefertem</a> theme based on <a href="http://960.gs/">960.gs grid</a> using <a href="http://font.ubuntu.com/" rel="font">Ubuntu</a> font
        </footer>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>