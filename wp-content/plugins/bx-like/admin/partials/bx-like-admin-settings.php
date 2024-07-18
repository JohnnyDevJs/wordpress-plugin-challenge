<?php

/**
 * Provide a admin area view for the plugin
 *
 * @since      1.0.0
 *
 * @package    bx_like
 * @author Johnny Silva
 */

$bx_like_settings = get_option('bx_like_settings');

if (empty($bx_like_settings)) {
    $bx_like_settings = [
        'basic_settings' => [
            'allowed' => '1',
            'post_type' => [

            ],
        ]];
}
?>
<div class="wrap bx-like-wrap">
  <h3>Utilizando o shortcode</h3>

  <ul class="bx-like-options-shortcode">
    <li>
      <p>Utilizar diretamente no código:</p>
      <code><?php echo esc_html('<?php echo do_shortcode("[top_liked]"); ?>'); ?></code>
    </li>
    <li>
      <p>Utilizar diretamente no editor:</p>
      <code>[top_liked]</code>
    </li>
  </ul>
</div>