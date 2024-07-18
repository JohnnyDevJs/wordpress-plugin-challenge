<?php
/**
 *
 * @since             1.0.0
 * @package           bx_like
 *
 * Plugin Name: BX Like (Johnny Henrique da Silva)
 * Description: Plugin básico desenvolvido para adicionar botões de Like e Dislike aos posts e armazenar a popularidade. (Plugin para processo seletivo)
 * Version: 1.0.0
 * Author: Johnny Silva
 *
 */

if (!defined('WPINC')) {
    die; // Exit if accessed directly
}

// Constants
define('BX_LIKE_PATH', plugin_dir_path(__FILE__));
define('BX_LIKE_URL', plugin_dir_url(__FILE__));


// Load classes
require_once BX_LIKE_PATH . 'includes/class-assets.php';
require_once BX_LIKE_PATH . 'includes/class-buttons.php';
require_once BX_LIKE_PATH . 'includes/class-shortcode.php';
require_once BX_LIKE_PATH . 'includes/class-ajax-handler.php';

// Load admin classes
require_once BX_LIKE_PATH . 'admin/class-bx-like-admin.php';

// Initialize classes
Assets::init();
Buttons::init();
Shortcode::init();
Ajax_Handler::init();

// Initialize admin classes
Bx_like_Admin::init();