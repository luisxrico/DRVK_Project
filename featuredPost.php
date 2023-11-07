<?php
    /**
    * Display a random post from the database as a highlighed case on the homepage
    * 
    * @param none
    * @return void
    */
    function display_featured_post() {
    
    // Restrict query arguments to 1 post and in random order
    $args = array(
        'posts_per_page' => 1,
        'orderby' => 'rand',
    );

    /**
     * Retrieve a post from the WordPress posts database
     * 
     * @param list of arguments
     * @return WordPress Post object
     */
    $random_post = new WP_Query($args);

    // Verify post object has content
    if ($random_post->have_posts()) {
        while ($random_post->have_posts()) {
            
            // Get the body of the post
            $random_post->the_post();

            // Get the post title and featured image
            $post_title = get_the_title();
            $post_image = get_the_post_thumbnail();

            // Get the post permalink
            $post_permalink = get_permalink();

            // HTML structure to display the post
            echo '<div class="featured-post">';
            echo '<div class="featured-post-image">' . $post_image . '</div>';
            echo '<div class="featured-post-content">';
            
            // Wrap the title in an anchor tag
            echo '<h2><a href="' . esc_url($post_permalink) . '">' . esc_html($post_title) . '</a></h2>';
        }
        // reset context of tags back to main query loop
        wp_reset_postdata();
    }
    else {
        // Error Handle: In case no posts are found, display message that no posts are available
        echo '<div class"featured-post-error"> Featured posts are unavailable at the moment.</div>';
    }
}

    /**
     * Convert the function display_featured_post to shortcode
     * 
     * @param none
     * @return buffer containing HTML structure
     */
    function featured_post_shortcode() {
        // open a buffer
        ob_start();
        // retrieve a post and display it using HTML
        display_featured_post();

        return ob_get_clean();
    }
    // add shortcode alias to ease integration with site
    add_shortcode('featured_post', 'featured_post_shortcode');

?>
