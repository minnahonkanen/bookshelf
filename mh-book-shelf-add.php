<?php
wp_enqueue_style( 'mh_style' );

if ( is_user_logged_in() )
{
    $allCategories = MH_book_shelf_category_class::getAllCategories();
    $allAuthors = MH_book_shelf_author_class::getAllAuthors();

    $errMesg = "";

    if ( isset( $_POST["submit"] ) )
    {
        $newBook = new MH_book_shelf_books_class();

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

        $bookName = sanitize_text_field( $_POST['book_name'] );
        $bookDescription = sanitize_textarea_field( $_POST['book_description'] );
 
        if ( !empty( $bookName ) )
        {
            $newBook->name = $bookName;
            $newBook->description = $bookDescription;
            $newBook->authors = $authors;
            $newBook->categories = $categories;

            if ( $newBook->addNewBook() )
            {
                $home_url = get_home_url();
                wp_redirect( $home_url );
                exit;
            }
            else
            {
                $error_url = esc_url( get_permalink( get_page_by_title( 'Error' ) ) );
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
    <h3>Add New Book</h3>
    <form method="post" action="">
        <div>
            <label>Name</label>
            <input type="text" class="form-control" id="book_name" name="book_name" maxlength="150" required>
        </div>
        <div>
            <label>Description</label>
            <textarea id="book_description" name="book_description"></textarea>
        </div>
        <div class="authors">
            <label>Author(s)</label>
            <?php
                foreach ( $allAuthors as $auth )
                {
                    ?>
                    <input type="checkbox" name="book_authors[]" value="<?php echo $auth; ?>" style="display:none" />
                    <input type="button" id="authors" class="pressable" name="<?php echo $auth; ?>" data-author="<?php echo $auth; ?>" value="<?php echo $auth; ?>"/>
                    <?php
                }
            ?>
        </div>
        <div class="categories">
            <label>Categories</label>
            <?php
                foreach ( $allCategories as $cat )
                {
                    ?>
                    <input type="checkbox" name="book_categories[]" value="<?php echo $cat; ?>" style="display:none" />
                    <input type="button" id="categories" class="pressable" name="<?php echo $cat; ?>" data-category="<?php echo $cat; ?>" value="<?php echo $cat; ?>"/>
                    <?php
                }
            ?>
        </div>
        <div>
            <a href="<?php echo get_home_url(); ?>"><button class="btn" type="button">Back</button></a>
            <input type="submit" name="submit" value="Save" class="btn save">       
        </div>
    </form>
</div>

