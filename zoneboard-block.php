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
		$this->handle_callbacks();
	}

	function handle_callbacks() {
		if (isset($this->callback) && is_string($this->callback)) {
			if (strstr($this->callback, '::')) {
				$funcs = explode('::', $this->callback);
				$class = $funcs[0];
				$this->callback = array('StoreyImport', 'render_dashboard_widget');
			}
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
