<?php

add_action( 'vc_before_init', 'acrod_portfolio_mapper' );

function acrod_portfolio_mapper() {
	vc_map( array(
		'name'				=> 'Acrod: Portfolio',
		'base'				=> 'acrod_portfolio',
		'category'			=> 'Acrod',
		'front_enqueue_js'	=> array( plugin_dir_url( __FILE__ ) . 'js/equal-height.js' ),
		'front_enqueue_css'	=> array( plugin_dir_url( __FILE__ ) . 'css/shortcode.css' ),
		'params'			=> array(
			array(
				'heading'		=> 'Layout',
				'type'			=> 'dropdown',
				'param_name'	=> 'style_layout',
				'value'			=> array(
					'Default'			=> 'normal_content',
					'Overlay Content'	=> 'overlay_content',
				),
				'admin_label'	=> true
			),
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

function acrod_portfolio_shortcode( $atts, $content ) {

	$atts = shortcode_atts( array(
		'item_show'			=> '10',
		'style_layout'		=> 'normal_content',
		'extra_class'		=> ''
	), $atts );

	extract( $atts );

	$portfolio = new WP_Query( array(
		'post_type'			=> 'fw-portfolio',
		'posts_per_page'	=> $item_show
	) );

	if ( $portfolio->have_posts() ) : ?>

		<div class="portfolio-shortcode <?php echo esc_attr( $style_layout . ' ' . $extra_class ); ?>">

			<?php while ( $portfolio->have_posts() ) : $portfolio->the_post();

				if ( $style_layout == 'normal_content' ) : ?>

					<article id="portfolio-<?php the_ID(); ?>" <?php post_class( 'vc_col-sm-4' ); ?>>
						<div class="portfolio-image">
							<?php the_post_thumbnail( 'acrod-fw-portfolio' ); ?>
						</div>
						<div class="portfolio-content">
							<h4 class="entry-title">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>">
									<?php echo wp_trim_words( get_the_title(), 5, ' .. ' ); ?>
								</a>
							</h4>
							<div class="portfolio-category">
								<?php acrod_portfolio_terms(); ?>
							</div>
						</div>
					</article>

				<?php else : ?>

					<article id="portfolio-<?php the_ID(); ?>" <?php post_class( 'vc_col-sm-3' ); ?>>

						<div class="portfolio-item">
							<div class="portfolio-image zoom">
								<div class="portfolio-image">
									<?php the_post_thumbnail( 'acrod-related-post' ); ?>
									<div class="f-hover">
										<div class="f-hover-inner">
											<div class="f-hover-item">
												<div class="fo-fullwidth">
													<div class="f_cat">
														<?php acrod_portfolio_terms(); ?>
													</div>
													<div class="line-dec"></div>
													<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_the_permalink() ) . '">', '</a></h4>' ); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</article>

				<?php endif;

				wp_reset_query();

			endwhile; ?>
			<div class="clear"></div>

		</div>

	<?php endif;
}

add_shortcode( 'acrod_portfolio', 'acrod_portfolio_shortcode' );