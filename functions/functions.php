<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Display Sellable Stock Number Inside Order Page
 */

 if( ! function_exists( 'bolovo_wsdao_display_stock_in_order_page' ) ){
    function bolovo_wsdao_display_stock_in_order_page(){
        ?>
        <th class="quantity sortable" data-sort="string-ins">
            <?php esc_html_e('Stock', 'bolovo-wsdao-td'); ?>
        </th>
        <?php
    }
    add_action('woocommerce_admin_order_item_headers', 'bolovo_wsdao_display_stock_in_order_page');
}

if( ! function_exists( 'bolovo_wsdao_populate_stock_column_in_order_page' ) ){
    function bolovo_wsdao_populate_stock_column_in_order_page( $product, $item, $item_id ){
        if( !is_a( $item , 'WC_Order_Item_Product' ) ){
            return;
        }
        if ( ! $product ) return;

        $manages_stock = $product->get_manage_stock();
        $text_to_display = '';

        if( '1' == $manages_stock ){
            $text_to_display = $product->get_stock_quantity();
        }else{

            switch ( $product->get_stock_status() ) {
                case 'outofstock':
                    $text_to_display = esc_html__( 'Out of Stock', 'bolovo-wsdao-td' );
                    break;

                case 'onbackorder':
                    $text_to_display = esc_html__( 'On Backorder', 'bolovo-wsdao-td' );
                    break;

                default:
                    $text_to_display = esc_html__( 'In Stock', 'bolovo-wsdao-td' );
                    break;
            }

        }

        ?>
        <td class="quantity" width="1%">
        <div class="view"><?php echo esc_html( $text_to_display ); ?>
        </div>
        </td>
        <?php
    }
    add_action('woocommerce_admin_order_item_values', 'bolovo_wsdao_populate_stock_column_in_order_page' , 10 , 3);
}