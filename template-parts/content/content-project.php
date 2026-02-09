<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
	</header>
	<div class="entry-content">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-thumbnail">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
			</div>
		<?php endif; ?>
		<p><?php echo wp_trim_words( get_the_excerpt(), 24, '…' ); ?></p>
	</div>
</article>
