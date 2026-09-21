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
	'Class/Attribute:nb_u' => 'Výška',
	'Class/Attribute:nb_u+' => 'Výška v jednotkách (U) z %1$s',
	'Class/Attribute:position_v' => 'Pozice',
	'Class/Attribute:position_v+/Variant:host' => 'Svislá pozice (U) z %1$s v %2$s (Musí být spodní pozici, nikoli horní)',
	'Class/Attribute:position_v+/Variant:device' => 'Svislá pozice (U) z %1$s ve skříni (nebo racku pokud je na něj přímo připojen). (Musí být na spodní pozici, nikoli horní)',

	// Fieldsets
	'Fieldset:baseinfo' => 'Obecné informace',
	'Fieldset:moreinfo' => 'Více informací',
	'Fieldset:otherinfo' => 'Další informace',
	'Fieldset:dates' => 'Datumy',
]);

// Classes
Dict::Add('CS CZ', 'Czech', 'Čeština', array(
	// - LocationType
	'Class:LocationType' => 'Typy míst',
	'Class:LocationType/Attribute:name' => 'Jméno',
	'Class:LocationType/Attribute:name+' => 'Například: Země, Kraj, Město, Budova, Podlaží, Místnost, ...',
	'Class:LocationType/Attribute:locations_list' => 'Místa',
	'Class:LocationType/Attribute:locations_list+' => 'Seznam všech místo tohoto typu',
	// - Location
	'Class:Location/Attribute:locationtype_id' => 'Typ',
	'Class:Location/Attribute:locationtype_id+' => 'O jaký druh místa se jedná, popř. jaký má význam?',
	'Class:Location/Attribute:parent_id' => 'Rodič',
	'Class:Location/Attribute:parent_id+' => 'Místo, na kterém se nachází (např. pro  \'místnost\', by mělo být \'podlaží\' nebo \'budova\')',
	'Class:Location/Attribute:locations_list' => 'Podřízená místa',
	'Class:Location/Attribute:locations_list+' => 'Seznam všech míst zde obsažených',
	// - PhysicalDevice (default entries for custom classes)
	'Class:PhysicalDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PhysicalDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'prvek'),
	'Class:PhysicalDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	// Note: Physical device can be either an host (eg. enclosure) or a device (eg. server), so we use a generic sentence
	'Class:PhysicalDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'prvek', 'jeho hostitel'),
	// - Rack
	'Class:Rack/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Rack/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'rack'),
	// - Enclosure
	'Class:Enclosure/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Enclosure/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'skříň'),
	'Class:Enclosure/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:Enclosure/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'skříň', 'rack'),
	'Enclosure:baseinfo' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Enclosure:moreinfo' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	'Enclosure:otherinfo' => sprintf($aMolkobainThesaurus['Fieldset:otherinfo']),
	'Enclosure:dates' => sprintf($aMolkobainThesaurus['Fieldset:dates']),
	// - Datacenter device
	'Class:DatacenterDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:DatacenterDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'zařízení'),
	'Class:DatacenterDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:DatacenterDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'zařízení'),
	// - PDU
	'Class:PDU/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PDU/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'zařízení'),
	'Class:PDU/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:PDU/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'napájení'),
));

// UI
Dict::Add('CS CZ', 'Czech', 'Čeština', array(
	'Molkobain:DatacenterView:Tabs:View:Title' => 'Grafické zobrazení',
	'Molkobain:DatacenterView:NoElement' => 'Žádný prvek',
	// - Messages
	'Molkobain:DatacenterView:WarningMessage:NoHeightForHost' => 'Není definována výška pro tento prvek, umístění zařízení nemusí být správně zobrazeno!',
	// - Legend
	'Molkobain:DatacenterView:Legend:Title' => 'Legenda',
	// - Filter
	'Molkobain:DatacenterView:Filter:Title' => 'Filtr',
	'Molkobain:DatacenterView:Filter:Description' => 'Zvýrazní shodné názvy nebo sériová čísla / katalogová čísla',
	'Molkobain:DatacenterView:Filter:Input:Placeholder' => 'eg. PDU, Backup, 1234, ...',
	// - Options
	'Molkobain:DatacenterView:Options:Title' => 'Nastavení',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete' => 'Zobrazit zastaralé prvky',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete+' => 'Změna hodnoty přepíše všeobecné nastavení pouze tohoto prvku',
	// - Tooltip
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:base-info' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:more-info' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	// - Rack
	'Molkobain:DatacenterView:Rack:Panel:Front:Title' => 'Čelo',
	// - Enclosure
	'Molkobain:DatacenterView:Enclosure:Panel:Front:Title' => 'Přední čast',
	// - Unmounted elements
	'Molkobain:DatacenterView:Unmounted:Toggler:Tooltip' => 'Sbalit / Rozbalit',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => 'Neumístěná šasi',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => 'Šasi je umístěno v tomto racku, ale nemá nastavenu pozici (přetažením/editací umístíte šasi v racku na příslušnou pozici)',
	'Molkobain:DatacenterView:Unmounted:Devices:Title' => 'Neumístěná zařízení',
	'Molkobain:DatacenterView:Unmounted:Devices:Title+' => 'Zařízení je umístěno v tomuto racku, ale nemá nastavenu pozici (přetažením/editací umístíte zařízení v racku na příslušnou pozici)',
));
