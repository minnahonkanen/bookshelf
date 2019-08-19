<?php
class MH_book_shelf_category_class {

    public $name;

    public function __construct()
    {
        $this->name = '';
    }

    public static function getAllCategories()
    {
        $json = file_get_contents( plugin_dir_path( __DIR__ ) . "json/categories.json" );
        return json_decode( $json );
    }
}