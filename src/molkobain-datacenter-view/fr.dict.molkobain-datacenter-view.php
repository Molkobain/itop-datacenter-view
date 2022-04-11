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
	'Class/Attribute:nb_u' => 'Hauteur',
	'Class/Attribute:nb_u+' => 'Hauteur %1$s en unités (U)',
	'Class/Attribute:position_v' => 'Position',
	'Class/Attribute:position_v+/Variant:host' => 'Position verticale (U) %1$s dans %2$s (Doit faire référence au bas %1$s et non au haut)',
	'Class/Attribute:position_v+/Variant:device' => 'Position verticale (U) %1$s dans le châssis (ou rack si monté directement dessus). (Doit faire référence au bas %1$s et non au haut)',
	// Fieldsets
	'Fieldset:baseinfo' => 'Informations générales',
	'Fieldset:moreinfo' => 'Informations complémentaires',
	'Fieldset:otherinfo' => 'Autres informations',
	'Fieldset:dates' => 'Dates',
]);

// Classes
Dict::Add('FR FR', 'French', 'Français', array(
	// - LocationType
	'Class:LocationType' => 'Type de lieu',
	'Class:LocationType/Attribute:name' => 'Nom',
	'Class:LocationType/Attribute:name+' => 'Par exemple : Pays, Région, Ville, Bâtiment, Etage, Salle ...',
	'Class:LocationType/Attribute:locations_list' => 'Lieux',
	'Class:LocationType/Attribute:locations_list+' => 'Liste des lieux de ce type',
	// - Location
	'Class:Location/Attribute:locationtype_id' => 'Type',
	'Class:Location/Attribute:locationtype_id+' => 'Le type de lieu dont il s\'agit ou son utilité',
	'Class:Location/Attribute:parent_id' => 'Parent',
	'Class:Location/Attribute:parent_id+' => 'Lieu auquel celui est rattaché (ex : Pour une \'salle\', devrait être un \'étage\' ou un \'bâtiment\')',
	'Class:Location/Attribute:locations_list' => 'Lieux sous-jacents',
	'Class:Location/Attribute:locations_list+' => 'Liste des lieux inclus dans celui-ci',
	// - PhysicalDevice (default entries for custom classes)
	'Class:PhysicalDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PhysicalDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'du matériel'),
	'Class:PhysicalDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	// Note: Physical device can be either an host (eg. enclosure) or a device (eg. server), so we use a generic sentence
	'Class:PhysicalDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'du matériel', 'son hôte'),
	// - Rack
	'Class:Rack/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Rack/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'du rack'),
	// - Enclosure
	'Class:Enclosure/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:Enclosure/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'du châssis'),
	'Class:Enclosure/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:Enclosure/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:host'], 'du châssis', 'le rack'),
	'Enclosure:baseinfo' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Enclosure:moreinfo' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	'Enclosure:otherinfo' => sprintf($aMolkobainThesaurus['Fieldset:otherinfo']),
	'Enclosure:dates' => sprintf($aMolkobainThesaurus['Fieldset:dates']),
	// - Datacenter device
	'Class:DatacenterDevice/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:DatacenterDevice/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'du matériel'),
	'Class:DatacenterDevice/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:DatacenterDevice/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'du matériel'),
	// - PDU
	'Class:PDU/Attribute:nb_u' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u']),
	'Class:PDU/Attribute:nb_u+' => sprintf($aMolkobainThesaurus['Class/Attribute:nb_u+'], 'du PDU'),
	'Class:PDU/Attribute:position_v' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v']),
	'Class:PDU/Attribute:position_v+' => sprintf($aMolkobainThesaurus['Class/Attribute:position_v+/Variant:device'], 'du PDU'),
));

// UI
Dict::Add('FR FR', 'French', 'Français', array(
	'Molkobain:DatacenterView:Tabs:View:Title' => 'Représentation graphique',
	'Molkobain:DatacenterView:NoElement' => 'Aucun élément',
	// - Messages
	'Molkobain:DatacenterView:WarningMessage:NoHeightForHost' => 'Hauteur non définie pour l\'élément, les matériels peuvent ne pas s\'afficher correctement.',
	// - Legend
	'Molkobain:DatacenterView:Legend:Title' => 'Légende',
	// - Filter
	'Molkobain:DatacenterView:Filter:Title' => 'Filtrer',
	'Molkobain:DatacenterView:Filter:Description' => 'Trouver corresp. de noms ou numéros de série / asset',
	'Molkobain:DatacenterView:Filter:Input:Placeholder' => 'ex: PDU, SSD, 1234, ...',
	// - Options
	'Molkobain:DatacenterView:Options:Title' => 'Options',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete' => 'Afficher élém. obsolètes',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete+' => 'Modifier l\'option ne prendra le pas sur les préférences utilisateurs que pour cet élément',
	// - Tooltip
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:base-info' => sprintf($aMolkobainThesaurus['Fieldset:baseinfo']),
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:more-info' => sprintf($aMolkobainThesaurus['Fieldset:moreinfo']),
	// - Rack
	'Molkobain:DatacenterView:Rack:Panel:Front:Title' => 'Avant',
	// - Enclosure
	'Molkobain:DatacenterView:Enclosure:Panel:Front:Title' => 'Avant',
	// - Unmounted elements
	'Molkobain:DatacenterView:Unmounted:Toggler:Tooltip' => 'Ouvrir / Fermer',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => 'Châssis non montés',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => 'Rattachés à ce rack mais aucune position renseignée (Editer le châssis pour corriger)',
	'Molkobain:DatacenterView:Unmounted:Devices:Title' => 'Matériels non montés',
	'Molkobain:DatacenterView:Unmounted:Devices:Title+' => 'Rattachés à ce rack / châssis mais aucune position renseignée (Editer le matériel pour corriger)',
));
