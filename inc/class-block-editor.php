<?php
/**
 * Block Editor integration.
 *
 * @package ETH_Embed_Anchor_FM
 */

namespace ETH_Embed_Anchor_FM;

/**
 * Class Block_Editor.
 */
class Block_Editor {
	use Singleton;

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	protected function _setup(): void {
		add_action(
			'enqueue_block_editor_assets',
			[ $this, 'action_enqueue_block_editor_assets' ]
		);
	}

	/**
	 * Enqueue block editor assets.
	 *
	 * @return void
	 */
	public function action_enqueue_block_editor_assets(): void {
		$asset_data = require dirname( __FILE__, 2 )
			. '/assets/build/index.asset.php';

		wp_enqueue_script(
			'eth-embed-anchor-fm-block-editor',
			plugins_url(
				'assets/build/index.js',
				dirname( __FILE__, 2 )
					. '/eth-embed-anchor-fm.php'
			),
			$asset_data['dependencies'],
			$asset_data['version'],
			true
		);
	}
}
