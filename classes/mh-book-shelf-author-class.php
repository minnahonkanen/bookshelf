<?php
class MH_book_shelf_author_class {

    public $name;

    public function __construct()
    {
        $this->name = '';
    }

    public static function getAllAuthors()
    {
        $json = file_get_contents( plugin_dir_path( __DIR__ ) . "json/authors.json" );
        return json_decode( $json );
    }

}