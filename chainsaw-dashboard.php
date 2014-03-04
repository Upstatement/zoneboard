<?php
	/*
	Plugin Name: Chainsaw Dashboard
	Plugin URI: http://upstatement.com/plugins/chainsaw-dashboard
	Description: Cleans up the WordPress Dashboard
	Version: 0.1
	Author: Upstatement
	*/

	require_once('chainsaw-dashboard-brick.php');

	class ChainsawDashboard {

		var $_bricks;
		var $vars;

		function __construct($json_file){
			//self::clear();
			add_action('admin_menu', array( $this,'register_menu') );
    		add_action('load-index.php', array( $this,'redirect_dashboard') );
    		add_filter('get_twig', array($this, 'add_twig_extensions'));
    		$this->vars = array();
    		$this->load_json($json_file);
		}

		function add_twig_extensions($twig){
			$twig->addExtension(new Twig_Extension_StringLoader());
			return $twig;
		}

		function load_json($json_file){
			$json = file_get_contents(ABSPATH.$json_file);
			$json = json_decode($json);
			foreach($json->bricks as &$brick){
				$brick = new ChainsawDashboardBrick($brick);
			}
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
			foreach($this->vars as $key=>$var){
				$data[$key] = $var;
			}
			Timber::render('dashboard.twig', $data);
		}

		public function add_var($var_name, $callback){
			if (is_callable($callback)){
				$callback = $callback();
			}
			$this->vars[$var_name] = $callback;
		}

		public function add_brick($block){
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