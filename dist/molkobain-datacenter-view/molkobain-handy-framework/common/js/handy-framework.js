/*
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

// Add new style to qTip if available
if($.isFunction($.fn.qtip))
{
	// - 'molkobain-base'
	$.fn.qtip.styles['molkobain-base'] = {
		name: 'light', // Inherit the rest of the attributes from the 'light' preset style
		classes: {
			tooltip: 'mhf-tooltip',
		},
		textAlign: 'left',
		border: {
			width: 0,
			radius: 0,
		},
		tip: {
			corner: 'leftMiddle',
			size: {x: 16, y: 8}, // Made for top/bottom position, overload for left/right positions
		},
	};
	// - 'molkobain-light'
	//   - For top/bottom positioning
	$.fn.qtip.styles['molkobain-light'] = {
		name: 'molkobain-base',
		color: '#444444',
		background: '#ffffff',
		border: {
			color: '#ffffff'
		},
		tip: {
			color: '#ffffff',
		},
	};
	//   - For left/right positioning
	$.fn.qtip.styles['molkobain-light-on-the-side'] = {
		name: 'molkobain-light',
		tip: {
			size: { x: 8, y: 16 },
		},
	};
	// - 'molkobain-dark'
	//   - For top/bottom positioning
	$.fn.qtip.styles['molkobain-dark'] = {
		name: 'molkobain-base', // Inherit the rest of the attributes from the 'light' preset style
		color: '#f3f3f3',
		background: '#000000',
		border: {
			color: '#000000'
		},
		tip: {
			color: '#000000',
		},
	};
	//   - For left/right positioning
	$.fn.qtip.styles['molkobain-dark-on-the-side'] = {
		name: 'molkobain-dark',
		tip: {
			size: { x: 8, y: 16 },
		},
	}
}

// Panels
// - Toggler
$(document).on('click', '.mhf-panel .mhf-ph-toggler', function(oEvent){
	oEvent.stopPropagation();
	$(this).closest('.mhf-panel').toggleClass('mhf-collapsed');
});