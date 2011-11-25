<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


    <div class="header"><h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
    </div>
    <div class="info"> <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php the_date('D j F Y'); ?></time> <?php if (get_the_tags()):?> | <?php the_tags(); ?> <?php endif; ?></div>

    <?php the_content(); ?>

</article>

<br style="clear: both;" />