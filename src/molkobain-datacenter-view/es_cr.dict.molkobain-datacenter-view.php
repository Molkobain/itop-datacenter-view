<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */
Dict::Add('ES CR', 'Spanish', 'Español, Castellaño', array(
	// Classes
	// - Rack
	'Class:Rack/Attribute:nb_u+' => 'Height in units (U) of the rack~~',
	// - Enclosure
	'Class:Enclosure/Attribute:nb_u' => 'Height~~',
	'Class:Enclosure/Attribute:nb_u+' => 'Height in units (U) of the enclosure~~',
	'Class:Enclosure/Attribute:position_v' => 'Position~~',
	'Class:Enclosure/Attribute:position_v+' => 'Vertical position (U) of the enclosure in the rack (Must be the bottom position, not top)~~',
	// - Datacenter device
	'Class:DatacenterDevice/Attribute:nb_u' => 'Height~~',
	'Class:DatacenterDevice/Attribute:nb_u+' => 'Height in units (U) of the device~~',
	'Class:DatacenterDevice/Attribute:position_v' => 'Position~~',
	'Class:DatacenterDevice/Attribute:position_v+' => 'Vertical position (U) of the device in the enclosure (or rack if mounted directly on it). Must be the bottom position, not top.~~',

	// UI
	'Molkobain:DatacenterView:Tabs:View:Title' => 'Graphical view~~',
	'Molkobain:DatacenterView:NoElement' => 'No element~~',
	// - Legend
	'Molkobain:DatacenterView:Legend:Title' => 'Legend~~',
	// - Options
	'Molkobain:DatacenterView:Options:Title' => 'Options~~',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete' => 'Show obsolete elements~~',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete+' => 'Changing value will override the global user preference for this element only~~',
	// - Tooltip
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:base-info' => 'Base information~~',
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:more-info' => 'More information~~',
	// - Rack
	'Molkobain:DatacenterView:Rack:Panel:Front:Title' => 'Front~~',
	// - Enclosure
	'Molkobain:DatacenterView:Enclosure:Panel:Front:Title' => 'Front~~',
	// - Unmounted elements
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => 'Unmounted enclosures~~',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => 'Attached to this rack but no position set (Edit the enclosure to do so)~~',
	'Molkobain:DatacenterView:Unmounted:Devices:Title' => 'Unmounted devices~~',
	'Molkobain:DatacenterView:Unmounted:Devices:Title+' => 'Attached to this rack / enclosure but no position set (Edit the device to do so)~~',
));
