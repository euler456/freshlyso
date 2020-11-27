jQuery(document).ready(function() {
	jQuery('.fdm-filtering-text-input').on('keyup', function() {
		fdm_filtering();
	});

	// price textbox filtering
	jQuery('.fdm-filtering-min-price-input, .fdm-filtering-max-price-input').on('keyup', function() {
		fdm_filtering();
	});

	if ( jQuery('.fdm-filtering-min-price-input' ).length ) {
		fdm_initiate_price_boxes();
	}

	//price slider filtering
	if ( jQuery( '#fdm-filtering-price-slider' ).length ) {
		fdm_initiate_price_slider();
	} 

	jQuery('.fdm-filtering-sorting-input').on('change', function() {
		fdm_sorting();
	});
});

function fdm_filtering() {
	
	if ( jQuery( '.fdm-filtering-text-input' ).length ) { 
		var text = jQuery( '.fdm-filtering-text-input' ).val().toLowerCase();
		var search = jQuery( '.fdm-filtering-text-input' ).data( 'search' );
	}
	else {
		var text = '';
		var search = '';
	}

	if ( jQuery('.fdm-filtering-min-price-input').length ) {
		var min_price = jQuery( '.fdm-filtering-min-price-input' ).val();
		var max_price = jQuery( '.fdm-filtering-max-price-input' ).val();
	}
	else if ( jQuery( '#fdm-filtering-price-slider' ).length ) {
		var min_price = jQuery( '#fdm-filtering-price-slider' ).slider( 'values', 0 );
		var max_price = jQuery( '#fdm-filtering-price-slider' ).slider( 'values', 1 );
	}
	else {
		var min_price = 0;
		var max_price = 1000000;
	}

	jQuery('.fdm-item').each(function() {
		var filter = false;

		if ( text != '' && 
			(jQuery(this).find('.fdm-item-title').first().html().toLowerCase().indexOf(text) == -1 || search.indexOf('name') == -1) &&
			(jQuery(this).find('.fdm-item-content').first().html().toLowerCase().indexOf(text) == -1 || search.indexOf('description') == -1) ) {
			filter = true;
		}

		var item_min_price = jQuery(this).find('.fdm-item-price-wrapper').data( 'min_price' );
		var item_max_price = jQuery(this).find('.fdm-item-price-wrapper').data( 'max_price' );
		if ( ( min_price != '' && item_max_price < min_price ) || ( max_price != '' && item_min_price > max_price) ) {
			filter = true;
		}

		if ( filter ) { jQuery(this).addClass('fdm-hidden'); }
		else { jQuery(this).removeClass('fdm-hidden'); }
	});
}

function fdm_initiate_price_slider() {

	jQuery( '.fdm-filtering-min-price-display' ).html( jQuery( '#fdm-pricing-info' ).data( 'min_price' ) );
	jQuery( '.fdm-filtering-max-price-display' ).html( jQuery( '#fdm-pricing-info' ).data( 'max_price' ) );

	jQuery( '#fdm-filtering-price-slider' ).slider({
		range: true,
		min: jQuery( '#fdm-pricing-info' ).data( 'min_price' ),
		max: jQuery( '#fdm-pricing-info' ).data( 'max_price' ),
		values: [ jQuery( '#fdm-pricing-info' ).data( 'min_price' ), jQuery( '#fdm-pricing-info' ).data( 'max_price' ) ],
		slide: function ( event, ui ) {
			jQuery( '.fdm-filtering-min-price-display' ).html( ui.values[ 0 ] );
			jQuery( '.fdm-filtering-max-price-display' ).html( ui.values[ 1 ] );

			//Delay so that the DOM has time to adjust the values
			setTimeout( function() {
				fdm_filtering();
			}, 100);
		}
	});
}

function fdm_initiate_price_boxes() {

	jQuery( '.fdm-filtering-min-price-input' ).val( jQuery( '#fdm-pricing-info' ).data( 'min_price' ) );
	jQuery( '.fdm-filtering-max-price-input' ).val( jQuery( '#fdm-pricing-info' ).data( 'max_price' ) );
}

function fdm_sorting() {
	
	var sort = jQuery('.fdm-filtering-sorting-input').val();

	if ( sort != '' ) {
		jQuery('.fdm-section-header').addClass('fdm-hidden');

		var items = jQuery('li.fdm-item').get();
		items.sort( function( a , b ) {
			if ( sort == 'name_asc' ) {
				var aTitle = jQuery(a).find('.fdm-item-title').first().html().toLowerCase();
				var bTitle = jQuery(b).find('.fdm-item-title').first().html().toLowerCase();

				if ( aTitle < bTitle ) return -1;
				if ( aTitle > bTitle ) return 1;
				return 0;
			}

			if ( sort == 'name_desc' ) {
				var aTitle = jQuery(a).find('.fdm-item-title').first().html().toLowerCase();
				var bTitle = jQuery(b).find('.fdm-item-title').first().html().toLowerCase();

				if ( aTitle < bTitle ) return 1;
				if ( aTitle > bTitle ) return -1;
				return 0;
			}

			if ( sort == 'price_asc' ) {
				var aPrice = parseFloat( jQuery(a).find('.fdm-item-price').first().html().replace(/[^\d\.]+/g,'') );
				var bPrice = parseFloat( jQuery(b).find('.fdm-item-price').first().html().replace(/[^\d\.]+/g,'') );

				if ( aPrice < bPrice ) return -1;
				if ( aPrice > bPrice ) return 1;
				return 0;
			}

			if ( sort == 'price_desc' ) {
				var aPrice = parseFloat( jQuery(a).find('.fdm-item-price').first().html().replace(/[^\d\.]+/g,'') );
				var bPrice = parseFloat( jQuery(b).find('.fdm-item-price').first().html().replace(/[^\d\.]+/g,'') );

				if ( aPrice < bPrice ) return 1;
				if ( aPrice > bPrice ) return -1;
				return 0;
			}

			if ( sort == 'date_asc' ) {
				var aTime = jQuery(a).data('timeadded'); 
				var bTime = jQuery(b).data('timeadded'); 

				if ( aTime < bTime ) return -1;
				if ( aTime > bTime ) return 1;
				return 0;
			}

			if ( sort == 'date_desc' ) {
				var aTime = jQuery(a).data('timeadded'); 
				var bTime = jQuery(b).data('timeadded'); 
				
				if ( aTime < bTime ) return 1;
				if ( aTime > bTime ) return -1;
				return 0;
			}
		});

		jQuery(items).each(function(i, li) {
			jQuery('.fdm-section-0').append(li);
		});
	}
	else {
		jQuery('.fdm-section-header, .fdm-item').removeClass('fdm-hidden');

		jQuery('.fdm-item').each(function() {
			var section = jQuery(this).data('section');

			jQuery('.fdm-sectionid-' + section).append(jQuery(this));
		});
	}
}
