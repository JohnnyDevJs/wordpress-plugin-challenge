<?php
/**
 *
 * Add Shortcode Bx Like
 * Method to initialize the class Shortcode
 * @since             1.0.0
 * @package           bx_like
 */

class Shortcode
{
    public static function init()
    {
        // load class.
        $instance = new self();
        $instance->setup_hooks();
    }

    public function setup_hooks()
    {
        /**
          * Actions.
          */
        add_shortcode('top-liked', [$this, 'top_liked_posts']);
    }

    public static function top_liked_posts()
    {
        $query = new WP_Query([
            'post_type' => 'post',
            'meta_key' => '_likes',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'posts_per_page' => 5,
        ]);

        if ($query->have_posts()) {
            $output = '<div id="topLikedPosts">';
            $output .= '<h4>Top Liked</h4>';
            $output .= '<ul class="top-liked-posts">';
            while ($query->have_posts()) {
                $query->the_post();
                $likes = get_post_meta(get_the_ID(), '_likes', true) ?: 0;

                if ($likes >= 1) {
                    $count_likes = $likes > 1 ? ' (' . $likes . ' likes)' : ' (' . $likes . ' like)';
                    $likes = '<li><a href="' . get_permalink() . '">' . get_the_title() . '<span class="likes-count">' . $count_likes . '</span></a>';
                } else {
                    $likes = '';
                }


                $output .= $likes;

                $output .= '</li>';
            }
            $output .= '</ul>';
            $output .= '</div>';
            wp_reset_postdata();

            return $output;
        } else {
            return '<p>No posts found.</p>';
        }
    }
}