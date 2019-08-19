<?php
class MH_book_shelf_books_class {

    public $name;
    public $description;
    public $authors;
    public $categories;

    public function __construct()
    {
        $this->name = '';
        $this->description = '';
        $this->authors = [];
        $this->categories = [];
    }

    public static function getAllBooks()
    {
        $json = file_get_contents( plugin_dir_path( __DIR__ ) . "json/books.json" );
        return json_decode( $json );
    }

    public static function getOneBook( $name )
    {
        $books = MH_book_shelf_books_class::getAllBooks();

        foreach ( $books as $book )
        {
            if ( $book->name == $name )
            {
                return $book;
            }
        }
        return NULL;
    }

    public function addNewBook()
    {
        $tempArray = $this->getAllBooks();

        array_push( $tempArray, $this );

        $json = json_encode( $tempArray, JSON_PRETTY_PRINT );

        return file_put_contents( plugin_dir_path( __DIR__ ) . 'json/books.json', $json );
    }

    public static function deleteBook( $name )
    {
        $tempArray = MH_book_shelf_books_class::getAllBooks();

        $matchFound = false;
        for ( $i = 0; $i < count( $tempArray ); $i++ )
        {
            if ( $tempArray[$i]->name == $name )
            {
                $matchFound = true;
                break;
            }
        }

        if ( $matchFound )
        {
            array_splice( $tempArray, $i, 1 );
        }

        $json = json_encode( $tempArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );

        return file_put_contents( plugin_dir_path( __DIR__ ) . 'json/books.json', $json );
    }
    
	public function editBook( $name )
    {
        $this->deleteBook( $name );
        return $this->addNewBook();
    }
        
}