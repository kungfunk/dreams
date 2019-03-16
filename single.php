<?php get_header(); ?>

<div class="site__content">
    <main class="entry-single">
        <?php while (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('article'); ?>>
                <?php comments_number(0,1,'%'); ?>
                <header class="article__header">
                    <h1 class="article__title"><?php the_title() ?></h1>
                </header>
                <div class="article__content">
                    <?php the_content(); ?>
                </div>
                <footer class="article__footer">
                    <?php the_author() ?>
                    <?php the_date() ?>
                </footer>
            </article>
        <?php endwhile; ?>
        <?php the_posts_navigation(); ?>
        <?php if (comments_open() || get_comments_number()): ?>
            <?php comments_template(); ?>
        <?php endif; ?>
    </main>
</div>

<?php get_footer(); ?>