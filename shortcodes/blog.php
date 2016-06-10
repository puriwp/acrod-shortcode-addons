<?php

add_action( 'vc_before_init', 'acrod_blog_mapper' );

function acrod_blog_mapper() {
	vc_map( array(
		'name'				=> 'Acrod: Blog',
		'base'				=> 'acrod_blog',
		'category'			=> 'Acrod',
		'front_enqueue_js'	=> array( plugin_dir_url( __FILE__ ) . 'js/equal-height.js' ),
		'front_enqueue_css'	=> array( plugin_dir_url( __FILE__ ) . 'css/shortcode.css' ),
		'params'			=> array(
			array(
				'heading'		=> 'Item Show',
				'type'			=> 'textfield',
				'param_name'	=> 'item_show',
				'value'			=> '10',
				'description'	=> 'Insert number you want to show.',
				'admin_label'	=> true
			),
			array(
				'heading'		=> 'Extra Class',
				'type'			=> 'textfield',
				'param_name'	=> 'extra_class',
				'value'			=> '',
				'description'	=> 'Style particular content element differently - add a class name and refer to it in custom CSS.'
			)
		)
	) );
}

function acrod_blog_shortcode( $atts, $content ) {

	$atts = shortcode_atts( array(
		'item_show'			=> '10',
		'extra_class'		=> ''
	), $atts );

	extract( $atts );

	ob_start();

	$blog = new WP_Query( array(
		'post_type'				=> 'post',
		'posts_per_page'		=> $item_show,
		'ignore_sticky_posts'	=> true,
	) );

	$video			= fw_get_db_post_option( get_the_id(), 'video_url' );
	$gallery		= fw_get_db_post_option( get_the_id(), 'post_gallery' );
	$category_meta	= fw_get_db_settings_option( 'blog_cats' );

	if ( $blog->have_posts() ) : ?>

		<div class="blog-shortcode <?php echo esc_attr( $extra_class ); ?>">

			<?php while ( $blog->have_posts() ) : $blog->the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'vc_col-sm-4' ); ?>>

						<?php if ( get_post_format() == 'video' ) : ?>
							<div class="post-image" style="height:auto;">
								<?php echo do_shortcode( '[video src="' . esc_url( $video ) . '"]' ); ?>
							</div>
						<?php elseif ( get_post_format() == 'gallery' ) : ?>
							<div id="carousel-portfolio" class="carousel slide">
								<div class="carousel-inner" role="listbox">
									<?php foreach ( $gallery as $gal ) : ?>
										<div class="item">
											<img src="<?php echo esc_url( $gal['url'] ); ?>" />
										</div>
									<?php endforeach; ?>
									<!-- Controls -->
									<a class="left carousel-control" href="#carousel-portfolio" role="button" data-slide="prev">
										<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
										<span class="sr-only">Previous</span>
									</a>
									<a class="right carousel-control" href="#carousel-portfolio" role="button" data-slide="next">
										<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
										<span class="sr-only">Next</span>
									</a>

								</div>
							</div>
						<?php else: ?>
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="post-image" style="height:auto;">
									<?php the_post_thumbnail( 'acrod-post-page' ); ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<header class="entry-header">
							<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_the_permalink() ) . '">', '</a></h4>' ); ?>
						</header><!-- .entry-header -->

						<div class="post-meta">

							<div class="post-date">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>">
									<?php the_date( get_option( 'date_format' ) ); ?>
								</a>
							</div>
							<?php if ( $category_meta == true ) : ?>
								<div class="post-category">
									<?php the_category( ', ' ); ?>
								</div>
							<?php endif; ?>

						</div>

						<div class="line-dec"></div>

						<div class="post-inner">

							<?php the_excerpt(); ?>

						</div>

						<div class="clear"></div>

					</article>

				<?php wp_reset_query();

			endwhile; ?>

			<div class="clear"></div>

		</div>

	<?php endif;

	return ob_get_clean();
}

add_shortcode( 'acrod_blog', 'acrod_blog_shortcode' );