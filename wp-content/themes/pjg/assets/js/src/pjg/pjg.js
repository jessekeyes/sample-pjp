/**
* Portland Japanese Garden
* http://japanesegarden.com
*
* Copyright (c) 2015 Jesse Keyes
*/


var scroll_ready = true;

 ( function( window, undefined ) {
  'use strict';

  /**
   * Lazy Loading
   */

  jQuery( '.delayed' ).each( function( ) {

    //console.log( $(this).data( 'delayed-background-image' ) );

    if ( jQuery( this ).is('iframe') ) {

      jQuery(this).attr( 'src', jQuery(this).data( 'src' ) );

    } else {

      jQuery(this).css( 'background-image', 'url(' + jQuery(this).data( 'delayed-background-image' ) + ')' );

    }

  });

  // load dynamic-content-feed divs based on their ajax-queryvars data attribute
  jQuery( '.dynamic-content-feed' ).each( function( ) {
    var el = jQuery(this);

    jQuery.ajax({
      url: wpURLs.ajaxurl + '?action=ajax_dynamic_content_feed&' + el.data('ajax-queryvars'),
      type: 'get',
      success: function( html ) {
          el.html(html);
          el.removeClass('hidden');
      },
      error: function( html ) {
          // console.log(html);
          el.html(html);
          el.removeClass('hidden');
      }
    })
  });

  // show the global-alert box if the cookie isn't set
  if(getCookieValue('close_alerts') != '1') {

    jQuery( '.global-alert' ).show();

    setTimeout( function() {

      jQuery( '.global-alert' ).addClass( 'open' );

      if( jQuery( '.global-alert' ).hasClass( 'open' ) ) {

        jQuery( 'body' ).addClass( 'alert' );

      }

    }, 300 );

  }

  // wire up the global alert close button
  jQuery( '.global-alert-close' ).click( function( ) {
    // set the cookie that keeps the alerts hidden (not a PHP session but a temporary browser cookie)
    document.cookie = "close_alerts=1; path=/";

    jQuery( '.global-alert' ).removeClass( 'open' );

    jQuery( 'body' ).removeClass( 'alert' );

    setTimeout( function() {

      jQuery( '.global-alert' ).hide();

    }, 300 );

    // hide the alert box
  });


  // wire up the international template mobile sidebar navigation drop down
  jQuery('.mobile-menu-button').on('click', function () {
    // toggle the list of links
    jQuery(this).parent().find('.sidebar-international-mobile-list').toggle();
    // toggle the up/down carets
    jQuery(this).parent().find('.mobile-menu-arrow').toggle();
  });

  // wire up the search 'load more' button, starting on page 2
  jQuery(document).on('click', '.search-load-more-button', function( event ) {

    event.preventDefault();

    lazyloadsearch();

  } );


 } )( this );


// helper method for reading cookies
// http://stackoverflow.com/questions/5639346/what-is-the-shortest-function-for-reading-a-cookie-by-name-in-javascript
function getCookieValue(a) {
  var b = document.cookie.match('(^|;)\\s*' + a + '\\s*=\\s*([^;]+)');
  return b ? b.pop() : '';
}

function lazyloadsearch() {

  var query = jQuery('.search-load-more-button').data('query');
  var current_search_page = jQuery('.search-load-more-button').data('page') + 1; // the next page

  // var pagination_element = jQuery(this).parent().parent();
  var pagination_element = jQuery( '.pagination' );

  // show the loading effect
  jQuery( '.load-more' ).addClass( 'lazy-hide' );
  jQuery( '.loader' ).removeClass( 'lazy-hide' );

  // go out to the server and get the next page
  jQuery.ajax({
      url: wpURLs.ajaxurl + '?action=ajax_search_load_more&s=' + query + '&page=' + current_search_page,
      type: 'get',
      success: function( html ) {
        // hide the current button, the html will contain another load more button if there is another page
        jQuery(pagination_element).remove();
        jQuery('.wrapper-posts').append(html);
        jQuery( '.load-more-action, .rule-loading' ).addClass( 'cloak' ); // cloak new button
        scroll_ready = true; // reset scroll infinite
      },
      error: function( html ) {
        jQuery(pagination_element).remove();
        jQuery('.wrapper-posts').append('Problem getting more results, please refresh and try again.');
      }
  });

  // return false;

}


// Behold The Blue Bar!
// because I don't want to regex and parse each post's content every time, let's just count the items with jQuery and set a class for the bar

