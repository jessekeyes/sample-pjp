/**
* Portland Japanese Garden
* http://japanesegarden.com
*
* Copyright (c) 2015 Jesse Keyes
*/

// require category taxonomy at least one is checked
jQuery(function($){



  var publish = $( '.post-type-post #publish, .post-type-event #publish, .post-type-event-recurring #publish' ),
      savepost = $( '.post-type-post #save-post, .post-type-event #save-post, .post-type-event-recurring #save-post' ),
      saveall = $( '.post-type-post #publish, .post-type-event #publish, .post-type-event-recurring #publish, .post-type-post #save-post, .post-type-event #save-post, .post-type-event-recurring #save-post' );


  if( $( '.post-type-post' ).length > 0 || $( '.post-type-event' ).length > 0 || $( '.post-type-event-recurring' ).length > 0 ) {

  	saveall.click(function(e){
  		if( $( '.post-type-post #taxonomy-category input:checked, .post-type-event #taxonomy-category input:checked, .post-type-event-recurring #taxonomy-category input:checked').length == 0){

  			alert('Please select a category before publishing this post.');
  			e.stopImmediatePropagation();
  			return false;
  		}else{
  			return true;
  		}
  	});
  	var publish_click_events = publish.data('events').click;
  	if(publish_click_events){
  		if(publish_click_events.length>1){
  			publish_click_events.unshift(publish_click_events.pop());
  		}
  	}
  	if( savepost.data('events') != null){
  		var save_click_events = savepost.data('events').click;
  		if(save_click_events){
  		  if(save_click_events.length>1){
  			  save_click_events.unshift(save_click_events.pop());
  		  }
  		}
  	}

  }

  // pre-select Portland Japanese Garden as author
  jQuery( '.post-new-php #post_author_override>option[value=7]').prop( 'selected', true );


});
