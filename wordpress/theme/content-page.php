<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="header"><h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2></div>
    <br />
    <?php the_content(); ?>

    <div class="info"> Last updated: <time datetime="<?php the_date('Y-m-d') ?>"><?php the_modified_date('D j F Y H:m') ?></time></div>

</article>