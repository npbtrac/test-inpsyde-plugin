<?php


namespace TestInpsyde\Wp\Plugin\Traits;


use Illuminate\Container\Container;

trait Service_Trait {
	/**
	 * @var Container|null
	 */
	protected $_container = null;

	abstract public function init();

	/**
	 * @param Container $container
	 */
	public function set_container( Container $container ) {
		if ( null === $this->_container ) {
			$this->_container = $container;
		}
	}

	/**
	 * @return Container
	 */
	public function get_container(): Container {
		return $this->_container;
	}
}
