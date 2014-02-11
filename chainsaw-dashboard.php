<?php
	/*
	Plugin Name: Chainsaw Dashboard
	Plugin URI: http://upstatement.com/plugins/chainsaw-dashboard
	Description: Cleans up the WordPress Dashboard
	Version: 0.1
	Author: Upstatement
	*/

	require_once('chainsaw-dashboard-block.php');

	class ChainsawDashboard {

		var $_bricks;

		function __construct($json_file){
			//self::clear();
			add_action('admin_menu', array( $this,'register_menu') );
    		add_action('load-index.php', array( $this,'redirect_dashboard') );
    		$this->load_json($json_file);
		}

		function load_json($json_file){
			$json = file_get_contents(ABSPATH.$json_file);
			$json = json_decode($json);
			$this->_bricks = $json->bricks;
		}

		function redirect_dashboard(){
			if( is_admin() ) {
				$screen = get_current_screen();
				if($screen->base == 'dashboard') {
					wp_redirect( admin_url( 'index.php?page=custom-dashboard' ) );
				}
			}
		}

		function register_menu(){
			 add_dashboard_page( 'Dashboard', 'Dashboard', 'read', 'custom-dashboard', array( $this,'create_dashboard') );
		}

		function create_dashboard(){
			require_once( ABSPATH . 'wp-load.php' );
			require_once( ABSPATH . 'wp-admin/admin.php' );
			require_once( ABSPATH . 'wp-admin/admin-header.php' );
			$data = array();
			$data['site'] = new TimberSite();
			$data['bricks'] = $this->_bricks;
			Timber::render('dashboard.twig', $data);
		}

		public function add($block){
			if (!$this->_bricks){
				$this->_bricks = array();
			}
			if (is_array($block)){
				foreach($block as $b){
					$this->_bricks[] = $b;
				}
			} else {
				$this->_bricks[] = $block;
			}
		}


	}