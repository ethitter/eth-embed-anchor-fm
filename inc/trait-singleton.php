<?php
/**
 * Singleton trait.
 *
 * @package ETH_Embed_Anchor_FM
 */

namespace ETH_Embed_Anchor_FM;

/**
 * Trait Singleton.
 */
trait Singleton {
	/**
	 * Singleton.
	 *
	 * @var self
	 */
	private static $_instance = null;

	/**
	 * Implement singleton.
	 *
	 * @return self
	 */
	public static function get_instance(): self {
		if ( ! is_a( self::$_instance, __CLASS__ ) ) {
			self::$_instance = new self();
			self::$_instance->_setup();
		}

		return self::$_instance;
	}

	/**
	 * Silence is golden!
	 */
	private function __construct() {
		// Add nothing here.
	}

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	abstract function _setup(): void;
}
