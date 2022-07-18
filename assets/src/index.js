/* global ethEmbedAnchorFm */

import { Path, SVG } from '@wordpress/components';
import { addFilter, removeFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';

const blockName = 'core/embed';
const filterTag = 'blocks.registerBlockType';
const namespace = 'eth-embed-anchor-fm/register-block-core-embed';

const providerName = 'anchor-fm-inc';

addFilter( filterTag, namespace, ( settings, name ) => {
	if ( name !== blockName ) {
		return settings;
	}

	removeFilter( filterTag, namespace );

	settings.variations.push( {
		name: providerName,
		title: __( 'Anchor.fm', 'eth-embed-anchor-fm' ),
		icon: (
			<SVG viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<Path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm.5 16c0 .3-.2.5-.5.5H5c-.3 0-.5-.2-.5-.5V9.8l4.7-5.3H19c.3 0 .5.2.5.5v14zM13.2 7.7c-.4.4-.7 1.1-.7 1.9v3.7c-.4-.3-.8-.4-1.3-.4-1.2 0-2.2 1-2.2 2.2 0 1.2 1 2.2 2.2 2.2.5 0 1-.2 1.4-.5.9-.6 1.4-1.6 1.4-2.6V9.6c0-.4.1-.6.2-.8.3-.3 1-.3 1.6-.3h.2V7h-.2c-.7 0-1.8 0-2.6.7z" />
			</SVG>
		),
		keywords: [
			__( 'podcast', 'eth-embed-anchor-fm' ),
			__( 'embed', 'eth-embed-anchor-fm' ),
		],
		description: __( 'Embed an Anchor.fm podcast.', 'eth-embed-anchor-fm' ),
		patterns: [ /^https:\/\/anchor\.fm\/[^\/]+\/episodes\/.+/i ],
		attributes: { providerNameSlug: providerName, responsive: false },
	} );

	return settings;
} );
