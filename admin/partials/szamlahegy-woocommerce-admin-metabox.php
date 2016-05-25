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
<?php if (!Szamlahegy_Woocommerce::get_api_key()): ?>
  <p style="text-align: center;"><?php printf(__('A számlakészítéshez szükséges az API kulcs, amit <a href="%s">Woocommerce bállításoknál</a> adhatsz meg!','szamlahegy-wc'), admin_url('admin.php?page=wc-settings') ); ?></p>
<?php else: ?>
  <?php if (Szamlahegy_Woocommerce::is_invoice_created( $post->ID )): ?>
    <?php $invoice = Szamlahegy_Woocommerce::get_api_response($post->ID); ?>
    <a href="<?php echo $invoice['invoice_url'] ?>" class="button button-info" target="_blank"><?php echo _e('Számla adatok','szamlahegy-wc'); ?></a><br/>
    <a href="<?php echo $invoice['pdf_url'] ?>" class="button button-info" target="_blank"><?php echo _e('Számla megnyitása','szamlahegy-wc'); ?></a><br/>
    <a href="<?php echo $invoice['server_url'] ?>/user/invoices" class="button button-info" target="_blank"><?php echo _e('Számla lista','szamlahegy-wc'); ?></a><br/>

  <?php else: ?>
    <a class="button save_order button-primary" id="szamlahegy_wc_create" href="#" data-nonce="<?php echo wp_create_nonce( "wc_create_invoice" ); ?>" data-order="<?php echo $post->ID; ?>"><?php _e('Számlakészítés','szamlahegy-wc'); ?></a><br/>

  <? endif; ?>
<?php endif; ?>
<a href="https://szamlahegy.hu" alt="<?php _e('Számlahegy online számlázó program','szamlahegy-wc'); ?>" target="_blank"><?php _e('Számlahegy.hu','szamlahegy-wc'); ?></a><br/>
</center>
