// swap out for new eTAM logo


setTimeout( function() {

  jQuery( '#divPoweredbyCol img' ).attr( 'src', '/UserDefinedImages/PoweredBySM.jpg' );

  jQuery( '#TOSMap>area' ).attr( 'coords', '1,0,203,32' );


  // update "user one" type text with survey questions on membership signups
  jQuery( '#ctl00_eTAMContent_lblUser1' ).text( 'Would you like to receive member emails?' );
  jQuery( '#ctl00_eTAMContent_lblUser2' ).html( 'Would you like to receive <em>The Garden Path</em> member magazine?' );
  jQuery( '#ctl00_eTAMContent_lblUser4' ).text( 'Do you need a new member card?' );

}, 1000 );
