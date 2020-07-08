<?php

namespace TestInpsyde\Wp\Plugin\Traits;

trait Config_Trait {

	/**
	 * @param array $config
	 */
	public function bind_config( $config ) {
		foreach ( (array) $config as $attr_name => $attr_value ) {
			if ( property_exists( $this, $attr_name ) ) {
				$this->$attr_name = $attr_value;
			}
		}
	}
}
