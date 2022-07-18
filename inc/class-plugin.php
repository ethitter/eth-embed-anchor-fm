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
	use Singleton;

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
	 * Shortcode tag.
	 *
	 * @var string
	 */
	private const SHORTCODE_TAG = 'eth_anchor_fm';

	public function __get( $name ): ?string {
		if ( 'url_regex' === $name ) {
			return self::OEMBED_FORMAT;
		}

		return null;
	}

	public function __set( string $name, string $value ): bool {
		return false;
	}

	public function __isset( $name ): bool {
		return 'url_regex' === $name;
	}

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	protected function _setup(): void {
		add_action( 'init', [ $this, 'action_init' ] );

		add_filter(
			'oembed_fetch_url',
			[ $this, 'filter_oembed_fetch_url' ],
			10,
			3
		);
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

		add_shortcode(
			self::SHORTCODE_TAG,
			[ $this, 'do_shortcode' ]
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

	/**
	 * Render Anchor.fm iframe embed via a shortcode.
	 *
	 * @param array $attrs Shortcode attributes.
	 * @return string
	 */
	public function do_shortcode( array $attrs ): string {
		$attrs = shortcode_atts(
			[
				'src'    => null,
				'url'    => null,
				'width'  => '400px',
				'height' => '102px',
			],
			$attrs,
			self::SHORTCODE_TAG
		);

		// Fallback in case one passes `url` rather than `src`.
		if ( empty( $attrs['src'] ) && ! empty( $attrs['url'] ) ) {
			$attrs['src'] = $attrs['url'];
		}

		if ( empty( $attrs['src'] ) ) {
			return '';
		}

		return sprintf(
			'<iframe src="%1$s" width="%2$s" height="%3$s" frameborder="0" scrolling="no"></iframe>',
			esc_url( $attrs['src'] ),
			esc_attr( $attrs['width'] ),
			esc_attr( $attrs['height'] )
		);
	}
}
