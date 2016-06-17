<?php

add_action( 'vc_before_init', 'acrod_member_mapper' );

function acrod_member_mapper() {
	vc_map( array(
		'name'				=> 'Acrod: Member',
		'base'				=> 'acrod_member',
		'category'			=> 'Acrod',
		'front_enqueue_js'	=> array( plugin_dir_url( __FILE__ ) . 'js/portfolio.js' ),
		'front_enqueue_css'	=> array( plugin_dir_url( __FILE__ ) . 'css/portfolio.css' ),
		'params'			=> array(
			array(
				'heading'		=> 'Layout Type',
				'type'			=> 'dropdown',
				'param_name'	=> 'type',
				'value'			=> array(
					'With Avatar'	=> 'type1',
					'With Icon'		=> 'type2',
					'With Content'	=> 'type3',
				),
				'admin_label'	=> true
			),
			array(
				'heading'		=> 'Avatar',
				'type'			=> 'attach_image',
				'param_name'	=> 'photo',
				'dependency'	=> array(
					'element'	=> 'type',
					'value'		=> array( 'type1', 'type3' )
				)
			),
			array(
				'heading'		=> 'Content',
				'type'			=> 'textarea_html',
				'param_name'	=> 'content',
				'value'			=> ''
			),
			array(
				'heading'		=> 'Name',
				'type'			=> 'textfield',
				'param_name'	=> 'name',
				'value'			=> '',
				'admin_label'	=> true
			),
			array(
				'heading'		=> 'Position',
				'type'			=> 'textfield',
				'param_name'	=> 'position',
				'value'			=> '',
				'admin_label'	=> true
			),
			array(
				'heading'		=> 'Facebook',
				'type'			=> 'textfield',
				'param_name'	=> 'facebook',
				'value'			=> '',
				'dependency'	=> array(
					'element'	=> 'type',
					'value'		=> 'type3'
				),
				'admin_label'	=> true
			),
			array(
				'heading'		=> 'Twitter',
				'type'			=> 'textfield',
				'param_name'	=> 'twitter',
				'value'			=> '',
				'dependency'	=> array(
					'element'	=> 'type',
					'value'		=> 'type3'
				),
				'admin_label'	=> true
			),
			array(
				'heading'		=> 'Linkedin',
				'type'			=> 'textfield',
				'param_name'	=> 'linkedin',
				'value'			=> '',
				'dependency'	=> array(
					'element'	=> 'type',
					'value'		=> 'type3'
				),
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

function acrod_member_shortcode( $atts, $content ) {

	$atts = shortcode_atts( array(
		'type'			=> 'type1',
		'photo'			=> '',
		'name'			=> '',
		'position'		=> '',
		'facebook'		=> '',
		'twitter'		=> '',
		'linkedin'		=> '',
		'extra_class'	=> ''
	), $atts );

	extract( $atts );

	$photo = wp_get_attachment_image_src( $photo, 'acrod-related-post' );

	ob_start(); ?>

	<div class="member-shortcode <?php echo esc_attr( 'member-' . $type . ' ' . $extra_class ); ?>">

		<?php if ( $type == 'type1' ) : ?>

			<div class="avatar">
				<img src="<?php echo esc_url( wp_get_attachment_image_src( $photo, array( 80, 80 ) )[0] ); ?>" />
			</div>

			<div class="member-content">
				<h6><?php echo esc_html( $name ); ?></h6>
				<span><?php echo esc_html( $position ); ?></span>
				<div class="line-dec"></div>
				<p><?php echo do_shortcode( $content ); ?></p>
			</div>

		<?php elseif ( $type == 'type2' ) : ?>

			<div class="icon">
				<i class="fa fa-quote-left"></i>
			</div>

			<div class="member-content">
				<p><?php echo do_shortcode( $content ); ?></p>
				<div class="line-dec"></div>
				<h6><?php echo esc_html( $name ); ?></h6>
				<span><?php echo esc_html( $position ); ?></span>
			</div>

		<?php else : ?>

			<div class="avatar">
				<img src="<?php echo esc_url( wp_get_attachment_image_src( $photo, 'acrod-related-post' )[0] ); ?>" />
				<div class="member-content">
				<p><?php echo do_shortcode( $content ); ?></p>
					<ul>
						<li><a href="<?php echo esc_url( $facebook ); ?>"><i class="fa fa-facebook"></i></a></li>
						<li><a href="<?php echo esc_url( $twitter ); ?>"><i class="fa fa-twitter"></i></a></li>
						<li><a href="<?php echo esc_url( $linkedin ); ?>"><i class="fa fa-linkedin"></i></a></li>
					</ul>
				</div>
			</div>

			<div class="down-content">
				<h3><?php echo esc_html( $name ); ?></h3>
				<span><?php echo esc_html( $position ); ?></span>
			</div>

		<?php endif; ?>

	</div>

<?php
	return ob_get_clean();
}

add_shortcode( 'acrod_member', 'acrod_member_shortcode' );