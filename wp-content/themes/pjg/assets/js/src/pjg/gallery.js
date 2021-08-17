


//slick slider to the rescue
var galleryElement = jQuery( '.gallery' );


jQuery( window ).on( 'load resize orientationchange', function () {

  if( jQuery( window ).width() < 420 ) {

    // console.log( jQuery( window ).width() );

    jQuery( '.gallery, .alignnone, .video, [class^="embed-"], [class*=" embed-"]' ).css( 'width', jQuery( window ).width() - 18 );
    jQuery( '.gallery, .alignnone, .video, [class^="embed-"], [class*=" embed-"]' ).css( 'max-width', 'none' );


  } else {

    //remove so it doesn't mess other css at bigger breakpoints

    jQuery( '.gallery, .alignnone, .video' ).css( 'max-width', '' );

  }

});

galleryElement.each( function( key, item ) {

  var sliderIdName = 'gallery-' + key;

  this.id = sliderIdName;

  var sliderId = '#' + sliderIdName;
  var sliderIdObj = jQuery( sliderId );

  var galleryFM = ( sliderIdObj.hasClass( 'gallery-fm' ) ) ? true : false;

  var mobileGalleryNav = ( galleryFM && jQuery( window ).width() < 420 ) ? true : false;

  var galleryElement = sliderIdObj.find('.gallery');

  var navElement = ( !mobileGalleryNav ) ? sliderId + ' .gallery-nav' : sliderId + ' ~ .gallery-mobile .gallery-nav';
  var galleryIndex = ( !mobileGalleryNav ) ? sliderIdObj.find('.gallery-index') : sliderIdObj.next().find('.gallery-index');
  var galleryNav = ( !mobileGalleryNav ) ? sliderIdObj.find( '.gallery-nav' ) : sliderIdObj.next().find( '.gallery-nav' );
  var galleryCaption = ( !mobileGalleryNav ) ? sliderIdObj.find( '.gallery-caption' ) : sliderIdObj.next().find( '.gallery-caption' );


  sliderIdObj.on( 'init reInit afterChange', function( event, slick, currentSlide, nextSlide ){
    //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)

    var i = (currentSlide ? currentSlide : 0) + 1;

    // currentSlide prob above, so grab first one and place it.
    var currentSlideObj = ( currentSlide ) ? jQuery( slick.$slides[currentSlide] ) : jQuery( slick.$slides[0] );
    var captionSlide = ( currentSlideObj.data('caption') ) ? currentSlideObj.data('caption') : '';
    // captionSlide = jQuery('<div/>').text(captionSlide).html();
    var photoSource = currentSlideObj.find('img').attr( 'src' );

    galleryIndex.html( 'Photo: ' + '<span>' + i + ' <em>of</em> ' + slick.slideCount+ '</span> / <a href="' + sliderId + '" class="fullscreen">View Fullscreen</a>' );


    galleryCaption.html( captionSlide );

    if( galleryFM ) {

      var captionHeight = jQuery( '.title-wrapper .gallery-caption' ).height();
      var nudge = ( jQuery( window ).width() > 420 && jQuery( window ).width() < 769 ) ? 36 : 21;

      if( captionHeight >= 44 ) {

        titleAdjust = 150 + captionHeight - nudge;

        jQuery( '.title-wrapper' ).css( 'bottom', titleAdjust );

      } else {

        jQuery( '.title-wrapper' ).css( 'bottom', '150px' );

      }

    }

  });

  if( galleryFM ) {

    sliderIdObj.on( 'beforeChange', function( event, slick, currentSlide, nextSlide ){

      if( !currentSlide ) {

        jQuery( '.page .titles' ).addClass( 'fade' );
        jQuery( '.gallery-nav' ).addClass( 'fade' );

        setTimeout( function() {

          jQuery( '.page .titles' ).hide();

        });

      }

    });

    sliderIdObj.on( 'afterChange', function( event, slick, currentSlide, nextSlide ){

      var captionHeight = jQuery( '.title-wrapper .gallery-caption' ).height();
      var nudge = ( jQuery( window ).width() > 420 && jQuery( window ).width() < 769 ) ? 36 : 21;

      if( captionHeight >= 44 ) {

        titleAdjust = 150 + captionHeight - nudge;

        jQuery( '.title-wrapper' ).css( 'bottom', titleAdjust );

      } else {

        jQuery( '.title-wrapper' ).css( 'bottom', '150px' );

      }

    });

  }

  var slickOptions = {
    slide: sliderId + ' .gallery-item',
    slidesToShow: 1,
    appendArrows: navElement

  }


  sliderIdObj.slick( slickOptions );



  // slick-lightbox stuff
  sliderIdObj.slickLightbox( {

    itemSelector: '.gallery-item>.gallery-icon>a',
    background: 'rgba( 255, 255, 255, 1 )',
    closeOnBackdropClick: false,
    imageMaxHeight: 0.75,
    shouldOpen: function( instance, click, event ) {

      var addedSlide = sliderIdObj.find( '.slick-track .slick-slide:nth-last-child(2)' ).html();

      // console.log( addedSlide );

      // add cta slide before opening
      sliderIdObj.slick( 'slickAdd', '<figure class="gallery-item">' + addedSlide + '</figure>'  );

      return true;

    },
    caption: function( element, info ) {

      var photoCaption = jQuery( element ).parents( '.gallery-item' ).data( 'caption' );

      var isPhotoCaption = ( photoCaption === '' ) ? ' no-caption' : '';

      var photoIndex = '<div class="gallery-index">Photo: <span>' + parseInt( info.index + 1 ) + ' <em>of</em> ' + info.length + '</span></div>';

      var galleryCaption = '<div class="gallery-caption' + isPhotoCaption + '">' + photoCaption + '</div>' + photoIndex;


      return galleryCaption;

    },



  });

  // remove advert slide on close;
    sliderIdObj.on( 'hide.slickLightbox', function() {

      sliderIdObj.slick( 'slickRemove', false ); // removes last slide

      var curSlide = sliderIdObj.slick('slickCurrentSlide')

      sliderIdObj.slick( 'slickGoTo', curSlide, true );

    });

    // inject DOM elements into last slide on modal
    sliderIdObj.on( 'shown.slickLightbox', function() {

      //find last true slide (not cloned)
      var ctaSlide = jQuery( '.slick-lightbox .slick-track .slick-slide:nth-last-child(2)' );

      var ctaCta = '<div class="overlay-cta"><div class="cta-gallery"><div class="koi-wrapper"><a href="/category/photos-videos/" class="koi"></a></div><div class="copy-wrapper"><p><strong>Continue your journey.</strong></p><p>View more photos and videos.</p><a class="arrow" href="/category/photos-videos/"></a></div></div></div>'

      ctaSlide.find( '.slick-lightbox-slick-item-inner' ).prepend( ctaCta );



    });



});


// fullscreen listener
jQuery( '.gallery-wrapper' ).on( 'click', 'a.fullscreen', function( e ) {

  e.preventDefault();

  var galleryObj = jQuery( jQuery( this ).attr( 'href' ) );

  galleryObj.find( '.slick-current .gallery-icon>a' ).trigger( 'click' );

});
