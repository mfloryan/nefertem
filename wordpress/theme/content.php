<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


    <div class="header"><h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
    </div>
    <div class="info"> <?php the_date('D j F Y') ?> | <?php the_tags() ?> </div>

    <?php the_content(); ?>

</article>
