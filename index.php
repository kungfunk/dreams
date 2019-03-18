<?php get_header(); ?>

<div class="site__front-page">
    <div class="front-page">
        <main class="front-page__left front-page__block front-page__block--news">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <article class="entry" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry__thumbnail">
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                    <div class="entry__container">
                        <div class="entry_comments-count">
                            <?php comments_number(0,1,'%'); ?>
                        </div>
                        <header class="entry__header">
                            <h3 class="entry__subtitle"><?php the_subtitle(); ?></h3>
                            <h2 class="entry__title">
                                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            </h2>
                        </header>
                        <div class="entry__excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <footer class="entry__footer">
                            <div class="entry__date">
                                <?php echo get_the_date('j F | H:i') ?>
                            </div>
                            <div class="entry__author">
                                <span class="entry__pre-author">por</span>
                                <?php the_author() ?>
                            </div>
                        </footer>
                    </div>
                </article>
            <?php endwhile; endif; ?>
        </main>
        <div class="front-page__right">
            <aside class="front-page__block front-page__block--podcasts">
                <?php $podcast_query = new WP_Query(['posts_per_page' => 1, 'category_name' => PODCAST_SLUG]) ?>
                <?php if ($podcast_query->have_posts()): while ($podcast_query->have_posts()): $podcast_query->the_post(); ?>
                    <div class="mini-entry mini-entry--podcast">
                        <div class="mini-entry__thumbnail">
                            <?php the_post_thumbnail('mini-entry') ?>
                        </div>
                        <div class="mini-entry__text">
                            <h2 class="mini-entry__title">
                                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            </h2>
                        </div>
                        <audio class="mini-entry__audio" controls>
                            <source src="http://www.hochmuth.com/mp3/Tchaikovsky_Nocturne__orch.mp3" type="audio/mpeg">
                        </audio>
                    </div>
                <?php endwhile; endif; ?>
                <?php wp_reset_postdata(); ?>
                <a class="mini-entry__more-link" href="<?php echo get_category_link(get_category_by_slug(PODCAST_SLUG)); ?>">
                    Ver más episodios →
                </a>
            </aside>

            <aside class="front-page__block front-page__block--reviews">
	            <?php $podcast_query = new WP_Query(['posts_per_page' => 5, 'category_name' => REVIEW_SLUG]) ?>
	            <?php if ($podcast_query->have_posts()): while ($podcast_query->have_posts()): $podcast_query->the_post(); ?>
                    <div class="mini-entry">
                        <div class="mini-entry__thumbnail">
				            <?php the_post_thumbnail('mini-entry') ?>
                        </div>
                        <div class="mini-entry__text">
                            <h3 class="mini-entry__subtitle"><?php the_subtitle(); ?></h3>
                            <h2 class="mini-entry__title">
                                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            </h2>
                        </div>
                    </div>
	            <?php endwhile; endif; ?>
	            <?php wp_reset_postdata(); ?>
                <a class="mini-entry__more-link" href="<?php echo get_category_link(get_category_by_slug(REVIEW_SLUG)); ?>">
                    Ver más análisis →
                </a>
            </aside>
        </div>
    </div>
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
                        <div class="book__year"><?php echo get_the_date('Y') ?></div>
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
