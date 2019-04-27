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
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
			</header>
			<div class="entry__excerpt">
				<?php the_excerpt(); ?>
			</div>
			<footer class="entry__footer">
				<div class="entry__date">
					<?php echo get_the_date(); ?>
				</div>
				<div class="entry__author">
					<span class="entry__pre-author">por</span>
					<?php the_author(); ?>
				</div>
			</footer>
		</div>
	</article>
<?php endwhile; endif; ?>