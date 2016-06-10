jQuery( document ).ready( function( $ ) {

	$( '.slider-shortcode' ).each( function() {
		var $id_slider	= $( this ).attr( 'id' ),
			$id_slider	= '#'+ $id_slider,
			item		= $( this ).attr( 'data-acrod-items' ),
			pagination	= Boolean( $( this ).attr( 'data-acrod-pagination' ) ),
			auto_play	= Boolean( $( this ).attr( 'data-acrod-auto-play' ) );

		$( $id_slider ).owlCarousel( {
			rtl: $( 'body' ).hasClass( 'rtl' ) ? true : false,
			paginationSpeed : 600,
			loop: true,
			responsive: {
				0:{
					items: 1
				},
				600:{
					items: 2
				},
				1000:{
					items: 2
				},
				1200:{
					items: item
				}
			},
			dots: pagination,
			autoplay: auto_play,
			autoHeight: true,
		} );

	} );

} );