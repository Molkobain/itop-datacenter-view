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
	'Class/Attribute:position_v+/Variant:device' => 'Vertical position (U) of %1$s in chassi (or rack if mounted directly on int). (Must be the bottom position, not top)',

	// Fieldsets
	'Fieldset:baseinfo' => 'General information',
	'Fieldset:moreinfo' => 'More information',
	'Fieldset:otherinfo' => 'Other information',
	'Fieldset:dates' => 'Dates',
]);

// Classes
Dict::Add('SV SV', 'Swedish', 'Svenska', array(
	// - LocationType
	'Class:LocationType' => 'Typ av plats',
	'Class:LocationType/Attribute:name' => 'Namn',
	'Class:LocationType/Attribute:name+' => 'Till exempel: Land, Län, Stad, Byggnad, Våning, Rum, ...',
	'Class:LocationType/Attribute:locations_list' => 'Platser',
	'Class:LocationType/Attribute:locations_list+' => 'Lista över alla platser av denna typ',
	// - Location
	'Class:Location/Attribute:locationtype_id' => 'Typ',
	'Class:Location/Attribute:locationtype_id+' => 'Vilken sort av plats är detta eller vilket syfte den har?',
	'Class:Location/Attribute:parent_id' => 'Huvudplats',
	'Class:Location/Attribute:parent_id+' => 'plats som hostar denna (ex. för ett \'rum\', skal vara en \'våning\' eller en \'byggnad\')',
	'Class:Location/Attribute:locations_list' => 'Inkluderade platser',
	'Class:Location/Attribute:locations_list+' => 'Lista över alla platser som är inkluderade i denna',
	// - PhysicalDevice (default entries for custom classes)
	'Class:PhysicalDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PhysicalDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'element'),
	'Class:PhysicalDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	// Note: Physical device can be either an host (eg. enclosure) or a device (eg. server), so we use a generic sentence
	'Class:PhysicalDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'element', 'dess host'),
	// - Rack
	'Class:Rack/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Rack/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'rack'),
	// - Enclosure
	'Class:Enclosure/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Enclosure/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'chassi'),
	'Class:Enclosure/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:Enclosure/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'chassi', 'rack'),
	'Enclosure:baseinfo' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Enclosure:moreinfo' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	'Enclosure:otherinfo' => sprintf($aMolkobainThesaurus['Fieldset:otherinfo']),
	'Enclosure:dates' => sprintf($aMolkobainThesaurus['Fieldset:dates']),
	// - Datacenter device
	'Class:DatacenterDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:DatacenterDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'enhet'),
	'Class:DatacenterDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:DatacenterDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'enhet'),
	// - PDU
	'Class:PDU/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PDU/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'enhet'),
	'Class:PDU/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:PDU/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'Strömenhet'),
));

// UI
Dict::Add('SV SV', 'Swedish', 'Svenska', array(
	'Molkobain:DatacenterView:Tabs:View:Title' => 'Graphisk vy',
	'Molkobain:DatacenterView:NoElement' => 'Inget element',
	// - Legend
	'Molkobain:DatacenterView:Legend:Title' => 'Legend',
	// - Filter
	'Molkobain:DatacenterView:Filter:Title' => 'Filter',
	'Molkobain:DatacenterView:Filter:Description' => 'Markera matchande namn eller serial- / katalognummer',
	'Molkobain:DatacenterView:Filter:Input:Placeholder' => 'eg. PDU, Backup, 1234, ...',
	// - Options
	'Molkobain:DatacenterView:Options:Title' => 'Options',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete' => 'Visa föråldrade element',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete+' => 'Ándring av detta värde överskriver globala användarinställningen endast för detta element',
	// - Tooltip
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:base-info' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:more-info' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	// - Rack
	'Molkobain:DatacenterView:Rack:Panel:Front:Title' => 'Front',
	// - Enclosure
	'Molkobain:DatacenterView:Enclosure:Panel:Front:Title' => 'Front',
	// - Unmounted elements
	'Molkobain:DatacenterView:Unmounted:Toggler:Tooltip' => 'Fäll ihop / Fäll ut',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => 'Okopplade chassi',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => 'Kopplad till denna rack men utan angiven position (Ändra chassi för att ange den)',
	'Molkobain:DatacenterView:Unmounted:Devices:Title' => 'Okopplade enhet',
	'Molkobain:DatacenterView:Unmounted:Devices:Title+' => 'Kopplad till denna rack / chassi men utan angiven position (Ändra enhet för att ange den)',
));
