<?php get_template_part("head") ?>
<body <?php body_class(); ?>>
<div class="page_container">
    <div class="container_12">
        <div class="clear spacer"></div>
        <header class="grid_12 metro">
            <div class="alpha grid_8">
                <hgroup>
                    <a href="<?php echo get_home_url(); ?>" class="header"><h1><?php bloginfo('name'); ?></h1></a>

                    <div id="tagline"><?php bloginfo('description'); ?></div>
                </hgroup>
            </div>
            <div class="omega grid_4">
                <a href="<?php echo get_bloginfo('rss2_url'); ?>" class="rss" title="rss feed"></a>
                <label>
                    <input type="text" class="search"/>
                </label>
            </div>
        </header>
        <div class="clear spacer"></div>