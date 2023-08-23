<?php
set_time_limit(99999);

class MRCREK_JSON_Products {


    public $_wpdb; 

    public function __construct() {
        global $wpdb;
        $this->_wpdb = $wpdb;
        add_action( 'wp_ajax_sch_products_cache', array( $this, 'ajax' ) );
    }



    public function ajax() {



        $prefix = $this->_wpdb->prefix;

        //_sku
        $sql = "SELECT {$prefix}posts.ID, {$prefix}postmeta.meta_id, {$prefix}postmeta.meta_value FROM {$prefix}posts LEFT JOIN {$prefix}postmeta ON {$prefix}posts.ID={$prefix}postmeta.post_id WHERE {$prefix}posts.post_type = 'product' AND {$prefix}posts.post_status = 'publish' AND {$prefix}postmeta.meta_key = '_sku'";


        $res = $this->_wpdb->get_results( $sql );


        foreach( $res as $index => $row ) {
            $sql_2 = "SELECT meta_id FROM {$prefix}postmeta WHERE post_id = $row->ID AND meta_key = '_price'";
            $res2 = $this->_wpdb->get_results( $sql_2 );
            $res[$index]->{'_price'} = $res2[0]->meta_id;

            $sql_3 = "SELECT meta_id FROM {$prefix}postmeta WHERE post_id = $row->ID AND meta_key = '_regular_price'";
            $res3 = $this->_wpdb->get_results( $sql_3 );
            $res[$index]->{'_regular_price'} = $res3[0]->meta_id;


            $sql_4 = "SELECT meta_id FROM {$prefix}postmeta WHERE post_id = $row->ID AND meta_key = '_stock'";
            $res4 = $this->_wpdb->get_results( $sql_4 );
            $res[$index]->{'_stock'} = $res4[0]->meta_id;


            $sql_5 = "SELECT meta_id FROM {$prefix}postmeta WHERE post_id = $row->ID AND meta_key = '_stock_status'";
            $res5 = $this->_wpdb->get_results( $sql_5 );
            $res[$index]->{'_stock_status'} = $res5[0]->meta_id;
        }
// exit;
        // echo '<pre>';
        // print_r( $res );
        // echo '</pre>'; exit;

        $this->write_json( $res );

        echo json_encode( array( 'status' => 'success', 'msg' => 'Cache refreshed' ) ); exit;
        // echo count( $res );
        // echo '<pre>';
        // print_r( $res );
        // echo '</pre>';

    }


    public function write_json( $json ) {
        
        $json_cache_file = MRCREK_PRODUCTS_PLUGIN_DIR . '/cache/products.json';


        

        $fp = fopen($json_cache_file, 'w');
        fwrite($fp,trim( stripslashes ( json_encode($json, JSON_UNESCAPED_SLASHES) ), '"' ) );
        fclose($fp);

    }
}


new MRCREK_JSON_Products();