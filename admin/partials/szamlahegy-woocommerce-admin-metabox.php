<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://szamlahegy.hu
 * @since      1.0.0
 *
 * @package    Szamlahegy_Woocommerce
 * @subpackage Szamlahegy_Woocommerce/admin/partials
 */
?>
<center>
<?php if (!get_option('szamlahegy_wc_api_key')): ?>
  <p style="text-align: center;"><?php _e('A számlakészítéshez szükséges az API kulcs, amit <a href="/wp-admin/admin.php?page=wc-settings">Woocommerce bállításoknál</a> adhatsz meg!','szamlahegy-wc'); ?></p>
<?php else: ?>
  <?php if (get_post_meta( $post->ID, '_szamlahegy_wc_response' )): ?>
    <?php $invoice = get_post_meta( $post->ID, '_szamlahegy_wc_response', true ); ?>
    <a href="<?php echo $invoice['invoice_url'] ?>" class="button button-info" target="_blank"><?php echo _e('Számla adatok','szamlahegy-wc'); ?></a><br/>
    <a href="<?php echo $invoice['pdf_url'] ?>" class="button button-info" target="_blank"><?php echo _e('Számla megnyitása','szamlahegy-wc'); ?></a><br/>
    <a href="<?php echo $invoice['server_url'] ?>/user/invoices" class="button button-info" target="_blank"><?php echo _e('Számla lista','szamlahegy-wc'); ?></a><br/>

  <?php else: ?>
    <a class="button save_order button-primary" id="szamlahegy_wc_create" href="#" data-nonce="<?php echo wp_create_nonce( "wc_create_invoice" ); ?>" data-order="<?php echo $post->ID; ?>"><?php _e('Számlakészítés','szamlahegy-wc'); ?></a><br/>

  <? endif; ?>
<?php endif; ?>
<a href="https://szamlahegy.hu" alt="<?php _e('Számlahegy online számlázó program','szamlahegy-wc'); ?>" target="_blank"><?php _e('Számlahegy.hu','szamlahegy-wc'); ?></a><br/>
</center>
