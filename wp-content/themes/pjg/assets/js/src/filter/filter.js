/**
* Portland Japanese Garden
* http://japanesegarden.com
*
* Copyright (c) 2017 Jesse Keyes
*/

// Ajax functions to load posts dynamically and be filtered, also lazy loading



// var button = jQuery( '.load-more' );
var pagination = jQuery( '.pagination' );
var filter = jQuery( '#filter' );
var wrapper = jQuery( '.wrapper-posts' );
var postType = JSON.parse( wpURLs.query_vars );

var morePrompt = ( postType.post_type == 'event' ) ? 'Events' : 'Stories';
var button = '<div class="load-more"><hr class="rule-loading" /><a href="#" class="button load-more-action">Load More ' + morePrompt + '</a><hr class="rule-loading" /></div>';

// grab from DOM cuz sets up no JS default if we care? or loaded via URL /page/2/ etc? fall back to 2 set here.
var page = 2;

var loading = false; // helps prevent double clicks etc.

var lastpage = ( jQuery( '.is_lastpage' ).length > 0 ) ? jQuery( '.is_lastpage' ).data( 'lastpage' ) : 1;

// console.log( lastpage );

// masonry object

var masonryOptions = {

	itemSelector: '.item',
	gutter: '.gutter-sizer',
	transitionPropery: 'opacity',
	hiddenStyle: { opacity: 0 },
	visibleStyle: { opacity: 1 },
	transitionDuration: 0

}

var $wrapper = wrapper.masonry( masonryOptions );

if( !jQuery( '#start_date' ).val() && !jQuery( '#end_date' ).val() && !jQuery( '#filter #month_date' ).val() && !jQuery( '#filter #cat' ).val() ) {

  jQuery( '#filter input[type="reset"]' ).addClass( 'disabled' );

} else {

  jQuery( '#filter input[type="reset"]' ).removeClass( 'disabled' );

}



// check if last page (on load)

if( !lastpage ) {

	pagination.show();
	pagination.append( button ); // so we can control it.

}


// action load more
pagination.on( 'click', jQuery( 'load-more-action' ) , function( event ) {

	event.preventDefault();

	lazyload();


});

function lazyload( ) {

	if( !loading ) {

		loading = true;


		jQuery.ajax({
			url: wpURLs.ajaxurl,
			type: 'post',
			data: {
				action: 'ajax_filter',
	      query_vars: filter.serialize(), // has current page no. from function
				page: page,
			},
	    beforeSend: function() {


				jQuery( '.load-more' ).addClass( 'lazy-hide' );
				jQuery( '.loader' ).removeClass( 'lazy-hide' );
				jQuery( '.wrapper-posts .is_lastpage' ).remove();

	  	},
	  	success: function( html ) {

	  		jQuery('.wrapper-posts #loader').remove();
				$wrapper.append( html );

				$wrapper.imagesLoaded( function() {

					$wrapper.masonry('reloadItems').masonry('layout');

				})

				setTimeout( function() {

					jQuery( '.item' ).css( 'opacity', '1' );

				}, 300 );

				page = page + 1;
				loading = false;

				lastpage = jQuery( '.wrapper-posts .is_lastpage' ).data('lastpage');

        // hide load more button, but not loader after initial load
        jQuery( '.load-more-action, .rule-loading' ).addClass( 'cloak' );

				jQuery( '.load-more' ).removeClass( 'lazy-hide' );
				jQuery( '.loader' ).addClass( 'lazy-hide' );

				if( lastpage ) {

          pagination.remove();

        }



			}
		});



	}

}


// action filter
jQuery( '.button-reset' ).on( 'click', function( event ) {

  // manual reset due to hidden field issues
  event.preventDefault();

  jQuery( '#filter #cat, #filter #m, #filter #month_date, #query_end_date, #query_start_date, #end_date, #start_date' ).val(''); // reset manually

  filter.trigger( 'change' );

});


