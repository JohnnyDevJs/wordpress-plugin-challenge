<?php
/**
 *
 * Add register and enqueue scripts and styles
 * Method to initialize the class Assets
 * @since             1.0.0
 * @package           bx_like
 */

class Assets
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
        add_action('wp_enqueue_scripts', [$this, 'bx_like_enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'bx_like_enqueue_scripts']);
    }

    public function bx_like_enqueue_styles()
    {
        // Register styles.
        wp_register_style('bx-like-style', BX_LIKE_URL . '/assets/css/bx-like.min.css', [], '1.0.0', 'all');

        // Enqueue styles.
        wp_enqueue_style('bx-like-style');
    }

    public function bx_like_enqueue_scripts()
    {
        // Register scripts.
        wp_register_script('bx-like-script', BX_LIKE_URL . 'assets/js/bx-like.min.js', ['jquery'], '1.0.0', true);
        wp_localize_script('bx-like-script', 'bx_like_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
        wp_localize_script('bx-like-script', 'bx_like_update_top_liked_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);

        // Enqueue scripts.
        wp_enqueue_script('bx-like-script');
    }
}