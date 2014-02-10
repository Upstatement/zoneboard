<?php

	class ChainsawDashboardBlock {

		var $title;
		var $links;

		function __construct($title = ''){
			$this->title = $title;
		}

		function add_link($label, $url){
			if (!$this->links){
				$this->links = array();
			}
			$this->links[] = array('label' => $label, 'link' => $url);
		}

		function set_icon($icon_name){
			
		}

	}