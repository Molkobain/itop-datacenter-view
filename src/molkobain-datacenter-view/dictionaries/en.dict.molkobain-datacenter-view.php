<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

if(!isset($aMolkobainThesaurus)) $aMolkobainThesaurus = [];
/** @var array $aMolkobainThesaurus Used to centralize from strings and use them in the dict. entries */
$aMolkobainThesaurus = array_merge($aMolkobainThesaurus, [
	// Datamodel
	'Class/Attribute:nb_u' => 'Height',
	'Class/Attribute:nb_u+' => 'Height in units (U) of %1$s',
	'Class/Attribute:position_v' => 'Position',
	'Class/Attribute:position_v+/Variant:host' => 'Vertical position (U) of %1$s in %2$s (Must be the bottom position, not top)',
	'Class/Attribute:position_v+/Variant:device' => 'Vertical position (U) of %1$s in the enclosure (or rack if mounted directly on int). (Must be the bottom position, not top)',

	// Fieldsets
	'Fieldset:baseinfo' => 'General information',
	'Fieldset:moreinfo' => 'More information',
	'Fieldset:otherinfo' => 'Other information',
	'Fieldset:dates' => 'Dates',
]);

// Classes
Dict::Add('EN US', 'English', 'English', array(
	// - LocationType
	'Class:LocationType' => 'Location type',
	'Class:LocationType/Attribute:name' => 'Name',
	'Class:LocationType/Attribute:name+' => 'For example: Country, State, City, Building, Floor, Room, ...',
	'Class:LocationType/Attribute:locations_list' => 'Locations',
	'Class:LocationType/Attribute:locations_list+' => 'List of all locations of this type',
	// - Location
	'Class:Location/Attribute:locationtype_id' => 'Type',
	'Class:Location/Attribute:locationtype_id+' => 'What kind of location is it or what purpose does it have?',
	'Class:Location/Attribute:parent_id' => 'Parent',
	'Class:Location/Attribute:parent_id+' => 'Location hosting this one (eg. For a \'room\', should be a \'floor\' or a \'building\')',
	'Class:Location/Attribute:locations_list' => 'Child locations',
	'Class:Location/Attribute:locations_list+' => 'List of all locations included in this one',
	// - PhysicalDevice (default entries for custom classes)
	'Class:PhysicalDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PhysicalDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'the element'),
	'Class:PhysicalDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	// Note: Physical device can be either an host (eg. enclosure) or a device (eg. server), so we use a generic sentence
	'Class:PhysicalDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'the element', 'its host'),
	// - Rack
	'Class:Rack/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Rack/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'the rack'),
	// - Enclosure
	'Class:Enclosure/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Enclosure/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'the enclosure'),
	'Class:Enclosure/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:Enclosure/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'the enclosure', 'the rack'),
	'Enclosure:baseinfo' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Enclosure:moreinfo' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	'Enclosure:otherinfo' => sprintf($aMolkobainThesaurus['Fieldset:otherinfo']),
	'Enclosure:dates' => sprintf($aMolkobainThesaurus['Fieldset:dates']),
	// - Datacenter device
	'Class:DatacenterDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:DatacenterDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'the device'),
	'Class:DatacenterDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:DatacenterDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'the device'),
	// - PDU
	'Class:PDU/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PDU/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'the device'),
	'Class:PDU/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:PDU/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'the PDU'),
));

// UI
Dict::Add('EN US', 'English', 'English', array(
	'Molkobain:DatacenterView:Tabs:View:Title' => 'Graphical view',
	'Molkobain:DatacenterView:NoElement' => 'No element',
	// - Messages
	'Molkobain:DatacenterView:WarningMessage:NoHeightForHost' => 'No height defined for the element, devices might not display correctly.',
	// - Legend
	'Molkobain:DatacenterView:Legend:Title' => 'Legend',
	// - Filter
	'Molkobain:DatacenterView:Filter:Title' => 'Filter',
	'Molkobain:DatacenterView:Filter:Description' => 'Highlight matching names or serial / asset numbers',
	'Molkobain:DatacenterView:Filter:Input:Placeholder' => 'eg. PDU, Backup, 1234, ...',
	// - Options
	'Molkobain:DatacenterView:Options:Title' => 'Options',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete' => 'Show obsolete elements',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete+' => 'Changing value will override the global user preference for this element only',
	// - Tooltip
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:base-info' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:more-info' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	// - Rack
	'Molkobain:DatacenterView:Rack:Panel:Front:Title' => 'Front',
	// - Enclosure
	'Molkobain:DatacenterView:Enclosure:Panel:Front:Title' => 'Front',
	// - Unmounted elements
	'Molkobain:DatacenterView:Unmounted:Toggler:Tooltip' => 'Collapse / Expand',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => 'Unmounted enclosures',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => 'Attached to this rack but no position set (Edit the enclosure to do so)',
	'Molkobain:DatacenterView:Unmounted:Devices:Title' => 'Unmounted devices',
	'Molkobain:DatacenterView:Unmounted:Devices:Title+' => 'Attached to this rack / enclosure but no position set (Edit the device to do so)',
));
