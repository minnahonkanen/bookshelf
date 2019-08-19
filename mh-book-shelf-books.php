<?php
wp_enqueue_style( 'mh_table_style' );


$books = MH_book_shelf_books_class::getAllBooks();
$categories = MH_book_shelf_category_class::getAllCategories();
$authors = MH_book_shelf_author_class::getAllAuthors();

$page_url = esc_url( get_permalink( get_page_by_title( 'About' ) ) );

function compareBookNames( $a, $b )
{
    return strcmp( $a->name, $b->name );
}
usort( $books, "compareBookNames" );
?>


<div id="container">
    <!-- hakukenttä -->
    <div>
        <div id="search">
            <input id="searchfield" type="search" placeholder="Search...">
        </div>
    </div>
    <!-- klikattavat kategoriat -->
    <div id="buttons">
        <?php
        foreach ( $categories as $cat )
        {
            ?>
            <button id="categories" class="pressable-category" name="<?php echo $cat; ?>" data-category="<?php echo $cat; ?>"><?php echo $cat; ?></button>
            <?php
        }
        ?>
    </div>
    <div>
    <!-- taulukko -->
        <table id="books">
            <thead>
                <tr id="authors">
                    <td></td>
                    <?php
                    $id = 1;
                    foreach ( $authors as $auth )
                    {
                        ?>
                        <td class="writer">
                            <?php
                            echo '<h6 class="pressable-author" name="' . $auth . '" id="' . $id . '">' . $auth . '</h6>';
                            ?>
                        </td>
                        <?php
                        $id++;
                    }                    
                    ?>
                </tr>
            </thead>
        <?php        
        foreach ( $books as $book )
        {
            ?>
            <tbody class="searchable">
                <!-- lisätään jokaiselle kirjalle kategoriat, jotta filtteröinti toimii -->
                <tr class="row-border" name="<?php echo $book->name; ?>" book-categories="<?php echo implode( ",", $book->categories ); ?>">
                    <td>
                        <?php
                        echo '<a href="' . esc_url( add_query_arg( 'book', $book->name, $page_url ) ) . '">' . $book->name . '</a>';           
                        ?>
                    </td>
                    <?php
                    $counter = 1;
                    foreach ( $authors as $auth )
                    {                        
                        ?>
                        <td class="writer">
                            <?php
                            if ( in_array( $auth, $book->authors ) )
                            {
                                echo '<span class="writer active" book-author="' . $counter .'">X</span>';
                            }
                            else
                            {
                                echo '<span class="writer" book-author="' . $counter .'"></span>';
                            }
                            ?>
                        </td>
                        <?php
                        $counter++;
                    }                    
                    ?>
                </tr>        
            </tbody>
        <?php
        }
        ?>
        </table>
    </div>
</div>