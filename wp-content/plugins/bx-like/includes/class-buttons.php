<?php
/**
 *
 * Add Buttons in post content
 * Method to initialize the class Buttons
 * @since             1.0.0
 * @package           bx_like
 */

class Buttons
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
        add_filter('the_content', [$this, 'add_bx_like_buttons']);
    }

    public function add_bx_like_buttons($content)
    {
        if (is_single() && in_the_loop() && is_main_query()) {
            global $post;

            $image_path = BX_LIKE_URL . 'assets/images/thumb.png';
            $url_image = '<img src="' . $image_path . '" alt="Thumb" />';

            $liked_status = $this->get_bx_like_status($post->ID);

            $like_disabled = $liked_status['like'] ? 'disabled' : '';
            $dislike_disabled = $liked_status['dislike'] ? 'disabled' : '';

            $buttons = '
          <div class="like-dislike-buttons">
              <button class="like-button wp-block-button__link wp-element-button" data-post_id="' . $post->ID . '" ' . $like_disabled . '>Like ' . $url_image . '</button>
              <button class="dislike-button wp-block-button__link wp-element-button" data-post_id="' . $post->ID . '" ' . $dislike_disabled . '>Dislike ' . $url_image . '</button>
          </div>';

            return $content . $buttons;
        }

        return $content;
    }

    private function get_bx_like_status($post_id)
    {
        $liked_status = isset($_COOKIE['bx_like_' . $post_id]) ? json_decode(stripslashes($_COOKIE['bx_like_' . $post_id]), true) : ['like' => false, 'dislike' => false];

        return $liked_status;
    }
}