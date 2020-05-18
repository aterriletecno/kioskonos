<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
get_header();

?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <div id="content">
    
    </div>

<?php endwhile; ?>
<?php get_footer(); ?>