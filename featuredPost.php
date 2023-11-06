// Retrieve a random post from the post database to highlight
// Takes no arguments and returns void
function display_featured_post() {
    // Query arguments: select 1 random post
    $args = array(
        'posts_per_page' => 1,
        'orderby' => 'rand',
    );

    $random_post = new WP_Query($args);

    if ($random_post->have_posts()) {
        while ($random_post->have_posts()) {
            $random_post->the_post();

            // Get the post title and featured image
            $post_title = get_the_title();
            $post_image = get_the_post_thumbnail();

            // Get the post permalink
            $post_permalink = get_permalink();

            // HTML structure
            echo '<div class="featured-post">';
            echo '<div class="featured-post-image">' . $post_image . '</div>';
            echo '<div class="featured-post-content">';
            
            // Wrap the title in an anchor tag
            echo '<h2><a href="' . esc_url($post_permalink) . '">' . esc_html($post_title) . '</a></h2>';
        }
        wp_reset_postdata();
    }
}

// Transform display_featured_post function to shortcode
// Takes no aruments and returns the html structure for the featured post
function featured_post_shortcode() {
    ob_start();
    display_featured_post();
    return ob_get_clean();
}
add_shortcode('featured_post', 'featured_post_shortcode');
