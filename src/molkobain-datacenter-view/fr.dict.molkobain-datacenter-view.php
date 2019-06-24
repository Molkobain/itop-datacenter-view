<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */
Dict::Add('FR FR', 'French', 'Français', array(
	// Classes
	// - PhysicalDevice (default entries for custom classes)
	'Class:PhysicalDevice/Attribute:nb_u' => 'Hauteur',
	'Class:PhysicalDevice/Attribute:nb_u+' => 'Hauteur du matériel en unités (U)',
	'Class:PhysicalDevice/Attribute:position_v' => 'Position',
	'Class:PhysicalDevice/Attribute:position_v+' => 'Position verticale (U) du matériel dans le châssis (ou rack si monté directement dessus). Doit faire référence au bas du matériel et non au haut.',
	// - Rack
	'Class:Rack/Attribute:nb_u' => 'Hauteur',
	'Class:Rack/Attribute:nb_u+' => 'Hauteur du rack en unités (U)',
	// - Enclosure
	'Class:Enclosure/Attribute:nb_u' => 'Hauteur',
	'Class:Enclosure/Attribute:nb_u+' => 'Hauteur du châssis en unités (U)',
	'Class:Enclosure/Attribute:position_v' => 'Position',
	'Class:Enclosure/Attribute:position_v+' => 'Position verticale (U) du châssis dans le rack (Doit faire référence au bas du châssis et non au haut)',
	// - Datacenter device
	'Class:DatacenterDevice/Attribute:nb_u' => 'Hauteur',
	'Class:DatacenterDevice/Attribute:nb_u+' => 'Hauteur du matériel en unités (U)',
	'Class:DatacenterDevice/Attribute:position_v' => 'Position',
	'Class:DatacenterDevice/Attribute:position_v+' => 'Position verticale (U) du matériel dans le châssis (ou rack si monté directement dessus). Doit faire référence au bas du matériel et non au haut.',
	// - PDU
	'Class:PDU/Attribute:nb_u' => 'Hauteur',
	'Class:PDU/Attribute:nb_u+' => 'Hauteur du PDU en unités (U)',
	'Class:PDU/Attribute:position_v' => 'Position',
	'Class:PDU/Attribute:position_v+' => 'Position verticale (U) du PDU dans le châssis (ou rack si monté directement dessus). Doit faire référence au bas du PDU et non au haut.',

	// UI
	'Molkobain:DatacenterView:Tabs:View:Title' => 'Représentation graphique',
	'Molkobain:DatacenterView:NoElement' => 'Aucun élément',
	// - Legend
	'Molkobain:DatacenterView:Legend:Title' => 'Légende',
	// - Options
	'Molkobain:DatacenterView:Options:Title' => 'Options',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete' => 'Afficher élém. obsolètes',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete+' => 'Modifier l\'option ne prendra le pas sur les préférences utilisateurs que pour cet élément',
	// - Tooltip
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:base-info' => 'Informations générales',
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:more-info' => 'Informations complémentaires',
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
