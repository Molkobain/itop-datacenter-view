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
	'Class/Attribute:nb_u' => 'Hoogte',
	'Class/Attribute:nb_u+' => 'Hoogte van %1$s in units (U)',
	'Class/Attribute:position_v' => 'Positie',
	'Class/Attribute:position_v+/Variant:host' => 'Verticale positie (U) van %1$s in %2$s. Vanaf beneden.',
	'Class/Attribute:position_v+/Variant:device' => 'Verticale positie (U) van %1$s in de enclosure (of van de rack indien er rechtstreeks ingemonteerd). Vanaf beneden.',
	// Fieldsets
	'Fieldset:baseinfo' => 'Basisinfo',
	'Fieldset:moreinfo' => 'Meer info',
	'Fieldset:otherinfo' => 'Andere informatie',
	'Fieldset:dates' => 'Datum',
]);

// Classes
Dict::Add('NL NL', 'Dutch', 'Nederlands', array(
	// - LocationType
	'Class:LocationType' => 'Soort locatie',
	'Class:LocationType/Attribute:name' => 'Naam',
	'Class:LocationType/Attribute:name+' => 'Bijvoorbeeld: Land, Provincie, Gemeente, Gebouw, Verdieping, Ruimte, ...',
	'Class:LocationType/Attribute:locations_list' => 'Locaties',
	'Class:LocationType/Attribute:locations_list+' => 'Overzicht van alle locaties van dit type',
	// - Location
	'Class:Location/Attribute:locationtype_id' => 'Soort',
	'Class:Location/Attribute:locationtype_id+' => 'Welk soort locatie is dit of wat is het doel ervan?',
	'Class:Location/Attribute:parent_id' => 'Hoofdlocatie',
	'Class:Location/Attribute:parent_id+' => 'De overkoepelende locatie. Bv. een "ruimte" is een onderverdeling van een "verdieping" of "gebouw".',
	'Class:Location/Attribute:locations_list' => 'Sublocaties',
	'Class:Location/Attribute:locations_list+' => 'Overzicht van alle sublocaties die onder deze locatie vallen.',
	// - PhysicalDevice (default entries for custom classes)
	'Class:PhysicalDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PhysicalDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'dit toestel'),
	'Class:PhysicalDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	// Note: Physical device can be either an host (eg. enclosure) or a device (eg. server), so we use a generic sentence
	'Class:PhysicalDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'dit toestel', 'its host'),
	// - Rack
	'Class:Rack/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Rack/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'deze rack'),
	// - Enclosure
	'Class:Enclosure/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Enclosure/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'deze enclosure'),
	'Class:Enclosure/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:Enclosure/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'de enclosure', 'de rack'),
	'Enclosure:baseinfo' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Enclosure:moreinfo' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	'Enclosure:otherinfo' => sprintf($aMolkobainThesaurus['Fieldset:otherinfo']),
	'Enclosure:dates' => sprintf($aMolkobainThesaurus['Fieldset:dates']),
	// - Datacenter device
	'Class:DatacenterDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:DatacenterDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'dit toestel'),
	'Class:DatacenterDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:DatacenterDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'dit toestel'),
	// - PDU
	'Class:PDU/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PDU/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'deze PDU'),
	'Class:PDU/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:PDU/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'dit PDU'),
));

// UI
Dict::Add('NL NL', 'Dutch', 'Nederlands', array(
	'Molkobain:DatacenterView:Tabs:View:Title' => 'Grafische weergave',
	'Molkobain:DatacenterView:NoElement' => 'Geen object',
	// - Messages
	'Molkobain:DatacenterView:WarningMessage:NoHeightForHost' => 'No height defined for the element, devices might not display correctly.~~',
	// - Legend
	'Molkobain:DatacenterView:Legend:Title' => 'Legende',
	// - Filter
	'Molkobain:DatacenterView:Filter:Title' => 'Filter',
	'Molkobain:DatacenterView:Filter:Description' => 'Markeer overeenkomende namen of serie-/asset-nummers',
	'Molkobain:DatacenterView:Filter:Input:Placeholder' => 'Bv. PDU, Backup, 1234, ...',
	// - Options
	'Molkobain:DatacenterView:Options:Title' => 'Opties',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete' => 'Toon objecten die buiten dienst zijn',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete+' => 'Deze waarde is enkel van toepassing op dit object',
	// - Tooltip
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:base-info' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:more-info' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	// - Rack
	'Molkobain:DatacenterView:Rack:Panel:Front:Title' => 'Voorkant',
	// - Enclosure
	'Molkobain:DatacenterView:Enclosure:Panel:Front:Title' => 'Voorkant',
	// - Unmounted elements
	'Molkobain:DatacenterView:Unmounted:Toggler:Tooltip' => 'Verberg / Toon',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => 'Ongemonteerde enclosures',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => 'Horend bij dit rack, maar positie nog niet bepaald (bewerk de enclosure om dit te doen)',
	'Molkobain:DatacenterView:Unmounted:Devices:Title' => 'Ongemonteerde toestellen',
	'Molkobain:DatacenterView:Unmounted:Devices:Title+' => 'Horend bij dit rack/enclosure, maar positie nog niet bepaald (bewerk het toestel om dit te doen)',
));
