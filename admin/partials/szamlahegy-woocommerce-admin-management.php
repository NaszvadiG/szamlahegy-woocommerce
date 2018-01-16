<?php

/**
 * Provide a admin area page for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>

<h1><?php echo _e('Számlahegy funkciók','szamlahegy-wc'); ?></h1>
<!--
<?php if (!get_option('szamlahegy_wc_api_key')): ?>
  <p style="text-align: center;"><?php _e('A számlakészítéshez szükséges az API kulcs, amit <a href="/wp-admin/admin.php?page=wc-settings">Woocommerce bállításoknál</a> adhatsz meg!','szamlahegy-wc'); ?></p>

<?php else: ?>
  <?php
    $params = array('page' => $_GET['page'], 'func' => 'import');
  ?>
  <a href="<?php echo add_query_arg($params); ?>" class="button button-info"><?php echo _e('Termék adatok küldése a Számlahegybe','szamlahegy-wc'); ?></a><br/>

<?php endif; ?>
-->
