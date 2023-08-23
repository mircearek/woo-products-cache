<?php

class MRCREK_Settings {
    /**
     * init
     */
    public function __construct() {
        //menus and pages
        add_action( 'admin_menu', array( &$this, 'add_menu' ) );
        //scripts and styles for admin views
        add_action( 'admin_enqueue_scripts', array( &$this, 'scripts_styles' ) );

    } 


    /**
     * Include scripts and styles for admin views
     */
    public function scripts_styles() {
        //registering script
        wp_register_script( 'mrc_admin', plugin_dir_url( __DIR__  ) . 'assets/admin/js/mrc-cache.js', array(), '' );

        $arr = array(
            'ajax_url'                  => admin_url( 'admin-ajax.php' ),
            'import_sec'                => wp_create_nonce( 'mrc_product_import' ),
            'import_sec_stocks_ajax'    => wp_create_nonce( 'stocks_ajax' ),
        );
        wp_localize_script( 'mrc_admin', 'mrc_obj', $arr );
        // Enqueued script with localized data.
        wp_enqueue_script( 'mrc_admin' );

        //css
        wp_enqueue_style( 'mrc_admin_style', plugin_dir_url( __DIR__ ) . 'assets/admin/css/mrc-cache.css', false, '1.0.0' );
        
    }

    /**
     * add submenu page menus to WooCommerce
     */     
    public function add_menu() {
        //general product importer and updater
     

        add_submenu_page(
            'woocommerce',
            'General Products Cache', 
            'General Products Cache', 
            'manage_options', 
            'gen_sch_cache', 
            array($this, 'gen_cache')
        );

    } 

    /**
     * ignore this for now
     */     
    public function page_importer() {
        if(!current_user_can('manage_options')) {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        // Render the settings template
        //include( sprintf( "%s/templates/template-importer.php", dirname( __FILE__ ) ) );
    }
   

    public function gen_cache() {
        if(!current_user_can('manage_options')) {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        ?>
            <div class="wrap">
                <h2>Generate JSON </h2>
                <p><i>Generate or update General Cache Products</i></p>
                <button class="generate-gen-cache button button-primary button-large">Generate</button>
                <div class="response-json"></div>
            </div>

            <div class="cf-spinner-wrapper"><div><div></div><div></div></div></div>

        <?php 
    }


}

new MRCREK_Settings();

