<?php
wp_enqueue_style( 'mh_style' );

$home_url = get_home_url();
?>

<div id="container">
<h2>Oops! Something went wrong.</h2>
    <div>
        <a href="<?php echo esc_url( $home_url ); ?>"><button class="btn save" type="button">Home</button></a>
    </div>
</div>