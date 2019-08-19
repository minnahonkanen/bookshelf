jQuery( document ).ready( function( $ ) {

    $( '#searchfield' ).keyup( filter );

    $( '.pressable-category' ).click( function() {
        $( this ).toggleClass( 'active' );
        filter();
    })

    $( '.pressable-author' ).click( function() {
        $( this ).toggleClass( 'active' );
        filter();
    });

    function filter() {
        var rex = new RegExp( $( '#searchfield' ).val(), 'i' );
        var rows = $( '.searchable tr' );
        
        rows.hide();
        rows.filter( function () {
            var tester = true;
            
            tester = rex.test( $( this ).text() );
            tester = tester && filterOnCategories( this ); 
            tester = tester && filterOnAuthors( this );

            return tester;
        
        }).show();
    }

    function filterOnCategories( selector ) {
        var tester = true;

        var all = $( '.pressable-category.active' );

        for ( var i = 0; i < all.length; i++ ) {
            var category = $( all[i] ).data( 'category' );
            var bookCategories = $( selector ).attr( 'book-categories' ).split( ',' );
            if ( bookCategories.indexOf( category ) < 0 ) {
                tester = false;
            }
        }
        return tester;
    }

    function filterOnAuthors( selector ) {
        var tester = true;

        var all = $( '#authors .pressable-author.active' );

        for ( var i = 0; i < all.length; i++ ) {
            var author = $( selector ).find( '[book-author="' + all[i].id + '"]' );
            if ( !author.hasClass( 'active' ) ) {
                tester = false;
            }
        }
        return tester;
    }
        
});