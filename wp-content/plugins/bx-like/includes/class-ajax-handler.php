<?php
/**
 * Handle AJAX requests for updating Like/Dislike counts
 * Method to initialize the class Ajax_Handler
 * @since 1.0.0
 * @package bx_like
 */

class Ajax_Handler
{
    public static function init()
    {
        $instance = new self();
        $instance->setup_hooks();
    }

    public function setup_hooks()
    {
        // Add AJAX actions for updating like/dislike counts
        add_action('wp_ajax_nopriv_update_like_dislike', [$this, 'bx_like_handle_ajax']);
        add_action('wp_ajax_update_like_dislike', [$this, 'bx_like_handle_ajax']);
    }

    public function bx_like_handle_ajax()
    {
        if (!isset($_POST['post_id']) || !isset($_POST['action_type'])) {
            wp_send_json_error(['message' => 'Invalid data.']);
        }

        $post_id = intval($_POST['post_id']);
        $action_type = sanitize_text_field($_POST['action_type']);
        $like_meta_key = '_likes';
        $dislike_meta_key = '_dislikes';
        $likes = get_post_meta($post_id, $like_meta_key, true) ?: 0;
        $dislikes = get_post_meta($post_id, $dislike_meta_key, true) ?: 0;

        // Check if user has already liked/disliked this post using cookies
        $liked = $this->get_bx_like_status($post_id);

        if ($action_type === 'like') {
            if (!$liked['like']) {
                $likes++;
                if ($liked['dislike']) {
                    $dislikes--;
                }
                $liked = ['like' => true, 'dislike' => false];
            } else {
                $likes--;
                $liked['like'] = false;
            }
        } elseif ($action_type === 'dislike') {
            if (!$liked['dislike']) {
                $dislikes++;
                if ($liked['like']) {
                    $likes--;
                }
                $liked = ['like' => false, 'dislike' => true];
            } else {
                $dislikes--;
                $liked['dislike'] = false;
            }
        }

        // Update post meta and set cookies
        update_post_meta($post_id, $like_meta_key, $likes);
        update_post_meta($post_id, $dislike_meta_key, $dislikes);
        $this->set_like_dislike_cookie($post_id, $liked);

        $top_liked_posts_html = Shortcode::top_liked_posts();

        wp_send_json_success(['likes' => $likes, 'dislikes' => $dislikes, 'top_liked_posts' => $top_liked_posts_html]);
    }

    private function get_bx_like_status($post_id)
    {
        $liked_status = isset($_COOKIE['bx_like_' . $post_id]) ? json_decode(stripslashes($_COOKIE['bx_like_' . $post_id]), true) : ['like' => false, 'dislike' => false];

        return $liked_status;
    }

    private function set_like_dislike_cookie($post_id, $liked)
    {
        $cookie_value = json_encode($liked);
        setcookie('bx_like_' . $post_id, $cookie_value, time() + (30 * 24 * 60 * 60), '/');
    }
}