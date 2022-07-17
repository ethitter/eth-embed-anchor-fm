<?php
/**
 * Plugin functionality.
 *
 * @package ETH_Embed_Anchor_FM
 */

namespace ETH_Embed_Anchor_FM;

/**
 * Class Plugin.
 */
class Plugin {
	/**
	 * Singleton.
	 *
	 * @var Plugin
	 */
	private static $_instance = null;

	/**
	 * Implement singleton.
	 *
	 * @return Plugin
	 */
	public static function get_instance(): Plugin {
		if ( ! is_a( self::$_instance, __CLASS__ ) ) {
			self::$_instance = new self();
			self::$_instance->setup();
		}

		return self::$_instance;
	}

	/**
	 * Silence is golden!
	 */
	private function __construct() {}

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	private function setup(): void {
		// TODO: add oEmbed handler.
		// TODO: add shortcode.
	}
}
