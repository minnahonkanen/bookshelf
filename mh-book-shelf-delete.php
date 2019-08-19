<?php
wp_enqueue_style( 'mh_style' );

if ( is_user_logged_in() )
{
    $page_url = esc_url( get_permalink( get_page_by_title( 'About' ) ) );
    $home_url = get_home_url();
    $error_url = esc_url( get_permalink( get_page_by_title( 'Error' ) ) );

    $book_name = stripslashes($_REQUEST['book']);

    if ( isset ( $_POST['submit'] ) )
    {
        if ( MH_book_shelf_books_class::deleteBook( $book_name ) )
        {        
            wp_redirect( $home_url );
            exit;
        }
        else
        {
            wp_redirect( $error_url );
            exit;
        }
    }
}
else
{
    $page_url_login = esc_url( get_permalink( get_page_by_title( 'Login / Logout' ) ) );
    wp_redirect( $page_url_login );
    exit;
}
?>

<div id="container">
<h2>Are you sure you want to delete <?php echo $book_name ?>?</h2>
    <p>Deletion cannot be undone.</p>
    <form method="post">
    <input type="hidden" name="book" value="<?php echo $book_name ?>"/>
        <div>
            <a href="<?php echo esc_url( add_query_arg( 'book', $book_name, $page_url ) ); ?>"><button class="btn save" type="button">Back</button></a>
            <input type="submit" name="submit" value="Delete" class="btn delete">
        </div>
    </form>
</div>