function The_Blue_Bar() {

  var children = jQuery( '.entry-content' ).children();

  children.each( function() {

    if( jQuery( this ).children().hasClass( 'alignleft' ) || jQuery( this ).children().hasClass( 'alignnone' ) || jQuery( this ).children().hasClass( 'aligncenter' ) ) {

      return false; // stop if first item is aligned left, image, blockquotes, no blue bar

    } else if( jQuery( this ).hasClass( 'alignleft' ) || jQuery( this ).hasClass( 'alignnone' ) || jQuery( this ).hasClass( 'aligncenter' ) ) {

      return false; // stop if first item is aligned left, image, blockquotes, no blue bar

    } else if( jQuery( this ).hasClass( 'alignright' ) ) { // skip if first element is alignright

      return true;

    } else if( !jQuery( this ).hasClass( 'cta' ) && !jQuery( this ).hasClass( 'gallery' ) && !jQuery( this ).hasClass( 'video' ) && jQuery( this ).prop("tagName") != 'BLOCKQUOTE' ) {


      jQuery( this ).addClass( 'has-the-blue-bar' );

      return false;

    }

  });

};

The_Blue_Bar();


// scrolling sticky header shadow
jQuery(window).scroll(function(){
  var sticky = jQuery('.site-header'),
      scroll = jQuery(window).scrollTop();

  if ( scroll ) sticky.addClass('scrolled');
  else sticky.removeClass('scrolled');


  if( ( jQuery( 'body' ).hasClass( 'blog' ) || jQuery( 'body' ).hasClass( 'post-type-archive-event' ) ) && !jQuery( '.is_lastpage' ).data( 'lastpage' ) && jQuery( '.load-more-action' ).hasClass( 'cloak' ) && jQuery(window).scrollTop() + jQuery(window).height() > jQuery( '.content-area' ).height() - 100 ) {

      lazyload();
  }

  if( scroll_ready && jQuery( 'body' ).hasClass( 'search' ) && jQuery( '.load-more-action' ).hasClass( 'cloak' ) && jQuery(window).scrollTop() + jQuery(window).height() > jQuery( '.wrapper-search' ).height() - 100 ) {

    scroll_ready = false;

    lazyloadsearch();

  }

});


// Nav supporting js!

// click listener
jQuery( '#primary-menu>li.search>a, #primary-menu>li.menu-item-has-children>a, #global-menu>li.menu-item-has-children>a' ).on( 'click', function( event ) {

  event.preventDefault();

  var $thisNav = jQuery( this ).parent(),
      $allDrops = jQuery( '.menu-item-has-children, li.search' ),
      $navGlobal = jQuery( '#global-menu>.menu-item-has-children' ),
      $navPrimary = jQuery( '#primary-menu>.menu-item-has-children, #primary-menu>.search' );

  // global menu toggle
  if( $thisNav.parent().attr( 'id' ) == 'global-menu' ) {

    // console.log( 'global' );

    if( $thisNav.hasClass( 'open' ) ) {

      $thisNav.removeClass( 'open' );

    } else {

      // remove class / close other dropdowns in global-menu only
      $navGlobal.removeClass( 'open' );

      // remove primary nav and effect
      $navPrimary.removeClass( 'open' );
      jQuery( 'body' ).removeClass( 'overlay-nav' );
      $navPrimary.children( '.sub-menu' ).hide();
      jQuery( '#primary-menu' ).css( 'max-height', '0px' );


      $thisNav.addClass( 'open' );

      // set timer / listener to close menu on click

      // $thisNav.mouseleave( function() {
      //
      //   setTimeout( function() {
      //
      //     $navGlobal.removeClass( 'open' );
      //
      //   }, 2000 );
      //
      // })

    }

  } else if( $thisNav.parent().attr( 'id' ) == 'primary-menu' ) {

    // console.log( 'primary' );

    if( $thisNav.hasClass( 'open') ) {

      $thisNav.removeClass( 'open' );

      setTimeout( function (){

        $thisNav.children( '.sub-menu' ).hide();

      }, 300 );


      // close util nav too, to leave the overlay "experience" completely
      $navGlobal.removeClass( 'open' );

      // remove overlay effect, only on desktop
      if( jQuery( window ).width() >= 1024 ) {

        jQuery( 'body' ).removeClass( 'overlay-nav' );

      }

    } else {

      // remove open class from others (keep overlay, since switching primary navs
      if( jQuery( 'body' ).hasClass( 'overlay-nav' ) ) {

        if( jQuery( window ).width() >= 1024 ) {

          $navPrimary.removeClass( 'open' );

          $navPrimary.children( '.sub-menu' ).hide();

          $thisNav.children( '.sub-menu' ).show();

        } else {

            $thisNav.children( '.sub-menu' ).show();

        }

        setTimeout( function (){

          $thisNav.addClass( 'open' );

        }, 50 );

        $navGlobal.removeClass( 'open' );


      } else {

        jQuery( 'body' ).addClass( 'overlay-nav' );

        // remove util nav
        $navGlobal.removeClass( 'open' );

        if( jQuery( window ).width() >= 1024 ) {

          $navPrimary.removeClass( 'open' );

        }

        $thisNav.children( '.sub-menu' ).show();

        setTimeout( function (){

          $thisNav.addClass( 'open' );

        }, 50 );

      }

    }

  }

});

