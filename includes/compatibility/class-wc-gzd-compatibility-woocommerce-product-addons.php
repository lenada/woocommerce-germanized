<?php

/**
 * Product Addons Helper
 *
 * @class    WC_GZD_Compatibility_WooCommerce_Product_Addons
 * @category Class
 * @author   vendidero
 */
class WC_GZD_Compatibility_WooCommerce_Product_Addons extends WC_GZD_Compatibility {

	public static function get_name() {
		return 'WooCommerce Product Addons';
	}

	public static function get_path() {
		return 'woocommerce-product-addons/woocommerce-product-addons.php';
	}

	public function load() {
		add_action( 'woocommerce_product_addons_end', array( $this, 'shopmarks' ), 11 );
	}

	public function shopmarks() {
		ob_start();
		foreach ( wc_gzd_get_single_product_shopmarks() as $shopmark ) {
			$callback = $shopmark->get_callback();

			if ( function_exists( $callback ) && $shopmark->is_enabled() && in_array( $shopmark->get_type(), array( 'unit_price', 'legal', 'tax', 'shipping_costs' ) ) ) {
				call_user_func( $callback );
			}
		}
		$html = ob_get_clean();

		if ( ! empty( $html ) ) {
			echo '<style>div.product-addon-totals { border-bottom: none; padding-bottom: 0; } .wc-gzd-product-addons-shopmarks { margin-top: -40px; margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 20px; font-size: .9em; text-align: right; }</style>';
			echo '<div class="wc-gzd-product-addons-shopmarks">' . $html . '</div>';
		}
	}
}