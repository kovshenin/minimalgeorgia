<?php
/**
 * Search Template
 *
 * Search results titles are a little smaller in size and
 * excerpts are output instead of content.
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @version 1.4
 */

get_header(); ?>
		<div class="grid_6 posts-list">
			<div class="grid_1 alpha right-arrow-container">
				&nbsp;
			</div>
			<div class="grid_5 omega">
				<h1 class="search-title"><?php printf(__('Search Results for: %s', 'minimalgeorgia' ), '<span>' . get_search_query() . '</span>'); ?></h1>
			</div>
			<div class="clear"></div>
			<?php while (have_posts()): the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="grid_1 alpha right-arrow-container">
					<span class="right-arrow">&nbsp;</span>
					<p class="date"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'minimalgeorgia'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_time('F j, Y'); ?></a></p>
					<p class="comments-count"><?php comments_popup_link('0','1','%'); ?></p>
				</div>
				<div class="grid_5 omega content-container">
					<?php if (get_the_title()): ?>
					<h2 class="search-results post-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'minimalgeorgia'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<?php endif; ?>
					<div class="post-content <?php if (!get_the_title()) echo 'no-title'; ?>">
						<?php /* Output an empty paragraph if there's no excerpt */ if (!get_the_excerpt()) { echo '<p>&nbsp;</p>'; } ?>
						<?php the_excerpt(__('Continue reading <span class="meta-nav">&rarr;</span>', 'minimalgeorgia')); ?>
					</div>
				</div>
			</div>
			<?php endwhile; ?>
			
			<div class="pagination">
				<div class="grid_1 alpha">
					&nbsp;
				</div>
				<div class="grid_5 omega">
					<?php if ($wp_query->max_num_pages > 1): ?>
						<div class="left"><?php next_posts_link(__('&larr; Older posts', 'minimalgeorgia')); ?></div>
						<div class="right"><?php previous_posts_link(__('Newer posts &rarr;', 'minimalgeorgia')); ?></div>
					<?php endif; ?>
				</div>
			</div>

		</div>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>
