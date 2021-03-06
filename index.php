<?php get_header(); ?>

<div class="site__front-page">
    <div class="front-page">
        <main class="front-page__left front-page__block front-page__block--news">
	        <?php include 'partials/entry-loop.php' ?>
        </main>
        <div class="front-page__right">
            <aside class="front-page__block front-page__block--podcasts">
                <?php $podcast_query = new WP_Query(['posts_per_page' => 1, 'category_name' => PODCAST_SLUG]) ?>
                <?php if ($podcast_query->have_posts()): while ($podcast_query->have_posts()): $podcast_query->the_post(); ?>
                    <div class="mini-entry mini-entry--podcast">
                        <div class="mini-entry__thumbnail mini-entry__thumbnail--podcast">
                            <?php the_post_thumbnail('mini-entry') ?>
                        </div>
                        <div class="mini-entry__text">
                            <h2 class="mini-entry__title">
                                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            </h2>
                        </div>
                        <div class="mini-entry__audio">
                            <div class="audio-player">
                                <?php the_podcast() ?>
                                <div class="audio-player__panel">
                                    <button class="play audio-player__button"><?php include "img/play.svg"; ?></button>
                                    <button class="pause audio-player__button" disabled><?php include "img/pause.svg"; ?></button>
                                </div>
                                <div class="timeline audio-player__bar">
                                    <div class="progress audio-player__progress"></div>
                                </div>
                            </div>
                        </div>
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
