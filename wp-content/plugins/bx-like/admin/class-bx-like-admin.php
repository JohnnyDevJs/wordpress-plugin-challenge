<?php
/**
 * The admin-specific functionality of the plugin.
 * @package    Bx_like
 * @author     Johnny Silva
 */

class Bx_like_Admin
{
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */

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
        add_action('admin_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_menu', [$this, 'admin_menu_page']);
    }

    public function enqueue_styles()
    {
        wp_enqueue_style(
            'bx-like-admin-style',
            BX_LIKE_URL . 'admin/assets/css/bx-like-admin.min.css',
            [],
            '1.0.0',
            'all'
        );
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'bx-like-admin-script',
            BX_LIKE_URL . 'js/buildbox-admin.js',
            ['jquery'],
            '1.0.0',
            false
        );
    }

    public function admin_menu_page()
    {
        add_options_page(
            __('Bx Like', 'bx-like'),
            __('Bx Like', 'bx-like'),
            'manage_options',
            'bx-like',
            [$this, 'bx_like_settings']
        );
    }

    public function bx_like_settings()
    {
        include BX_LIKE_PATH . 'admin/partials/bx-like-admin-settings.php';
    }
}