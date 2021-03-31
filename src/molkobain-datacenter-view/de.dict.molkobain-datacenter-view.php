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
	'Class/Attribute:nb_u' => 'Höhe',
	'Class/Attribute:nb_u+' => 'Höheneinheiten (HE) von %1$s',
	'Class/Attribute:position_v' => 'Position',
	'Class/Attribute:position_v+/Variant:host' => 'Vertikale Position (HE) von %1$s in %2$s (Muss die unterste Position sein, nicht die obere)',
	'Class/Attribute:position_v+/Variant:device' => 'Vertikale Position (HE) von %1$s im Gehäuse (oder im Rack sofern direkt verbaut). (Muss die unterste Position sein, nicht die obere)',

	// Fieldsets
	'Fieldset:baseinfo' => 'Allgemein Information',
	'Fieldset:moreinfo' => 'Weitere Information',
	'Fieldset:otherinfo' => 'Andere Information',
	'Fieldset:dates' => 'Daten',
]);

// Classes
Dict::Add('DE DE', 'German', 'German', array(
	// - LocationType
	'Class:LocationType' => 'Standort-Typ',
	'Class:LocationType/Attribute:name' => 'Name',
	'Class:LocationType/Attribute:name+' => 'Zum Bsp: Land, Bundesland, Stadt, Gebäude, Stockwerk, Raum, ...',
	'Class:LocationType/Attribute:locations_list' => 'Standorte',
	'Class:LocationType/Attribute:locations_list+' => 'Liste aller Standorte diesen Typs',
	// - Location
	'Class:Location/Attribute:locationtype_id' => 'Typ',
	'Class:Location/Attribute:locationtype_id+' => 'Welche Art von Standort ist es und welchen Zweck hat es?',
	'Class:Location/Attribute:parent_id' => 'Eltern',
	'Class:Location/Attribute:parent_id+' => 'Standort, wo sich dies befindet (z.B. ein \'Raum\', \'Stockwerk\' or a \'Gebäude\')',
	'Class:Location/Attribute:locations_list' => '´Kinder-Standorte',
	'Class:Location/Attribute:locations_list+' => 'Liste aller beinhalteten Standorte',
	// - PhysicalDevice (default entries for custom classes)
	'Class:PhysicalDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PhysicalDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'Das Element'),
	'Class:PhysicalDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	// Note: Physical device can be either an host (eg. enclosure) or a device (eg. server), so we use a generic sentence
	'Class:PhysicalDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'Das Element', 'Sein Host'),
	// - Rack
	'Class:Rack/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Rack/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'Das Rack'),
	// - Enclosure
	'Class:Enclosure/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Enclosure/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'Das Gehäuse'),
	'Class:Enclosure/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:Enclosure/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'Das Gehäuse', 'Das Rack'),
	'Enclosure:baseinfo' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Enclosure:moreinfo' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	'Enclosure:otherinfo' => sprintf($aMolkobainThesaurus['Fieldset:otherinfo']),
	'Enclosure:dates' => sprintf($aMolkobainThesaurus['Fieldset:dates']),
	// - Datacenter device
	'Class:DatacenterDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:DatacenterDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'Das Gerät'),
	'Class:DatacenterDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:DatacenterDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'Das Gerät'),
	// - PDU
	'Class:PDU/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PDU/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'Das Gerät'),
	'Class:PDU/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:PDU/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'Die PDU'),
));

// UI
Dict::Add('DE DE', 'Deutsch', 'Deutsch', array(
	'Molkobain:DatacenterView:Tabs:View:Title' => 'Grafische Ansicht',
	'Molkobain:DatacenterView:NoElement' => 'Das Element',
	// - Legend
	'Molkobain:DatacenterView:Legend:Title' => 'Legende',
	// - Filter
	'Molkobain:DatacenterView:Filter:Title' => 'Filter',
	'Molkobain:DatacenterView:Filter:Description' => 'Namen oder Serien-/Gerätenummern hervorheben',
	'Molkobain:DatacenterView:Filter:Input:Placeholder' => 'z.B. PDU, Backup, 1234, ...',
	// - Options
	'Molkobain:DatacenterView:Options:Title' => 'Optionen',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete' => 'Zeige obsolete Elemente',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete+' => 'Änderungen des Wertes überschreiben die globale Benutzereinstellung nur für dieses Element',
	// - Tooltip
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:base-info' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:more-info' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	// - Rack
	'Molkobain:DatacenterView:Rack:Panel:Front:Title' => 'Vorderseite',
	// - Enclosure
	'Molkobain:DatacenterView:Enclosure:Panel:Front:Title' => 'Vorderseite',
	// - Unmounted elements
	'Molkobain:DatacenterView:Unmounted:Toggler:Tooltip' => 'Erweitern / Ausklappen',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => 'Nicht-verbaute Gehäuse',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => 'In diesem Rack verbaut, keine zugewiesene Position (Änderungen unter "Gehäuse" möglich)',
	'Molkobain:DatacenterView:Unmounted:Devices:Title' => 'Nicht-verbaute Geräte',
	'Molkobain:DatacenterView:Unmounted:Devices:Title+' => 'In diesem Rack/Gehäuse verbaut, keine zugewiesene Position (Änderungen unter "Gerät" möglich)',
));
