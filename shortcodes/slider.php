<?php

/**
 * Owl Carousel
 */
function acrod_slider_shortcode( $atts, $content ) {

	extract( shortcode_atts( array(
		'items'			=> '3',
		'auto_play'		=> false,
		'pagination'	=> false
	), $atts ) );

	$id = 'acrod-slider-' . rand( 0,200 );

	ob_start(); ?>

	<div class="container-slider-sc">
		<div id="<?php echo esc_attr( $id ); ?>" class="owl-carousel slider-shortcode" data-acrod-items="<?php echo esc_attr( $items ); ?>" data-acrod-auto-play="<?php echo esc_attr( $auto_play ); ?>" data-acrod-pagination="<?php echo esc_attr( $pagination ); ?>">
			<?php echo do_shortcode( $content ); ?>
		</div>
	</div>

<?php
	return ob_get_clean();
}
add_shortcode( 'acrod_slider', 'acrod_slider_shortcode' );

/*-----------------------------------------------------------------------------------*/

function acrod_slider_item_shortcode( $atts, $content ) {
    extract( shortcode_atts( array(
    ), $atts ) );

	ob_start(); ?>

    <div><?php echo do_shortcode( $content ); ?></div>

<?php
    return ob_get_clean();
}
add_shortcode( 'acrod_slider_item', 'acrod_slider_item_shortcode' );

add_action( 'vc_before_init', 'acrod_slider_mapper' );

function acrod_slider_mapper() {
	vc_map( array(
		'name'				=> 'Acrod: Carousel',
		'base'				=> 'acrod_slider',
		'as_parent'			=> array( 'only' => 'acrod_slider_item' ),
		'category'			=> 'Acrod',
		'content_element'	=> true,
		'params'			=> array(
			// add params same as with any other content element
			array(
				'type'			=> 'textfield',
				'heading'		=> 'Slide Item',
				'param_name'	=> 'items',
				'description'	=> 'Number of slides you want to display.'
			),
			array(
				'type'			=> 'checkbox',
				'heading'		=> 'Autoplay',
				'param_name'	=> 'auto_play',
				'value'			=> array(
					'Yes' => 'true',
				)
			),
			array(
				'type'			=> 'checkbox',
				'heading'		=> 'Enable Pagination',
				'param_name'	=> 'pagination',
				'value'			=> array(
					'Yes' => 'true',
				)
			),
		),
		'js_view'			=> 'VcColumnView'
	) );

	vc_map( array(
		'name'						=> 'Acrod: Carousel Item',
		'base'						=> 'acrod_slider_item',
		'content_element'			=> true,
		'show_settings_on_create'	=> false,
		'as_child'					=> array( 'only' => 'acrod_slider' ),
		'as_parent'					=> array( 'only' => 'acrod_member, vc_btn, vc_column_text' ),
		'params'					=> array(
			// add params same as with any other content element
			array(
				'type'			=> 'textfield',
				'heading'		=> 'Extra Class',
				'param_name'	=> 'el_class',
				'description'	=> 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.'
			)
		),
		'js_view'					=> 'VcColumnView'
	) );

	//Your 'container' content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Acrod_Slider extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Acrod_Slider_Item extends WPBakeryShortCodesContainer {
		}
	}
}