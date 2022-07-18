<?php
/**
 * Plugin Name: ETH Embed Anchor.fm
 * Plugin URI: https://ethitter.com/plugins/eth-embed-anchor-fm/
 * Description: Add Anchor.fm oEmbed support to WordPress.
 * Version: 0.1
 * Author: Erick Hitter
 * Author URI: https://ethitter.com/
 * Text Domain: eth-embed-anchor-fm
 * Domain Path: /languages/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package ETH_Embed_Anchor_FM
 */

namespace ETH_Embed_Anchor_FM;

/**
 * Perform setup actions after plugin loads.
 *
 * @return void
 */
function action_plugins_loaded() {
	load_plugin_textdomain(
		'eth-embed-anchor-fm',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages/'
	);
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\action_plugins_loaded' );

/**
 * Load plugin classes.
 */
require_once __DIR__ . '/inc/trait-singleton.php';
require_once __DIR__ . '/inc/class-plugin.php';
require_once __DIR__ . '/inc/class-block-editor.php';

Plugin::get_instance();
Block_Editor::get_instance();
