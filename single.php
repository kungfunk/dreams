<?php get_header(); ?>

<div class="site__content">
    <main class="entry-single">
        <?php while (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('article'); ?>>
                <header class="article__header">
                    <h3 class="article__subtitle"><?php the_subtitle(); ?></h3>
                    <h1 class="article__title"><?php the_title(); ?></h1>
                </header>
                <?php if(has_video()): ?>
                    <div class="article__video-container">
                        <div class="article__video"><?php the_video(); ?></div>
                    </div>
                <?php endif; ?>
                <div class="article__meta">
                    <div class="article__date"><?php echo get_the_date(); ?></div>
                    <div class="article__tags"><?php the_tags('#', ', #', ''); ?></div>
                    <div class="article__comments-count"><?php comments_number(0,1,'%'); ?></div>
                </div>
                <div class="article__content">
                    <?php the_content(); ?>
                </div>
            </article>
            <div class="author-bio">
                <img width="82" height="82" class="author-bio__avatar avatar" src="<?php echo esc_url(get_avatar_url($post->post_author, ['size' => 82])); ?>" />
                <div class="author-bio__author">
                    <div class="author-bio__name"><?php the_author(); ?></div>
                    <div class="author-bio__role"><?php echo translate_user_role(get_userdata($post->post_author)->roles[0]); ?></div>
                </div>
                <div class="author-bio__description"><?php the_author_meta('description'); ?></div>
            </div>
	        <?php $related_query = dreams_get_related_from_post(); ?>
            <?php if($related_query && $related_query->have_posts()): ?>
                <ul class="related-entries">
                    <?php while($related_query->have_posts()): $related_query->the_post(); ?>
                        <li class="related-entries__item">
                            <a class="related-entries__thumbnail" href="<? the_permalink(); ?>" title="<?php the_title(); ?>">
                                <?php the_post_thumbnail('related-entries'); ?>
                            </a>
                            <div class="related-entries__category">#<?php echo get_the_category()[0]->name; ?></div>
                            <h3 class="related-entries__title">
                                <a class="related-entries__link" href="<? the_permalink(); ?>">
		                            <?php the_title(); ?>
                                </a>
                            </h3>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
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