// mobile nav open/close

jQuery( '.menu-toggle' ).on( 'click', function() {

  var $this = jQuery( this  );

  if( $this.hasClass( 'open' ) ) {

    $this.removeClass( 'open' );
    jQuery( 'body' ).removeClass( 'overlay-nav' );

    jQuery( '.navigation-menu>ul>li' ).removeClass( 'open' );

    if( jQuery( window ).width() < 1024 ) {

      jQuery( '#primary-menu' ).css( 'max-height', '0px' );


    }



  } else {

    $this.addClass( 'open' );
    jQuery( 'body' ).addClass( 'overlay-nav' );

    // set size to allow inner scrolling on mobile
    if( jQuery( window ).width() < 1024 ) {

      setTimeout( function() {


        $offset = jQuery( '.site-header' ).height() - 36;
        $height = jQuery( window ).height();

        // console.log( $height - $offset );

        jQuery( '#primary-menu' ).css( 'max-height', $height - $offset + 'px' );

      }, 300 );

    }


    jQuery( '.navigation-menu>ul>li' ).removeClass( 'open' );


  }

})



// search DOM manip
jQuery( '#primary-menu li.search' ).append( jQuery( '#search-header' ) );

// visit DOM manip
jQuery( '#primary-menu li.visit>ul' ).append( jQuery( '.submenu-visitor' ) );


// add a class if only one dynamic content feed in the row

jQuery( '.dynamic-content-feed-wrapper' ).each( function () {

  if( jQuery( this ).children().length < 2 ) {

    jQuery( this ).addClass( 'single-row' );

  }

});


// set event category links

jQuery( '.main-navigation li.event>a' ).each( function() {

  $url = jQuery( this ).attr( 'href' );
  $url_event = $url + '?post_type=event';

  // console.log( $url, $url_event );

  jQuery( this ).attr( 'href', $url_event );

});


// nav reset functionh

function nav_reset() {

  jQuery( '#primary-menu>li, #global-menu>li, .menu-toggle' ).removeClass( 'open' );
  jQuery( 'body' ).removeClass( 'overlay-nav' );
  jQuery( '#primary-menu .sub-menu' ).hide();
  if( jQuery( window ).width() < 1024 ) {
    jQuery( '#search-header' ).show();
  }
  jQuery( '#primary-menu' ).css( 'max-height', '0' );

}


// listener

jQuery( window ).on( 'load orientationchange', function () {

  nav_reset();

});

jQuery( 'body' ).click( function( event ) {

  var classList = jQuery( event.target ).parent().attr( 'class' );

  // just in case the parent doesn't have a class
  if(!classList) {
      classList = '';
  }

  // split string by space, and put results into array
  classList = classList.split( ' ' );

  // console.log( classList );

  nonNavList = [ 'menu-item', 'site-title', 'search-form', 'main-navigation' ];

  if( !clickedNav( classList, nonNavList ) ) {

    nav_reset();

  }

  function clickedNav(haystack, arr) {
      return arr.some(function (v) {
      return haystack.indexOf(v) >= 0;
    });
  };

});


jQuery( '#international-page' ).on( 'change', function() {

  Value = jQuery( this ).val();

  if( Value != 0 ) {

    location.href = Value;

  }

  console.log( Value );

})

// add to calendar drawer

jQuery( '.calendar-add' ).on( 'click', function( e ) {

  e.preventDefault();

  jQuery( '.calendar-drawer' ).toggleClass( 'open' );

});


setTimeout( function() {

  jQuery( '#sharing_email' ).detach().appendTo( '.sharing' );

}, 500 );


// accordion toggle
jQuery( '.accordion-toggle' ).on( 'click', function( e ) {

  e.preventDefault();

  var Toggle = jQuery( this );
  var AccordionHidden = Toggle.parent().children( '.accordion-hidden' );
  var ToggleWord = Toggle.find( '.toggle-word' );
  var View = ToggleWord.data( 'view' );
  var Hide = ToggleWord.data( 'hide' );

  if( !Toggle.hasClass( 'active' ) ) {

    Toggle.addClass( 'active' );
    AccordionHidden.addClass( 'active' );

    ToggleWord.text( Hide );

  } else {

    Toggle.removeClass( 'active' );
    AccordionHidden.removeClass( 'active' );

    ToggleWord.text( View );


  }

} );
