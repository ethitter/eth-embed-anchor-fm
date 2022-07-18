/* global ethEmbedAnchorFm */

import { addFilter, removeFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';

const blockName = 'core/embed';
const filterTag = 'blocks.registerBlockType';
const namespace = 'eth-embed-anchor-fm/register-block-core-embed';

const { name: providerName, patterns } = ethEmbedAnchorFm;

addFilter( filterTag, namespace, ( settings, name ) => {
	if ( name !== blockName ) {
		return settings;
	}

	removeFilter( filterTag, namespace );

	settings.variations.push( {
		name: providerName,
		title: __( 'Anchor.fm', 'eth-embed-anchor-fm' ),
		// icon: embedTwitterIcon,
		keywords: [
			__( 'podcast', 'eth-embed-anchor-fm' ),
			__( 'embed', 'eth-embed-anchor-fm' ),
		],
		description: __( 'Embed an Anchor.fm podcast.', 'eth-embed-anchor-fm' ),
		patterns,
		attributes: { providerNameSlug: providerName, responsive: false },
	} );

	return settings;
} );