filter.on( 'change', function( event ) {

  filter.addClass( 'loading' );

	if( !wrapper.hasClass( 'not-found' ) ) {

		setTimeout( function() {
			jQuery.ajax({
				url: wpURLs.ajaxurl,
				type: 'post',
				data: {
					action: 'ajax_filter',
		      query_vars: filter.serialize(),
					page: 1, // reset it cuz filter
				},
		    beforeSend: function() {


		  		jQuery('.wrapper-posts').find( '.item' ).remove();
					jQuery( '.wrapper-posts .is_lastpage').remove();
		  		jQuery( document ).scrollTop();
		  		jQuery( '.wrapper-posts' ).append( '<div class="page-content" id="loader"><div class="loader"><div></div><div></div></div></div>' );
		  	},
		  	success: function( html ) {

		  		jQuery('.wrapper-posts #loader').remove();
          filter.removeClass( 'loading' );

          if( !jQuery( '#start_date' ).val() && !jQuery( '#end_date' ).val() && !jQuery( '#filter #month_date' ).val() && !jQuery( '#filter #cat' ).val() ) {

            jQuery( '#filter input[type="reset"]' ).addClass( 'disabled' );

          } else {

            jQuery( '#filter input[type="reset"]' ).removeClass( 'disabled' );

          }


					// $wrapper.append( html ).masonry('reloadItems').masonry('layout');

					$wrapper.append( html ).masonry('reloadItems').masonry('layout');

					jQuery( '.item' ).css( 'opacity', '1' );

					$wrapper.imagesLoaded( function() {

						$wrapper.masonry('reloadItems').masonry('layout');

					})

					page = 2; // reset page back to default


					if( jQuery( '.wrapper-posts .none-found' ).length > 0 ) {

						lastpage = 1;

					} else {

						lastpage = jQuery( '.is_lastpage' ).data( 'lastpage' );


					}

					if( !lastpage ) {

						jQuery( '.pagination' ).show();// add button
            jQuery( '.load-more-action, .rule-loading' ).removeClass( 'cloak' );

						if( jQuery( '.load-more' ).length == 0 ) {

							pagination.append( button );

						}

						jQuery( '.load-more' ).removeClass( 'lazy-hide' );
						jQuery( '.loader' ).addClass( 'lazy-hide' );

					} else {


						jQuery( '.pagination').hide();

					}

					// console.log( 'submit: ', lastpage );

		  	}
			})
		}, 300 );

	} else {

    // need to trigger a submit and page load to reset
    window.location.href = '/?' + filter.serialize();


  }

});




// datepicker set up for events filter

jQuery( '#start_date' ).datepicker({

	dateFormat: 'm/d/yy',
	minDate: 0,
	altField  : '#query_start_date',
  altFormat : 'yy-mm-dd',
  showButtonPanel: true,
  closeText: 'Clear',
  onClose: function (dateText, obj) {
    if ( jQuery(window.event.srcElement).hasClass('ui-datepicker-close') ) {

      jQuery( '#start_date' ).val('');
      jQuery( '#query_start_date' ).val('');
      filter.trigger( 'change' );

    }
  },

});

jQuery( '#end_date' ).datepicker({

	dateFormat: 'm/d/yy',
	minDate: 0,
	altField  : '#query_end_date',
  altFormat : 'yy-mm-dd',
  showButtonPanel: true,
  closeText: 'Clear',
  onClose: function (dateText, obj) {
    if ( jQuery(window.event.srcElement).hasClass('ui-datepicker-close') ) {
      jQuery( '#end_date' ).val('');
      jQuery( '#query_end_date' ).val('');
      filter.trigger( 'change' );

    }
  },

});

// clear out altField dates if reg dates are cleared
jQuery( '#start_date' ).on( 'change', function () {

	if( !jQuery( this ).val() ) {

		jQuery( '#query_start_date' ).val('');

	}

});

jQuery( '#end_date' ).on( 'change', function () {

	if( !jQuery( this ).val() ) {

		jQuery( '#query_end_date' ).val('');

	}

});


// masonry listings init.
jQuery( window ).on( 'load resize orientationchange', function() {

	// show items

	jQuery( '.item' ).css( 'opacity', '1' );

  var $window = jQuery( this );

	if( $window.width() >= 768 ) {

		$wrapper.masonry( masonryOptions );

	} else {

		$wrapper.masonry( 'destroy' );

	}


});

jQuery( '#month_date' ).on( 'change', function() {

	// update hiddent field
	var yearmonth = jQuery( this ).val();


	yearmonth = yearmonth.replace(/\D/g,'');

	jQuery( '#m' ).val( yearmonth );

} )
