<?php
class MH_book_shelf_class {

    public function __construct() {

        add_action( 'init', array( $this,'init' ) );
    }

    public function init() {

        // tyylit
        wp_register_style( 'mh_style', plugins_url( 'css/style.css', __DIR__ ) );
        wp_register_style( 'mh_table_style', plugins_url( 'css/table.css', __DIR__ ) );
        
        // jqueryt fronttiin
        if ( !is_admin() )
        {
            wp_enqueue_script( 'jquery-noconflict', '//code.jquery.com/jquery-3.3.1.slim.js', array(), null, true );
            wp_enqueue_script( 'conflict-resolution', plugins_url( 'js/jquery-conflict-resolution.js', __DIR__ ), array( 'jquery-noconflict' ), true );
            wp_enqueue_script( 'mh_search_script', plugins_url( 'js/search.js', __DIR__ ), array( 'jquery-noconflict' ), null, true );
            wp_enqueue_script( 'mh_tags_script', plugins_url( 'js/tags.js', __DIR__ ), array( 'jquery-noconflict' ), null, true );
        }

        // lyhytkoodit
        add_shortcode( 'books-table', array( $this, 'table_shortcode' ) );
        add_shortcode( 'add-book', array( $this, 'add_book_shortcode' ) );
        add_shortcode( 'about-book', array( $this, 'about_book_shortcode' ) );
        add_shortcode( 'edit-book', array( $this, 'edit_book_shortcode' ) );
        add_shortcode( 'delete-book', array( $this, 'delete_book_shortcode' ) );
        add_shortcode( 'error', array( $this, 'error_page_shortcode' ) );
    }

    // näkymät lyhytkoodeille
    public function table_shortcode() {
        include_once( plugin_dir_path( __DIR__ ) . 'mh-book-shelf-books.php' );
    }

    public function add_book_shortcode() {
        include_once( plugin_dir_path( __DIR__ ) . 'mh-book-shelf-add.php' );
    }

    public function about_book_shortcode() {
        include_once( plugin_dir_path( __DIR__ ) . 'mh-book-shelf-about.php' );
    }
    
    public function edit_book_shortcode() {
        include_once( plugin_dir_path( __DIR__ ) . 'mh-book-shelf-edit.php' );
    }

    public function delete_book_shortcode() {
        include_once( plugin_dir_path( __DIR__ ) . 'mh-book-shelf-delete.php' );
    }

    public function error_page_shortcode() {
        include_once( plugin_dir_path( __DIR__ ) . 'mh-book-shelf-error.php' );
    }

}

add_action( 'plugins_loaded', 'mh_book_shelf_init' );

function mh_book_shelf_init() {
    $wp_plugin = new MH_book_shelf_class();
}