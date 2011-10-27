<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="header"><h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2></div>
    <br />
    <?php the_content(); ?>

    <div class="info"> Last updated: <?php the_modified_date('D j F Y H:m') ?> </div>
</article>