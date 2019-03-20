<?php get_header(); ?>

<div class="category__container">
    <div class="category__header">
        <div class="category__subtitle">Resultados de</div>
        <h1 class="category__title">"<?php the_search_query(); ?>"</h1>
    </div>
</div>

<div class="site__front-page">
    <div class="front-page">
        <main class="front-page__left front-page__block front-page__category">
            <?php include 'partials/entry-loop.php' ?>
        </main>
    </div>
</div>
<div class="site__more-link">
    <div class="more-link">
	    <?php echo get_next_posts_link('Ver más resultados ↓'); ?>
    </div>
</div>

<?php get_footer(); ?>
