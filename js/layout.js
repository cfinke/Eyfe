jQuery( function ( $ ) {
	$( '#masthead, #main' ).height( Math.max( $( '#masthead' ).height(), $( '#main' ).height() ) );
	$( '#secondary, #primary' ).height( Math.max( $( '#secondary' ).height(), $( '#primary' ).height(), $( '#main' ).height() ) );
} );