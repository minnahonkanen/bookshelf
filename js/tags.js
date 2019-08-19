jQuery( document ).ready( function( $ ) {
    $( "input.pressable" ).click( function() {
        $( this ).toggleClass( 'active' );
        var value = $( this ).val();
        var checkbox = $( "input[type=checkbox][value='" + value + "']" );
        checkbox.prop( "checked", !checkbox.prop( "checked" ) );
    });
});