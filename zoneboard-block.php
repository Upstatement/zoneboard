<?php

class ZoneboardBlock {

	var $title;
	var $links;

	function __construct( $data ) {
		if ( is_array( $data ) || is_object( $data ) ) {
			$this->init_with_data( $data );
		}
	}

	function init_with_data( $data ) {
		$this->import( $data );
		if ( $this->icon ) {
			$this->icon = new ZoneboardBlockIcon( $this->icon );
		}
	}

	function import( $info ) {
		if ( is_object( $info ) ) {
			$info = get_object_vars( $info );
		}
		if ( is_array( $info ) ) {
			foreach ( $info as $key => $value ) {
				if ( !empty( $key ) ) {
					$this->$key = $value;
				}
			}
		}
	}

	function add_link( $label, $url ) {
		if ( !$this->links ) {
			$this->links = array();
		}
		$this->links[] = array( 'label' => $label, 'link' => $url );
	}

	function set_icon( $icon_name ) {

	}
}

class ZoneboardBlockIcon {

	function __construct( $icon_slug ) {
		$this->slug = $icon_slug;
		if ( strstr( $this->slug, 'fa-' ) ) {
			$this->class = 'fa';
		} else if ( strstr( $this->slug, 'dashicons-' ) ) {
				$this->class = 'dashicons';
			}
	}

	function __toString() {
		return $this->slug;
	}
}
