<?php
wp_enqueue_style( 'mh_style' );

$book_name = stripslashes($_GET['book']);

$book = MH_book_shelf_books_class::getOneBook( $book_name );

$page_url_del = esc_url( get_permalink( get_page_by_title( 'Delete' ) ) );
$page_url_edit = esc_url( get_permalink( get_page_by_title( 'Edit' ) ) );

?>
<div id="container">
    <h3><?php echo $book_name; ?></h3>
    <div id="description">
        <label for="teksti">Description</label>
        <ul>
            <p><?php echo $book->description; ?></p>
        </ul>
    </div>
    <div id="authors">
        <label for="teksti">Author(s)</label>
        <ul>
            <p>
                <?php
                foreach ( $book->authors as $auth )
                {
                    echo ( $auth . "<br />" );
                }
                ?>						
            </p>
        </ul>
    </div>
    <div id="categories">
        <label>Categories</label>
        <ul>
            <p>
                <?php
                foreach ( $book->categories as $cat )
                {
                    echo ( $cat . "<br />" );
                }
                ?>						
            </p>
        </ul>
    </div>
    <div>
        <a href="<?php echo get_home_url(); ?>"><button class="btn" type="button">Back</button></a>
        <?php
        if ( is_user_logged_in() ) {
            ?>
            <a href="<?php echo esc_url( add_query_arg( 'book', $book_name, $page_url_edit ) ); ?>"><button class="btn save" type="button">Edit</button></a>
            <a href="<?php echo esc_url( add_query_arg( 'book', $book_name, $page_url_del ) ); ?>"><button class="btn delete" name=delete type="button">Delete</button></a>                  
            <?php
        } 
        ?>
    </div>
</div>
