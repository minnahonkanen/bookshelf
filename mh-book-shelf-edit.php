<?php
wp_enqueue_style( 'mh_style' );

if ( is_user_logged_in() )
{
    $page_url = esc_url( get_permalink( get_page_by_title( 'About' ) ) );
    $about_url = esc_url( add_query_arg( 'book', $_POST['book_name'], $page_url ) );
    $error_url = esc_url( get_permalink( get_page_by_title( 'Error' ) ) );

    $book_name = stripslashes($_REQUEST['book']);

    $allAuthors = MH_book_shelf_author_class::getAllAuthors();
    $allCategories = MH_book_shelf_category_class::getAllCategories();
    $book = MH_book_shelf_books_class::getOneBook( $book_name );

    if (isset($_POST['submit']))
    {
        $editedBook = new MH_book_shelf_books_class();

        $authors = [];
        $categories = [];
        if ( isset( $_POST['book_authors'] ) )
        {
            $authors = $_POST['book_authors'];
        }
        if ( isset( $_POST['book_categories'] ) )
        {
            $categories = $_POST['book_categories'];
        }

        $editedName = sanitize_text_field( stripslashes( $_POST['book_name'] ) );
        $editedDescription = sanitize_textarea_field( stripslashes( $_POST['book_description'] ) );        

        if ( !empty( $editedName ) )
        {
            $editedBook->name = $editedName;
            $editedBook->description = $editedDescription;
            $editedBook->authors = $authors;
            $editedBook->categories = $categories;

            if ( $editedBook->editBook( $book_name ) )
            {        
                wp_redirect( $about_url );
                exit;
            }
            else
            {
                wp_redirect( $error_url );
                exit;
            }
        }
        else
        {
            echo '<p class="error">Name is required.</p>';
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
    <h3>Edit Book</h3>
    <form method="post">
        <div>
            <label>Name</label><br/>
            <input type="text" class="form-control" id="book_name" name="book_name" value="<?php echo $book_name; ?>" maxlength="150">
        </div>
        <div>
            <label>Description</label>
            <textarea id="book_description" name="book_description"><?php echo $book->description; ?></textarea>
        </div>
        <div class="authors">
            <label>Author(s)</label>
            <?php
                foreach ( $allAuthors as $auth )
                {
                    ?>
                    <input type="checkbox" name="book_authors[]" value="<?php echo $auth; ?>" style="display:none" <?php if (in_array($auth, $book->authors)) echo 'checked'; ?>/>
                    <input type="button" id="authors" class="pressable <?php if ( in_array( $auth, $book->authors ) ) echo 'active'; ?>" data-author="<?php echo $auth; ?>" value="<?php echo $auth; ?>"/>
                    <?php
                }
            ?>
        </div>
        <div id="categories">
            <label>Categories</label>
            <?php
                foreach ( $allCategories as $cat )
                {
                    ?>
                    <input type="checkbox" name="book_categories[]" value="<?php echo $cat; ?>" style="display:none" <?php if (in_array($cat, $book->categories)) echo 'checked'; ?>/>
                    <input type="button" id="categories" class="pressable <?php if ( in_array ( $cat, $book->categories ) ) echo 'active'; ?>" data-category="<?php echo $cat; ?>" value="<?php echo $cat; ?>"/>
                    <?php
                }
            ?>
        </div>
        <div>
            <a href="<?php echo esc_url( add_query_arg( 'book', $book_name, $page_url ) ); ?>"><button class="btn" type="button">Back</button></a>
            <input type="submit" name="submit" value="Save" class="btn save">
        </div>
    </form>
</div>