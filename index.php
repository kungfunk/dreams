<?php get_header(); ?>

<div class="site__entry-list">
    <main class="entry-list">
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <article class="entry" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry__thumbnail">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </div>
                <?php comments_number(0,1,'%'); ?>
                <header class="entry__header">
                    <h3 class="entry__subtitle"><?php the_subtitle(); ?></h3>
                    <h2 class="entry__title">
                        <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                    </h2>
                </header>
                <div class="entry__content">
                    <?php the_excerpt(); ?>
                </div>
                <footer class="entry__footer">
                    <?php the_author() ?>
                    <?php the_date() ?>
                </footer>
            </article>
        <?php endwhile; endif; ?>
    </main>
</div>
<div class="site__more-link">
    <div class="more-link">
	    <?php echo get_next_posts_link('Ver más noticias ↓'); ?>
    </div>
</div>
<div class="site__editorial">
    <div class="editorial">
        <div class="editorial__container">
            <div class="editorial__info">
                <h3 class="editorial__title">También nos molan los libros.</h3>
                <p class="editorial__description">
                    Tenemos un proyecto editorial paralelo donde contamos historias, recordamos lo mejor de esta página
                    o dedicamos monográficos a sagas míticas, siempre desde el respeto y el diálogo.
                </p>
                <div class="editorial__more-link">
                    <div class="more-link">
                        <a href="<?php echo get_category_link(get_category_by_slug(EDITORIAL_SLUG)); ?>">
                            Ver más publicaciones →
                        </a>
                    </div>
                </div>
            </div>
            <ul class="editorial__book-list">
		        <?php $book_query = new WP_Query(['posts_per_page' => 5, 'category_name' => EDITORIAL_SLUG]) ?>
		        <?php if ($book_query->have_posts()): while ($book_query->have_posts()): $book_query->the_post(); ?>
                    <li class="book">
                        <div class="book__thumbnail">
					        <?php the_post_thumbnail('book-cover') ?>
                        </div>
                        <div class="book__year"><?php dreams_the_year(); ?></div>
                        <h2 class="book__title">
                            <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                        </h2>
                    </li>
		        <?php endwhile; endif; ?>
		        <?php wp_reset_postdata(); ?>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); ?>
