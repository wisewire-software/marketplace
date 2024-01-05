<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title('<h3 class="title-bg">', '</h3>'); ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        the_post_thumbnail();
        the_content();
        get_template_part('template-parts/content', 'postmeta');
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->
