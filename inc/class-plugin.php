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
	 * Regex pattern to match URL to be oEmbedded.
	 *
	 * @var string
	 */
	private const OEMBED_FORMAT = '#^https://anchor\.fm/(?!api)([^/]+)/episodes/([^/\s]+)/?#i';

	/**
	 * Anchor oEmbed endpoint with placeholder.
	 *
	 * @var string
	 */
	private const OEMBED_ENDPOINT = 'https://anchor.fm/api/v3/episodes/__EPISODE_ID__/oembed';

	/**
	 * Placeholder in self::OEMBED_ENDPOINT to be replaced with episode ID.
	 *
	 * @var string
	 */
	private const EPISODE_ID_PLACEHOLDER = '__EPISODE_ID__';

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
	private function _setup(): void {
		add_action( 'init', [ $this, 'action_init' ] );
		add_filter(
			'oembed_fetch_url',
			[ $this, 'filter_oembed_fetch_url' ],
			10,
			3
		);

		// TODO: add shortcode.
	}

	/**
	 * Register oEmbed handler.
	 *
	 * @return void
	 */
	public function action_init(): void {
		wp_oembed_add_provider(
			self::OEMBED_FORMAT,
			self::OEMBED_ENDPOINT,
			true
		);
	}

	/**
	 * Filter oEmbed URL.
	 *
	 * Anchor.fm's oEmbed endpoint is specific to an episode ID, which must be
	 * extracted from the episode URL.
	 *
	 * @param string $provider URL of the oEmbed provider.
	 * @param string $url      URL of the content to be embedded.
	 * @param array  $args     Optional. Additional arguments for retrieving
	 *                         embed HTML.
	 * @return string
	 */
	public function filter_oembed_fetch_url(
		string $provider,
		string $url,
		array $args = []
	): string {
		if ( 0 !== stripos( $provider, self::OEMBED_ENDPOINT ) ) {
			return $provider;
		}

		if ( ! preg_match( self::OEMBED_FORMAT, $url, $matches ) ) {
			return '';
		}

		$episode_slug_parts = explode( '-', $matches[2] );
		$id                 = array_pop( $episode_slug_parts );

		$provider = str_replace(
			self::EPISODE_ID_PLACEHOLDER,
			$id,
			self::OEMBED_ENDPOINT
		);

		// Anchor.fm's oEmbed endpoint offers limited support for arguments.
		if ( isset( $args['width'], $args['height'] ) ) {
			$provider = add_query_arg(
				[
					'maxwidth'  => (int) $args['width'],
					'maxheight' => (int) $args['height'],
				],
				$provider
			);
		}

		return $provider;
	}
}
