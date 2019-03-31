<?php
/*
 * Template Name: Ancho maximo
 * Template Post Type: post
 */
?>

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
		</main>
	</div>
<?php if (comments_open() || get_comments_number()): ?>
	<div class="site__comments">
		<?php comments_template(); ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>